<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends CI_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->model(array('Model_common'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['site_name'] = 'Osiram Safari Adventure';
        $data['site_tag'] = 'Tour Operators';
        $data['site_name_abb'] = 'OSA';
        $data['main_page'] = '';

        $data['current_page_name'] = 'Appointment';
        $data['consult_number'] = '+255 78 703 3777';
        $data['consult_number_call'] = '255787033777';
        $data['work_hours'] = '9:00AM - 8:00PM';
        $data['address_location'] = 'Suite 3, Mezzanine Floor, R-Square, Plot No. 274, Haile Selassie Road, Opp. IST School, Masaki, P.O. Box 779, Dar es Salaam.';
        $data['email_address']  = 'welcome@osiramsafari.com';
    
        // Social Links
        $data['facebook'] = 'osiramsafariadventure';
        $data['instagram'] = 'osiramsafariadventure';
        $data['linkedin'] = 'company/osiramsafariadventure/';
        $data['twitter'] = '';
        $data['youtube'] = '';

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/appointment', $data);
        $this->load->view('includes/footer', $data);
    }

    /**
     * ========================================
     * SECURITY HELPER METHODS
     * ========================================
     */
    
    /**
     * Check honeypot field - bots will fill this
     */
    private function check_honeypot()
    {
        $honeypot = $this->input->post('website_url');
        return empty($honeypot);
    }
    
    /**
     * Rate limiting - prevent form flooding
     */
    private function check_rate_limit($form_type = 'appointment')
    {
        $session_key = $form_type . '_submissions';
        $time_key = $form_type . '_last_submit';
        
        $submissions = $this->session->userdata($session_key) ?? 0;
        $last_submit = $this->session->userdata($time_key) ?? 0;
        
        // Allow max 5 submissions per hour
        if ($submissions >= 5 && (time() - $last_submit) < 3600) {
            return false;
        }
        
        // Reset counter if more than an hour has passed
        if ((time() - $last_submit) >= 3600) {
            $submissions = 0;
        }
        
        // Update session
        $this->session->set_userdata($session_key, $submissions + 1);
        $this->session->set_userdata($time_key, time());
        
        return true;
    }
    
    /**
     * Sanitize input string
     */
    private function sanitize_input($input)
    {
        $input = trim($input);
        $input = strip_tags($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        return $this->security->xss_clean($input);
    }
    
    /**
     * Validate email format strictly
     */
    private function is_valid_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && 
               preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email);
    }
    
    /**
     * Check for spam keywords in message
     */
    private function contains_spam($text)
    {
        $spam_keywords = [
            'viagra', 'cialis', 'casino', 'lottery', 'winner', 
            'bitcoin', 'crypto', 'investment opportunity', 'make money fast',
            'click here', 'act now', 'limited time', 'free money',
            'nigerian prince', 'inheritance', 'million dollars'
        ];
        
        $text_lower = strtolower($text);
        foreach ($spam_keywords as $keyword) {
            if (strpos($text_lower, $keyword) !== false) {
                return true;
            }
        }
        
        // Check for excessive links
        $link_count = preg_match_all('/https?:\/\//', $text);
        if ($link_count > 2) {
            return true;
        }
        
        return false;
    }

    /**
     * ========================================
     * EMAIL SENDER
     * ========================================
     */
    private function sendEmail($to, $subject, $message) 
    { 
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'lembris.internet@gmail.com',
            'smtp_pass' => 'oaau mhwh fevr fhhy',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'smtp_crypto' => 'tls',
            'newline' => "\r\n",
        );
        
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from('lembris.internet@gmail.com', 'Osiram Safari Adventure');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        
        if ($this->email->send()) {
            return TRUE;
        } else {
            log_message('error', 'Email failed: ' . $this->email->print_debugger());
            return FALSE;
        }
    }

    /**
     * ========================================
     * APPOINTMENT FORM HANDLER
     * ========================================
     */
    public function appointment_query() 
    { 
        if (!$this->input->post('submit')) {
            redirect(base_url('appointment'));
            return;
        }

        // Security Check 1: Honeypot
        if (!$this->check_honeypot()) {
            log_message('error', 'Appointment form honeypot triggered from IP: ' . $this->input->ip_address());
            redirect(base_url('appointment'));
            return;
        }

        // Security Check 2: Rate Limiting
        if (!$this->check_rate_limit('appointment')) {
            $this->session->set_flashdata('error', 'Too many submissions. Please try again later.');
            redirect(base_url('appointment'));
            return;
        }

        // Form Validation Rules
        $this->form_validation->set_rules('fullName', 'Full Name', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('emailAddress', 'Email', 'required|valid_email|max_length[150]');
        $this->form_validation->set_rules('contactNumber', 'Contact Number', 'required|min_length[6]|max_length[20]');
        $this->form_validation->set_rules('services', 'Services', 'required|max_length[200]');
        $this->form_validation->set_rules('message', 'Message', 'max_length[2000]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url('appointment'));
            return;
        }

        // Sanitize all inputs
        $fullName = $this->sanitize_input($this->input->post('fullName'));
        $email = $this->sanitize_input($this->input->post('emailAddress'));
        $phone = $this->sanitize_input($this->input->post('contactNumber'));
        $services = $this->sanitize_input($this->input->post('services'));
        $message = $this->sanitize_input($this->input->post('message') ?? '');

        // Security Check 3: Validate email format
        if (!$this->is_valid_email($email)) {
            $this->session->set_flashdata('error', 'Please enter a valid email address.');
            redirect(base_url('appointment'));
            return;
        }

        // Security Check 4: Validate phone (basic)
        if (!preg_match('/^[\d\s\+\-\(\)]{6,20}$/', $phone)) {
            $this->session->set_flashdata('error', 'Please enter a valid phone number.');
            redirect(base_url('appointment'));
            return;
        }

        // Security Check 5: Spam detection
        if ($this->contains_spam($message) || $this->contains_spam($services)) {
            log_message('error', 'Spam detected in appointment form from IP: ' . $this->input->ip_address());
            $this->session->set_flashdata('error', 'Your appointment could not be submitted. Please try again.');
            redirect(base_url('appointment'));
            return;
        }

        // Prepare data for database
        $data = [
            'fullName' => $fullName,
            'emailAddress' => $email,
            'contactNumber' => $phone,
            'services' => $services,
            'message' => $message,
            'ip_address' => $this->input->ip_address(),
            'submitted_at' => date('Y-m-d H:i:s')
        ];

        // Save to database
        $last_id = $this->Model_common->data_add('tbl_appointment_queries', $data);

        // Build email
        $receiver_mail = 'osiramsafari@gmail.com';
        $email_subject = 'APPOINTMENT - QUERY';

        $body = '<h3>New Appointment Request</h3>
                 <p><strong>Name:</strong> ' . $data['fullName'] . '</p>
                 <p><strong>Email:</strong> ' . $data['emailAddress'] . '</p>
                 <p><strong>Phone:</strong> ' . $data['contactNumber'] . '</p>
                 <p><strong>Services:</strong> ' . $data['services'] . '</p>
                 <p><strong>Message:</strong></p>
                 <p>' . nl2br($data['message'] ?: 'No additional message') . '</p>
                 <hr>
                 <p><small>IP Address: ' . $data['ip_address'] . '</small></p>
                 <p><small>Submitted: ' . $data['submitted_at'] . '</small></p>';

        // Send email
        if ($this->sendEmail($receiver_mail, $email_subject, $body)) {
            // Update database that email is sent
            $update_data = ['mail_sent_time' => date('Y-m-d H:i:s'), 'is_mail_sent' => '1'];
            $this->Model_common->data_update('tbl_appointment_queries', $last_id, $update_data);

            $this->session->set_flashdata('success', 'Your appointment is placed successfully! You will be contacted within 24 hours.');
            redirect(base_url());
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again later.');
            redirect(base_url('appointment'));
        }
    }
}
