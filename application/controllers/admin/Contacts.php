<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Contact_model');
        $this->load->library(['form_validation', 'email', 'pagination']);
        $this->load->helper(['form', 'url', 'text']);
    }

    /**
     * List contact form queries
     */
    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Contact Queries';
        
        $this->load->helper('template');
        $theme = get_active_template();
        
        $status = $this->input->get('status');
        $search = $this->input->get('search');
        $per_page = 20;
        $page = (int)$this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;

        $data['enquiries'] = $this->Contact_model->get_all_contacts($per_page, $offset, $status, $search, $theme);
        $data['total_enquiries'] = $this->Contact_model->count_contacts($status, $search, $theme);
        $data['stats'] = $this->Contact_model->get_statistics();
        
        $data['current_status'] = $status;
        $data['search'] = $search;
        $data['current_type'] = 'contact';
        $data['is_contact_page'] = true;
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($data['total_enquiries'] / $per_page);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/contacts/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * View contact form submission by UID
     * @param string $uid Contact UID
     */
    public function view($uid)
    {
        $enquiry = $this->Contact_model->get_contact_by_uid($uid);
        if (!$enquiry) {
            $this->session->set_flashdata('error', 'Contact not found.');
            redirect('admin/contacts');
            return;
        }

        $this->Contact_model->mark_as_read($enquiry->id);
        
        // Parse the special_requirements to extract subject and message
        $subject = '';
        $message = '';
        if (!empty($enquiry->special_requirements)) {
            if (preg_match('/^Subject:\s*(.+?)(?:\n\nMessage:\n(.*))?$/s', $enquiry->special_requirements, $matches)) {
                $subject = trim($matches[1] ?? '');
                $message = trim($matches[2] ?? '');
            } else {
                $message = $enquiry->special_requirements;
            }
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'View Contact - ' . $enquiry->reference_number;
        $data['enquiry'] = $enquiry;
        $data['contact_subject'] = $subject;
        $data['contact_message'] = $message;
        $data['notes'] = $this->Contact_model->get_notes($enquiry->id);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/contacts/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Update contact status by UID
     * @param string $uid Contact UID
     */
    public function update_status($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/contacts');
            return;
        }

        $enquiry = $this->Contact_model->get_contact_by_uid($uid);
        if (!$enquiry) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Contact not found.']);
                return;
            }
            $this->session->set_flashdata('error', 'Contact not found.');
            redirect('admin/contacts');
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
            redirect('admin/contacts/view/' . $uid);
            return;
        }

        if ($this->Contact_model->update_status($enquiry->id, $status)) {
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

        redirect('admin/contacts/view/' . $uid);
    }

    /**
     * Add note to contact by UID
     * @param string $uid Contact UID
     */
    public function add_note($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/contacts');
            return;
        }

        $enquiry = $this->Contact_model->get_contact_by_uid($uid);
        if (!$enquiry) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Contact not found.']);
                return;
            }
            $this->session->set_flashdata('error', 'Contact not found.');
            redirect('admin/contacts');
            return;
        }

        $note = $this->input->post('note', TRUE);
        if (empty($note)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Note cannot be empty.']);
                return;
            }
            $this->session->set_flashdata('error', 'Note cannot be empty.');
            redirect('admin/contacts/view/' . $uid);
            return;
        }

        $admin_id = $this->session->userdata('admin_id');
        
        if ($this->Contact_model->add_note($enquiry->id, $note, $admin_id)) {
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

        redirect('admin/contacts/view/' . $uid);
    }

    /**
     * Reply to contact by UID
     * @param string $uid Contact UID
     */
    public function reply($uid)
    {
        $enquiry = $this->Contact_model->get_contact_by_uid($uid);
        if (!$enquiry) {
            $this->session->set_flashdata('error', 'Contact not found.');
            redirect('admin/contacts');
            return;
        }

        // Parse the special_requirements to extract subject and message
        $subject = '';
        $message = '';
        if (!empty($enquiry->special_requirements)) {
            if (preg_match('/^Subject:\s*(.+?)(?:\n\nMessage:\n(.*))?$/s', $enquiry->special_requirements, $matches)) {
                $subject = trim($matches[1] ?? '');
                $message = trim($matches[2] ?? '');
            } else {
                $message = $enquiry->special_requirements;
            }
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
            $this->form_validation->set_rules('message', 'Message', 'required|trim');

            if ($this->form_validation->run() === TRUE) {
                $email_subject = $this->input->post('subject', TRUE);
                $email_message = $this->input->post('message');

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
                    $this->email->subject($email_subject);
                    $this->email->message($email_message);

                    if (@$this->email->send()) {
                        $this->Contact_model->update_status($enquiry->id, 'replied');
                        $this->Contact_model->add_note($enquiry->id, 'Email reply sent: ' . $email_subject, $this->session->userdata('admin_id'));
                        $this->session->set_flashdata('success', 'Reply sent successfully.');
                        redirect('admin/contacts/view/' . $uid);
                    } else {
                        log_message('error', 'CONTACT REPLY EMAIL FAILED: ' . $this->email->print_debugger(['headers']));
                        $this->session->set_flashdata('error', 'Failed to send email. Please try again later.');
                    }
                } catch (Exception $e) {
                    log_message('error', 'CONTACT REPLY EMAIL EXCEPTION: ' . $e->getMessage());
                    $this->session->set_flashdata('error', 'Email service unavailable. Please try again later.');
                }
            }
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Reply to Contact - ' . $enquiry->reference_number;
        $data['enquiry'] = $enquiry;
        $data['contact_subject'] = $subject;
        $data['contact_message'] = $message;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/contacts/reply', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Send email to contact
     * @param string $uid Contact UID
     */
    public function send_email($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/contacts/view/' . $uid);
            return;
        }

        $enquiry = $this->Contact_model->get_contact_by_uid($uid);
        
        if (!$enquiry) {
            $this->session->set_flashdata('error', 'Contact not found.');
            redirect('admin/contacts');
            return;
        }

        $subject = $this->input->post('email_subject');
        $message = $this->input->post('email_message');

        if (empty($subject) || empty($message)) {
            $this->session->set_flashdata('error', 'Subject and message are required.');
            redirect('admin/contacts/view/' . $uid);
            return;
        }

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

        $this->email->clear();
        $this->email->initialize($config);
        $this->email->from('lembris.internet@gmail.com', 'Osiram Safari Adventure');
        $this->email->to($enquiry->email);
        $this->email->subject($subject);
        $this->email->message($this->build_email_template($enquiry, $message));

        if ($this->email->send()) {
            $this->Contact_model->update_status($enquiry->id, 'replied');
            $this->Contact_model->add_note($enquiry->id, 'Email sent: ' . $subject, $this->session->userdata('admin_id'));
            $this->session->set_flashdata('success', 'Email sent successfully to ' . $enquiry->email);
        } else {
            log_message('error', 'Contact email failed: ' . $this->email->print_debugger(['headers']));
            $this->session->set_flashdata('error', 'Failed to send email. Please check your email settings.');
        }

        redirect('admin/contacts/view/' . $uid);
    }

    /**
     * Build email template for contact replies
     */
    private function build_email_template($enquiry, $message)
    {
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
                .ref { background: #fff; padding: 15px; border-left: 4px solid #0d6efd; margin: 20px 0; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; background: #e9ecef; border-radius: 0 0 10px 10px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1 style="margin:0;">🦁 Osiram Safari Adventure</h1>
                </div>
                
                <div class="content">
                    <div class="ref">
                        <strong>Reference:</strong> ' . htmlspecialchars($enquiry->reference_number) . '
                    </div>
                    
                    ' . nl2br(htmlspecialchars($message)) . '
                </div>
                
                <div class="footer">
                    <p><strong>Osiram Safari Adventure</strong></p>
                    <p>📞 +255 789 356 961 | ✉️ welcome@osiramsafari.com</p>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Delete contact by UID
     * @param string $uid Contact UID
     */
    public function delete($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/contacts');
            return;
        }

        $enquiry = $this->Contact_model->get_contact_by_uid($uid);
        if (!$enquiry) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Contact not found.']);
                return;
            }
            $this->session->set_flashdata('error', 'Contact not found.');
            redirect('admin/contacts');
            return;
        }

        if ($this->Contact_model->delete_contact_by_uid($uid)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => true, 'message' => 'Contact deleted successfully.']);
                return;
            }
            $this->session->set_flashdata('success', 'Contact deleted successfully.');
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Failed to delete contact.']);
                return;
            }
            $this->session->set_flashdata('error', 'Failed to delete contact.');
        }

        redirect('admin/contacts');
    }

    /**
     * Export contacts to CSV
     */
    public function export()
    {
        $status = $this->input->get('status');
        $contacts = $this->Contact_model->get_contacts_for_export($status);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="contacts_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Reference', 'Name', 'Email', 'Subject', 'Message', 'Status', 'Date']);

        foreach ($contacts as $contact) {
            $subject = '';
            $message = '';
            if (!empty($contact->special_requirements)) {
                if (preg_match('/^Subject:\s*(.+?)(?:\n\nMessage:\n(.*))?$/s', $contact->special_requirements, $matches)) {
                    $subject = trim($matches[1] ?? '');
                    $message = trim($matches[2] ?? '');
                } else {
                    $message = $contact->special_requirements;
                }
            }
            
            fputcsv($output, [
                $contact->reference_number,
                $contact->full_name,
                $contact->email,
                $subject,
                $message,
                $contact->status,
                $contact->created_at
            ]);
        }

        fclose($output);
        exit;
    }
}
