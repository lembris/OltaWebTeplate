<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultation extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->model('Appointment_model');
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['current_page_name'] = 'Request Consultation';
        $data['main_page'] = 'Consultation';
        $data['page_title'] = 'Request Medical Consultation | TNA CARE';
        $data['meta_description'] = 'Request a free consultation with our medical team. We will contact you within 24 hours.';

        $active_template = get_active_template();
        $this->load->view('templates/' . $active_template . '/header', $data);
        $this->load->view('templates/' . $active_template . '/navigation', $data);
        load_template_page('consultation', $data);
        $this->load->view('templates/' . $active_template . '/footer', $data);
    }

    public function submit()
    {
        if ($this->input->method() !== 'post') {
            redirect(base_url());
            return;
        }

        // Form Validation
        $this->form_validation->set_rules('fullName', 'Full Name', 'required|trim|min_length[2]');
        $this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|min_length[7]');
        $this->form_validation->set_rules('country', 'Country', 'required|trim');
        $this->form_validation->set_rules('medical_speciality', 'Medical Specialty', 'required|trim');
        $this->form_validation->set_rules('treatment', 'Treatment Timeline', 'required|trim');
        $this->form_validation->set_rules('preferred_date', 'Preferred Date', 'trim');
        $this->form_validation->set_rules('preferred_time', 'Preferred Time', 'trim');
        $this->form_validation->set_rules('additional_notes', 'Additional Notes', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url() . '#consultation');
            return;
        }

        // Prepare data
        $appointment_data = [
            'patient_name' => $this->input->post('fullName', TRUE),
            'patient_email' => $this->input->post('email', TRUE),
            'patient_phone' => $this->input->post('phone', TRUE),
            'country' => $this->input->post('country', TRUE),
            'medical_specialty' => $this->input->post('medical_speciality', TRUE),
            'treatment_timeline' => $this->input->post('treatment', TRUE),
            'preferred_date' => $this->input->post('preferred_date', TRUE) ?: NULL,
            'preferred_time' => $this->input->post('preferred_time', TRUE) ?: NULL,
            'additional_notes' => $this->input->post('additional_notes', TRUE),
            'status' => 'pending'
        ];

        // Step 1: Save to database FIRST
        $insert_id = $this->Appointment_model->create($appointment_data);
        
        if (!$insert_id) {
            log_message('error', 'CONSULTATION: Failed to save booking for ' . $appointment_data['patient_email']);
            $this->session->set_flashdata('error', 'Unable to submit your request. Please try again.');
            redirect(base_url() . '#consultation');
            return;
        }

        // Get the saved appointment with reference
        $saved_appointment = $this->Appointment_model->get_by_id($insert_id);
        
        log_message('info', 'CONSULTATION: Created booking ' . $saved_appointment->booking_ref . ' for ' . $appointment_data['patient_email']);

        // Step 2: Send emails UNDERGROUND (fire and forget)
        register_shutdown_function(function() use ($saved_appointment, $insert_id) {
            $email_sent = false;
            $admin_email_sent = false;
            
            // Customer email
            try {
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
                    'smtp_timeout' => 10,
                ];
                
                $CI =& get_instance();
                $CI->email->initialize($config);
                $CI->email->from('lembris.internet@gmail.com', 'TNA CARE');
                $CI->email->to($saved_appointment->patient_email);
                $CI->email->subject('Consultation Request Received - ' . $saved_appointment->booking_ref);
                
                $body = '
                <!DOCTYPE html>
                <html>
                <head><meta charset="utf-8"><style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: linear-gradient(135deg, #1e40af, #3730a3); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                    .content { background: #f8f9fa; padding: 30px; }
                    .ref-box { background: #fff; padding: 15px; border-left: 4px solid #1e40af; margin: 20px 0; }
                    .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
                </style></head>
                <body>
                    <div class="container">
                        <div class="header">
                            <h1 style="margin:0;">🏥 Consultation Request Received</h1>
                            <p style="margin:10px 0 0;">TNA CARE - Health & Medical Solutions</p>
                        </div>
                        <div class="content">
                            <p>Dear <strong>' . htmlspecialchars($saved_appointment->patient_name) . '</strong>,</p>
                            <p>Thank you for your consultation request.</p>
                            <div class="ref-box"><strong>Reference:</strong> ' . $saved_appointment->booking_ref . '</div>
                            <p>Our medical team will contact you within 24 hours.</p>
                        </div>
                        <div class="footer"><p><strong>TNA CARE</strong></p></div>
                    </div>
                </body>
                </html>';
                
                $CI->email->message($body);
                $email_sent = @$CI->email->send();
            } catch (Exception $e) {
                log_message('error', 'CONSULTATION: Email error - ' . $e->getMessage());
            }
            
            // Admin notification
            try {
                $config['smtp_host'] = 'smtp.gmail.com';
                $CI->email->initialize($config);
                $CI->email->from('lembris.internet@gmail.com', 'TNA CARE Website');
                $CI->email->to('lembris.internet@gmail.com');
                $CI->email->subject('NEW CONSULTATION - ' . $saved_appointment->booking_ref);
                
                $admin_body = '
                <h2>New Consultation Request</h2>
                <p><strong>Ref:</strong> ' . $saved_appointment->booking_ref . '</p>
                <p><strong>Name:</strong> ' . htmlspecialchars($saved_appointment->patient_name) . '</p>
                <p><strong>Email:</strong> ' . htmlspecialchars($saved_appointment->patient_email) . '</p>
                <p><strong>Phone:</strong> ' . htmlspecialchars($saved_appointment->patient_phone) . '</p>
                <p><strong>Specialty:</strong> ' . htmlspecialchars($saved_appointment->medical_specialty) . '</p>';
                
                $CI->email->message($admin_body);
                $admin_email_sent = @$CI->email->send();
            } catch (Exception $e) {
                log_message('error', 'CONSULTATION: Admin email error - ' . $e->getMessage());
            }
            
            // Update email status silently
            try {
                $CI->Appointment_model->update($insert_id, [
                    'is_mail_success' => $email_sent ? 1 : 0,
                    'is_admin_mail_success' => $admin_email_sent ? 1 : 0,
                    'mail_sent_at' => ($email_sent || $admin_email_sent) ? date('Y-m-d H:i:s') : null
                ]);
            } catch (Exception $e) {
                // Silent fail
            }
        });

        // Step 3: Redirect back to homepage with success message
        $this->session->set_userdata('consultation_success', true);
        $this->session->set_userdata('consultation_ref', $saved_appointment->booking_ref);
        redirect(base_url() . '#consultation');
    }

    public function success($uid = null)
    {
        if (!$uid) {
            redirect(base_url());
            return;
        }

        $appointment = $this->Appointment_model->get_by_uid($uid);
        
        if (!$appointment) {
            $this->session->set_flashdata('error', 'Appointment not found.');
            redirect(base_url());
            return;
        }

        $data = $this->get_common_data();
        $data['current_page_name'] = 'Request Submitted';
        $data['main_page'] = 'Consultation';
        $data['page_title'] = 'Consultation Request Submitted | TNA CARE';
        $data['appointment'] = $appointment;

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('consultation_success', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}
