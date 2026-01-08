<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiries extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Enquiry_model');
        $this->load->library(['form_validation', 'email', 'pagination']);
        $this->load->helper(['form', 'url', 'text']);
    }

    /**
     * List safari enquiries only (excludes Contact Form submissions)
     */
    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Safari Enquiries';

        $status = $this->input->get('status');
        $search = $this->input->get('search');
        $per_page = 20;
        $page = (int)$this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;

        // Only show safari enquiries (exclude Contact Form)
        $data['enquiries'] = $this->Enquiry_model->get_all_enquiries_admin($per_page, $offset, $status, $search, 'safari');
        $data['total_enquiries'] = $this->Enquiry_model->count_enquiries_admin($status, $search, 'safari');
        $data['stats'] = $this->Enquiry_model->get_admin_statistics('safari');
        
        $data['current_status'] = $status;
        $data['search'] = $search;
        $data['current_type'] = 'safari';
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($data['total_enquiries'] / $per_page);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/enquiries/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }
    
    /**
     * Redirect old contacts URL to new controller
     */
    public function contacts()
    {
        redirect('admin/contacts');
    }

    /**
     * View enquiry by UID
     * @param string $uid Enquiry UID
     */
    public function view($uid)
    {
        $enquiry = $this->Enquiry_model->get_enquiry_by_uid($uid);
        if (!$enquiry) {
            $this->session->set_flashdata('error', 'Enquiry not found.');
            redirect('admin/enquiries');
            return;
        }
        
        // Redirect contact form submissions to the contacts controller
        if ($enquiry->trip_type === 'Contact Form') {
            redirect('admin/contacts/view/' . $uid);
            return;
        }

        $this->Enquiry_model->mark_as_read($enquiry->id);

        $data = $this->get_admin_data();
        $data['page_title'] = 'View Enquiry - ' . $enquiry->reference_number;
        $data['enquiry'] = $enquiry;
        $data['notes'] = $this->Enquiry_model->get_notes($enquiry->id);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/enquiries/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Edit enquiry by UID
     * @param string $uid Enquiry UID
     */
    public function edit($uid)
    {
        $enquiry = $this->Enquiry_model->get_enquiry_by_uid($uid);
        if (!$enquiry) {
            $this->session->set_flashdata('error', 'Enquiry not found.');
            redirect('admin/enquiries');
            return;
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|min_length[2]|max_length[100]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|max_length[50]');
            $this->form_validation->set_rules('country', 'Country', 'trim|max_length[100]');
            $this->form_validation->set_rules('trip_type', 'Trip Type', 'trim');
            $this->form_validation->set_rules('duration', 'Duration', 'trim');
            $this->form_validation->set_rules('adults', 'Adults', 'integer');
            $this->form_validation->set_rules('children', 'Children', 'integer');
            $this->form_validation->set_rules('accommodation', 'Accommodation', 'trim');
            $this->form_validation->set_rules('budget', 'Budget', 'trim');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[new,read,replied,closed]');

            if ($this->form_validation->run() === TRUE) {
                $update_data = [
                    'full_name' => $this->input->post('full_name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'country' => $this->input->post('country', TRUE),
                    'trip_type' => $this->input->post('trip_type', TRUE),
                    'travel_date_from' => $this->input->post('travel_date_from') ?: null,
                    'travel_date_to' => $this->input->post('travel_date_to') ?: null,
                    'duration' => $this->input->post('duration', TRUE),
                    'adults' => (int)$this->input->post('adults') ?: 1,
                    'children' => (int)$this->input->post('children') ?: 0,
                    'children_ages' => $this->input->post('children_ages', TRUE),
                    'accommodation' => $this->input->post('accommodation', TRUE),
                    'budget' => $this->input->post('budget', TRUE),
                    'special_requirements' => $this->input->post('special_requirements', TRUE),
                    'status' => $this->input->post('status', TRUE),
                ];

                // Handle destinations (multi-select)
                $destinations = $this->input->post('destinations');
                if ($destinations && is_array($destinations)) {
                    $update_data['destinations'] = json_encode($destinations);
                }

                // Handle interests (multi-select)
                $interests = $this->input->post('interests');
                if ($interests && is_array($interests)) {
                    $update_data['interests'] = json_encode($interests);
                }

                if ($this->Enquiry_model->update_enquiry_by_uid($uid, $update_data)) {
                    $this->session->set_flashdata('success', 'Enquiry updated successfully.');
                    redirect('admin/enquiries/view/' . $uid);
                } else {
                    $this->session->set_flashdata('error', 'Failed to update enquiry.');
                }
            }
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Enquiry - ' . $enquiry->reference_number;
        $data['enquiry'] = $enquiry;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/enquiries/edit', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Update status by UID
     * @param string $uid Enquiry UID
     */
    public function update_status($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/enquiries');
            return;
        }

        $enquiry = $this->Enquiry_model->get_enquiry_by_uid($uid);
        if (!$enquiry) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Enquiry not found.']);
                return;
            }
            $this->session->set_flashdata('error', 'Enquiry not found.');
            redirect('admin/enquiries');
            return;
        }

        $status = $this->input->post('status');
        $valid_statuses = ['new', 'read', 'replied', 'closed'];
        
        if (!in_array($status, $valid_statuses)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Invalid status.']);
                return;
            }
            $this->session->set_flashdata('error', 'Invalid status.');
            redirect('admin/enquiries/view/' . $uid);
            return;
        }

        if ($this->Enquiry_model->update_enquiry_status($enquiry->id, $status)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => true, 'message' => 'Status updated successfully.', 'status' => $status]);
                return;
            }
            $this->session->set_flashdata('success', 'Status updated successfully.');
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
                return;
            }
            $this->session->set_flashdata('error', 'Failed to update status.');
        }

        redirect('admin/enquiries/view/' . $uid);
    }

    /**
     * Add note by UID
     * @param string $uid Enquiry UID
     */
    public function add_note($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/enquiries');
            return;
        }

        $enquiry = $this->Enquiry_model->get_enquiry_by_uid($uid);
        if (!$enquiry) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Enquiry not found.']);
                return;
            }
            $this->session->set_flashdata('error', 'Enquiry not found.');
            redirect('admin/enquiries');
            return;
        }

        $note = $this->input->post('note', TRUE);
        if (empty($note)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Note cannot be empty.']);
                return;
            }
            $this->session->set_flashdata('error', 'Note cannot be empty.');
            redirect('admin/enquiries/view/' . $uid);
            return;
        }

        $admin_id = $this->session->userdata('admin_id');
        
        if ($this->Enquiry_model->add_note($enquiry->id, $note, $admin_id)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Note added successfully.',
                    'note' => [
                        'note' => $note,
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                ]);
                return;
            }
            $this->session->set_flashdata('success', 'Note added successfully.');
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Failed to add note.']);
                return;
            }
            $this->session->set_flashdata('error', 'Failed to add note.');
        }

        redirect('admin/enquiries/view/' . $uid);
    }

    /**
     * Reply to enquiry by UID
     * @param string $uid Enquiry UID
     */
    public function reply($uid)
    {
        $enquiry = $this->Enquiry_model->get_enquiry_by_uid($uid);
        if (!$enquiry) {
            $this->session->set_flashdata('error', 'Enquiry not found.');
            redirect('admin/enquiries');
            return;
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
            $this->form_validation->set_rules('message', 'Message', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $subject = $this->input->post('subject', TRUE);
                $message = $this->input->post('message');

                // Email configuration
                $config = [
                    'protocol' => 'smtp',
                    'smtp_host' => 'smtp.gmail.com',
                    'smtp_port' => 587,
                    'smtp_user' => 'lembris.internet@gmail.com',
                    'smtp_pass' => 'oaau mhwh fevr fhhy',
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'smtp_crypto' => 'tls',
                    'newline' => "\r\n",
                ];

                try {
                    $this->email->initialize($config);
                    $this->email->from('lembris.internet@gmail.com', 'Osiram Safari Adventure');
                    $this->email->to($enquiry->email);
                    $this->email->subject($subject);
                    $this->email->message($message);

                    if (@$this->email->send()) {
                        $this->Enquiry_model->update_enquiry_status($enquiry->id, 'replied');
                        $this->Enquiry_model->add_note($enquiry->id, 'Email reply sent: ' . $subject, $this->session->userdata('admin_id'));
                        $this->session->set_flashdata('success', 'Reply sent successfully.');
                        redirect('admin/enquiries/view/' . $uid);
                    } else {
                        log_message('error', 'ENQUIRY REPLY EMAIL FAILED: ' . $this->email->print_debugger(['headers']));
                        $this->session->set_flashdata('error', 'Failed to send email. Please try again later.');
                    }
                } catch (Exception $e) {
                    log_message('error', 'ENQUIRY REPLY EMAIL EXCEPTION: ' . $e->getMessage());
                    $this->session->set_flashdata('error', 'Email service unavailable. Please try again later.');
                }
            }
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Reply to Enquiry - ' . $enquiry->reference_number;
        $data['enquiry'] = $enquiry;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/enquiries/reply', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Send custom email to enquiry customer
     * @param string $uid Enquiry UID
     */
    public function send_email($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/enquiries/view/' . $uid);
            return;
        }

        $enquiry = $this->Enquiry_model->get_enquiry_by_uid($uid);
        
        if (!$enquiry) {
            $this->session->set_flashdata('error', 'Enquiry not found.');
            redirect('admin/enquiries');
            return;
        }

        $subject = $this->input->post('email_subject');
        $message = $this->input->post('email_message');

        if (empty($subject) || empty($message)) {
            $this->session->set_flashdata('error', 'Subject and message are required.');
            redirect('admin/enquiries/view/' . $uid);
            return;
        }

        $this->load->model('Settings_model');
        $settings = $this->Settings_model->get_all();

        $config = [
            'protocol' => 'smtp',
            'smtp_host' => $settings['smtp_host'] ?? 'smtp.gmail.com',
            'smtp_port' => $settings['smtp_port'] ?? 587,
            'smtp_user' => $settings['smtp_username'] ?? '',
            'smtp_pass' => $settings['smtp_password'] ?? '',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'smtp_crypto' => $settings['smtp_encryption'] ?? 'tls',
            'newline' => "\r\n",
            'smtp_timeout' => 10,
        ];

        $this->email->clear();
        $this->email->initialize($config);
        $this->email->from($settings['site_email'] ?? 'noreply@example.com', $settings['site_name'] ?? 'Safari Adventure');
        $this->email->to($enquiry->email);
        $this->email->subject($subject);
        $this->email->message($this->build_email_template($enquiry, $message, $settings));

        if ($this->email->send()) {
            // Update status to replied and add note
            $this->Enquiry_model->update_enquiry_status($enquiry->id, 'replied');
            $this->Enquiry_model->add_note($enquiry->id, 'Email sent: ' . $subject, $this->session->userdata('admin_id'));
            $this->session->set_flashdata('success', 'Email sent successfully to ' . $enquiry->email);
        } else {
            log_message('error', 'Enquiry email failed: ' . $this->email->print_debugger(['headers']));
            $this->session->set_flashdata('error', 'Failed to send email. Please check your email settings.');
        }

        redirect('admin/enquiries/view/' . $uid);
    }

    /**
     * Build email template wrapper for enquiry emails
     */
    private function build_email_template($enquiry, $message, $settings)
    {
        $site_name = $settings['site_name'] ?? 'Safari Adventure';
        $site_email = $settings['site_email'] ?? 'info@example.com';
        $site_phone = $settings['site_phone'] ?? '';
        $site_logo = !empty($settings['site_logo']) ? base_url('assets/images/' . $settings['site_logo']) : '';
        
        $logo_html = '';
        if (!empty($site_logo)) {
            $logo_html = '<img src="' . $site_logo . '" alt="' . htmlspecialchars($site_name) . '" style="max-height: 60px; margin-bottom: 10px;">';
        }
        
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #0d6efd, #198754); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8f9fa; padding: 30px; }
                .enquiry-ref { background: #fff; padding: 15px; border-left: 4px solid #0d6efd; margin: 20px 0; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; background: #e9ecef; border-radius: 0 0 10px 10px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    ' . $logo_html . '
                    <h1 style="margin:0;">🦁 ' . htmlspecialchars($site_name) . '</h1>
                </div>
                
                <div class="content">
                    <div class="enquiry-ref">
                        <strong>Enquiry Reference:</strong> ' . htmlspecialchars($enquiry->reference_number) . '
                    </div>
                    
                    ' . nl2br(htmlspecialchars($message)) . '
                </div>
                
                <div class="footer">
                    <p><strong>' . htmlspecialchars($site_name) . '</strong></p>
                    <p>📞 ' . htmlspecialchars($site_phone) . ' | ✉️ ' . htmlspecialchars($site_email) . '</p>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Delete enquiry by UID
     * @param string $uid Enquiry UID
     */
    public function delete($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/enquiries');
            return;
        }

        $enquiry = $this->Enquiry_model->get_enquiry_by_uid($uid);
        if (!$enquiry) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Enquiry not found.']);
                return;
            }
            $this->session->set_flashdata('error', 'Enquiry not found.');
            redirect('admin/enquiries');
            return;
        }

        if ($this->Enquiry_model->delete_enquiry_by_uid($uid)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => true, 'message' => 'Enquiry deleted successfully.']);
                return;
            }
            $this->session->set_flashdata('success', 'Enquiry deleted successfully.');
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Failed to delete enquiry.']);
                return;
            }
            $this->session->set_flashdata('error', 'Failed to delete enquiry.');
        }

        redirect('admin/enquiries');
    }

    /**
     * Export enquiries to CSV
     */
    public function export()
    {
        $status = $this->input->get('status');
        $enquiries = $this->Enquiry_model->get_enquiries_for_export($status);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="enquiries_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Reference', 'Name', 'Email', 'Phone', 'Country', 'Trip Type', 'Duration', 'Adults', 'Children', 'Accommodation', 'Budget', 'Status', 'Date']);

        foreach ($enquiries as $enq) {
            fputcsv($output, [
                $enq->reference_number,
                $enq->full_name,
                $enq->email,
                $enq->phone ?? '',
                $enq->country ?? '',
                $enq->trip_type ?? '',
                $enq->duration ?? '',
                $enq->adults ?? 1,
                $enq->children ?? 0,
                $enq->accommodation ?? '',
                $enq->budget ?? '',
                $enq->status,
                $enq->created_at
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Setup database for enquiries (add UID column if missing)
     */
    public function setup()
    {
        $this->load->dbforge();
        $results = [];

        // Check if uid column exists
        $fields = $this->db->field_data('contact_enquiries');
        $existing_fields = array_column($fields, 'name');

        if (!in_array('uid', $existing_fields)) {
            $this->dbforge->add_column('contact_enquiries', [
                'uid' => ['type' => 'VARCHAR', 'constraint' => 36, 'null' => TRUE, 'after' => 'id']
            ]);
            $results[] = 'Added uid column';

            // Generate UIDs for existing enquiries
            $existing = $this->db->where('uid IS NULL')->get('contact_enquiries')->result();
            foreach ($existing as $enquiry) {
                $uid = sprintf(
                    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0x0fff) | 0x4000,
                    mt_rand(0, 0x3fff) | 0x8000,
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                );
                $this->db->where('id', $enquiry->id)->update('contact_enquiries', ['uid' => $uid]);
            }
            $results[] = 'Generated UIDs for ' . count($existing) . ' existing enquiries';
        } else {
            $results[] = 'uid column already exists';
        }

        echo json_encode(['success' => true, 'results' => $results]);
    }
}
