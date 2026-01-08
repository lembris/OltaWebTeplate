<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BulkNotifications extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['BulkNotification_model', 'ContactGroup_model']);
        $this->load->library(['form_validation', 'email']);
        $this->load->helper(['form', 'url']);
        
        // Ensure sms_provider_id column exists
        $this->_ensure_sms_provider_column();
    }
    
    /**
     * Add sms_provider_id column if it doesn't exist
     */
    private function _ensure_sms_provider_column()
    {
        if (!$this->db->field_exists('sms_provider_id', 'bulk_notifications')) {
            $this->load->dbforge();
            $this->dbforge->add_column('bulk_notifications', [
                'sms_provider_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'null' => TRUE,
                    'after' => 'target_groups'
                ]
            ]);
        }
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Bulk Notifications';
        $data['notifications'] = $this->BulkNotification_model->get_all(100, 0);
        $data['stats'] = $this->BulkNotification_model->get_stats();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/bulk-notifications/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Create Notification';
        $data['groups'] = $this->ContactGroup_model->get_all_with_counts();
        $data['templates'] = $this->BulkNotification_model->get_templates();
        $data['notification'] = null;
        $data['form_action'] = base_url('admin/bulk-notifications/create');
        
        // Load SMS providers
        $this->load->model('Sms_provider_model');
        $data['sms_providers'] = $this->Sms_provider_model->get_active();

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Subject', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('message', 'Message', 'required');
            
            // Require recipients when sending or scheduling (not for drafts)
            $action = $this->input->post('action');
            if ($action === 'send_now' || $action === 'schedule') {
                $this->form_validation->set_rules('target_groups[]', 'Recipients', 'required', [
                    'required' => 'Please select at least one recipient group.'
                ]);
            }

            if ($this->form_validation->run() === TRUE) {
                $target_groups = $this->input->post('target_groups');
                $scheduled_at = $this->input->post('scheduled_at', TRUE);
                
                $status = 'draft';
                if ($action === 'send_now') {
                    $status = 'sending';
                } elseif ($action === 'schedule' && !empty($scheduled_at)) {
                    $status = 'scheduled';
                }

                $type = $this->input->post('type', TRUE) ?: 'email';
                $sms_provider_id = null;
                if (in_array($type, ['sms', 'both'])) {
                    $sms_provider_id = $this->input->post('sms_provider_id', TRUE);
                }
                
                $notification_data = [
                    'title' => $this->input->post('title', TRUE),
                    'message' => $this->input->post('message', TRUE),
                    'message_html' => $this->input->post('message_html'),
                    'type' => $type,
                    'priority' => $this->input->post('priority', TRUE) ?: 'normal',
                    'target_groups' => json_encode($target_groups),
                    'sms_provider_id' => $sms_provider_id,
                    'scheduled_at' => !empty($scheduled_at) ? $scheduled_at : null,
                    'status' => $status,
                    'created_by' => $this->session->userdata('admin_id'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $notification_id = $this->BulkNotification_model->create($notification_data);
                
                if ($notification_id) {
                    // Get recipients from selected groups
                    $recipients = $this->ContactGroup_model->get_emails_from_groups($target_groups);
                    
                    // Add recipients to notification
                    $recipient_data = [];
                    foreach ($recipients as $r) {
                        $recipient_data[] = [
                            'type' => 'contact',
                            'name' => $r->name,
                            'email' => $r->email,
                            'phone' => $r->phone ?? ''
                        ];
                    }
                    $this->BulkNotification_model->add_recipients($notification_id, $recipient_data);
                    
                    // If send now, process immediately
                    if ($status === 'sending') {
                        $this->process_notification($notification_id);
                        $this->session->set_flashdata('success', 'Notification sent successfully.');
                    } elseif ($status === 'scheduled') {
                        $this->session->set_flashdata('success', 'Notification scheduled successfully.');
                    } else {
                        $this->session->set_flashdata('success', 'Notification saved as draft.');
                    }
                    
                    redirect('admin/bulk-notifications');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create notification.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/bulk-notifications/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function view($uid)
    {
        $notification = $this->BulkNotification_model->get_by_uid($uid);
        if (!$notification) {
            $this->session->set_flashdata('error', 'Notification not found.');
            redirect('admin/bulk-notifications');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'View Notification';
        $data['notification'] = $notification;
        $data['recipients'] = $this->BulkNotification_model->get_recipients($notification->id);
        $data['recipient_stats'] = $this->BulkNotification_model->get_recipient_stats($notification->id);

        // Get group names
        $group_ids = json_decode($notification->target_groups, true) ?? [];
        $data['target_group_names'] = [];
        foreach ($group_ids as $gid) {
            $group = $this->ContactGroup_model->get_by_id($gid);
            if ($group) {
                $data['target_group_names'][] = $group->name;
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/bulk-notifications/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $notification = $this->BulkNotification_model->get_by_uid($uid);
        if (!$notification) {
            $this->session->set_flashdata('error', 'Notification not found.');
            redirect('admin/bulk-notifications');
        }

        // Only drafts can be edited
        if ($notification->status !== 'draft') {
            $this->session->set_flashdata('error', 'Only draft notifications can be edited.');
            redirect('admin/bulk-notifications/view/' . $uid);
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Notification';
        $data['groups'] = $this->ContactGroup_model->get_all_with_counts();
        $data['templates'] = $this->BulkNotification_model->get_templates();
        $data['notification'] = $notification;
        $data['form_action'] = base_url('admin/bulk-notifications/edit/' . $uid);
        $data['is_edit'] = true;
        
        // Load SMS providers
        $this->load->model('Sms_provider_model');
        $data['sms_providers'] = $this->Sms_provider_model->get_active();
        
        // Get currently selected groups
        $data['selected_groups'] = json_decode($notification->target_groups, true) ?? [];

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Subject', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('message', 'Message', 'required');
            
            // Require recipients when sending or scheduling (not for drafts)
            $action = $this->input->post('action');
            if ($action === 'send_now' || $action === 'schedule') {
                $this->form_validation->set_rules('target_groups[]', 'Recipients', 'required', [
                    'required' => 'Please select at least one recipient group.'
                ]);
            }

            if ($this->form_validation->run() === TRUE) {
                $target_groups = $this->input->post('target_groups') ?: [];
                $scheduled_at = $this->input->post('scheduled_at', TRUE);
                
                $status = 'draft';
                if ($action === 'send_now') {
                    $status = 'sending';
                } elseif ($action === 'schedule' && !empty($scheduled_at)) {
                    $status = 'scheduled';
                }

                $type = $this->input->post('type', TRUE) ?: 'email';
                $sms_provider_id = null;
                if (in_array($type, ['sms', 'both'])) {
                    $sms_provider_id = $this->input->post('sms_provider_id', TRUE);
                }
                
                $update_data = [
                    'title' => $this->input->post('title', TRUE),
                    'message' => $this->input->post('message', TRUE),
                    'message_html' => $this->input->post('message_html'),
                    'type' => $type,
                    'priority' => $this->input->post('priority', TRUE) ?: 'normal',
                    'target_groups' => json_encode($target_groups),
                    'sms_provider_id' => $sms_provider_id,
                    'scheduled_at' => !empty($scheduled_at) ? $scheduled_at : null,
                    'status' => $status,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->BulkNotification_model->update_by_uid($uid, $update_data)) {
                    // Clear old recipients and add new ones
                    $this->db->where('notification_id', $notification->id)->delete('notification_recipients');
                    
                    if (!empty($target_groups)) {
                        $recipients = $this->ContactGroup_model->get_emails_from_groups($target_groups);
                        $recipient_data = [];
                        foreach ($recipients as $r) {
                            $recipient_data[] = [
                                'type' => 'contact',
                                'name' => $r->name,
                                'email' => $r->email,
                                'phone' => $r->phone ?? ''
                            ];
                        }
                        $this->BulkNotification_model->add_recipients($notification->id, $recipient_data);
                    }
                    
                    // If send now, process immediately
                    if ($status === 'sending') {
                        $this->process_notification($notification->id);
                        $this->session->set_flashdata('success', 'Notification updated and sent successfully.');
                    } elseif ($status === 'scheduled') {
                        $this->session->set_flashdata('success', 'Notification updated and scheduled successfully.');
                    } else {
                        $this->session->set_flashdata('success', 'Notification updated successfully.');
                    }
                    
                    redirect('admin/bulk-notifications/view/' . $uid);
                } else {
                    $this->session->set_flashdata('error', 'Failed to update notification.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/bulk-notifications/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function send($uid)
    {
        $notification = $this->BulkNotification_model->get_by_uid($uid);
        if (!$notification) {
            $this->session->set_flashdata('error', 'Notification not found.');
            redirect('admin/bulk-notifications');
        }

        if (!in_array($notification->status, ['draft', 'scheduled', 'failed'])) {
            $this->session->set_flashdata('error', 'This notification cannot be sent.');
            redirect('admin/bulk-notifications');
        }

        // For draft notifications, ensure recipients are populated from target groups
        $pending_recipients = $this->BulkNotification_model->get_recipients($notification->id, 'pending');
        if (empty($pending_recipients)) {
            // Re-add recipients from target groups
            $target_groups = json_decode($notification->target_groups, true);
            if (!empty($target_groups)) {
                $recipients = $this->ContactGroup_model->get_emails_from_groups($target_groups);
                
                if (!empty($recipients)) {
                    $recipient_data = [];
                    foreach ($recipients as $r) {
                        $recipient_data[] = [
                            'type' => 'contact',
                            'name' => $r->name,
                            'email' => $r->email,
                            'phone' => $r->phone ?? ''
                        ];
                    }
                    $this->BulkNotification_model->add_recipients($notification->id, $recipient_data);
                }
            }
            
            // Re-check for recipients
            $pending_recipients = $this->BulkNotification_model->get_recipients($notification->id, 'pending');
            if (empty($pending_recipients)) {
                $this->session->set_flashdata('error', 'No recipients found for this notification. Please check target groups.');
                redirect('admin/bulk-notifications/view/' . $uid);
            }
        }

        $this->BulkNotification_model->update_status($notification->id, 'sending');
        $this->process_notification($notification->id);
        
        $this->session->set_flashdata('success', 'Notification sent successfully.');
        redirect('admin/bulk-notifications/view/' . $uid);
    }

    public function delete($uid)
    {
        $notification = $this->BulkNotification_model->get_by_uid($uid);
        if (!$notification) {
            $this->session->set_flashdata('error', 'Notification not found.');
            redirect('admin/bulk-notifications');
        }

        if ($this->BulkNotification_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Notification deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete notification.');
        }

        redirect('admin/bulk-notifications');
    }

    public function cancel($uid)
    {
        $notification = $this->BulkNotification_model->get_by_uid($uid);
        if (!$notification || $notification->status !== 'scheduled') {
            $this->session->set_flashdata('error', 'Cannot cancel this notification.');
            redirect('admin/bulk-notifications');
        }

        $this->BulkNotification_model->update_status($notification->id, 'cancelled');
        $this->session->set_flashdata('success', 'Scheduled notification cancelled.');
        redirect('admin/bulk-notifications');
    }

    public function duplicate($uid)
    {
        $notification = $this->BulkNotification_model->get_by_uid($uid);
        if (!$notification) {
            $this->session->set_flashdata('error', 'Notification not found.');
            redirect('admin/bulk-notifications');
        }

        $new_data = [
            'title' => $notification->title . ' (Copy)',
            'message' => $notification->message,
            'message_html' => $notification->message_html,
            'type' => $notification->type,
            'priority' => $notification->priority,
            'target_groups' => $notification->target_groups,
            'status' => 'draft',
            'created_by' => $this->session->userdata('admin_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->BulkNotification_model->create($new_data)) {
            $this->session->set_flashdata('success', 'Notification duplicated as draft.');
        } else {
            $this->session->set_flashdata('error', 'Failed to duplicate notification.');
        }

        redirect('admin/bulk-notifications');
    }

    // ===== EMAIL PROCESSING =====

    private function process_notification($notification_id)
    {
        $notification = $this->BulkNotification_model->get_by_id($notification_id);
        if (!$notification) {
            return false;
        }

        $recipients = $this->BulkNotification_model->get_recipients($notification_id, 'pending');
        $sent_count = 0;
        $failed_count = 0;

        // Load settings for email config
        $this->load->model('Settings_model');
        $settings = $this->Settings_model->get_all();

        // Configure email
        $config = [
            'protocol' => $settings['smtp_protocol'] ?? 'smtp',
            'smtp_host' => $settings['smtp_host'] ?? 'localhost',
            'smtp_port' => (int)($settings['smtp_port'] ?? 587),
            'smtp_user' => $settings['smtp_user'] ?? '',
            'smtp_pass' => $settings['smtp_pass'] ?? '',
            'smtp_crypto' => $settings['smtp_crypto'] ?? 'tls',
            'smtp_timeout' => 10,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'newline' => "\r\n",
            'validate' => TRUE
        ];
        
        $this->email->initialize($config);
        
        $from_email = $settings['site_email'] ?? 'noreply@example.com';
        $from_name = $settings['site_name'] ?? 'Institution';

        foreach ($recipients as $recipient) {
            if (empty($recipient->recipient_email)) {
                $this->BulkNotification_model->update_recipient_status($recipient->id, 'failed', [
                    'error_message' => 'No email address'
                ]);
                $failed_count++;
                continue;
            }

            try {
                // Clear email before each send
                $this->email->clear(TRUE);
                
                $this->email->from($from_email, $from_name);
                $this->email->to($recipient->recipient_email);
                $this->email->subject($notification->title);
                
                // Process message with recipient name
                $message = $notification->message_html ?: nl2br($notification->message);
                $message = str_replace('{{recipient_name}}', $recipient->recipient_name, $message);
                $message = str_replace('{{name}}', $recipient->recipient_name, $message);
                
                $this->email->message($message);

                if ($this->email->send(FALSE)) {
                    $this->BulkNotification_model->update_recipient_status($recipient->id, 'sent', [
                        'sent_at' => date('Y-m-d H:i:s')
                    ]);
                    $this->BulkNotification_model->increment_sent($notification_id);
                    $sent_count++;
                } else {
                    $error_msg = $this->email->print_debugger();
                    $error_msg = strip_tags($error_msg);
                    $this->BulkNotification_model->update_recipient_status($recipient->id, 'failed', [
                        'error_message' => substr($error_msg, 0, 500)
                    ]);
                    $this->BulkNotification_model->increment_failed($notification_id);
                    $failed_count++;
                }
            } catch (Exception $e) {
                $this->BulkNotification_model->update_recipient_status($recipient->id, 'failed', [
                    'error_message' => substr($e->getMessage(), 0, 500)
                ]);
                $this->BulkNotification_model->increment_failed($notification_id);
                $failed_count++;
            }
        }

        // Update notification status
        $final_status = ($failed_count > 0 && $sent_count == 0) ? 'failed' : 'sent';
        $this->BulkNotification_model->update_status($notification_id, $final_status, [
            'sent_at' => date('Y-m-d H:i:s')
        ]);

        return ['sent' => $sent_count, 'failed' => $failed_count];
    }

    // ===== TEMPLATES =====

    public function templates()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Notification Templates';
        $data['templates'] = $this->BulkNotification_model->get_templates();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/bulk-notifications/templates', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function get_template_json($id)
    {
        $template = $this->BulkNotification_model->get_template_by_id($id);
        header('Content-Type: application/json');
        echo json_encode($template);
    }

    public function preview_recipients()
    {
        $group_ids = $this->input->post('groups');
        
        if (empty($group_ids)) {
            echo json_encode(['count' => 0, 'recipients' => []]);
            return;
        }

        $recipients = $this->ContactGroup_model->get_emails_from_groups($group_ids);
        
        header('Content-Type: application/json');
        echo json_encode([
            'count' => count($recipients),
            'recipients' => array_slice($recipients, 0, 10) // Preview first 10
        ]);
    }
}
