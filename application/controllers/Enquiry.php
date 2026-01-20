<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends Frontend_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model(['Enquiry_model', 'Model_common', 'Admission_model']);
        $this->load->library(['form_validation', 'email']);
        $this->load->helper(['url', 'form', 'template']);
    }

    /**
     * Show enquiry form
     */
    public function index()
    {
        $data = $this->get_common_data();
        $data['current_page_name'] = 'Safari Enquiry';
        $data['main_page'] = 'Enquiry';
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('enquiry', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * Process form submission
     */
    public function submit()
    {
        // Check if form was actually submitted (POST request with required fields)
        if ($this->input->method() !== 'post' || !$this->input->post('full_name')) {
            redirect(base_url('enquiry'));
            return;
        }

        // Security Check 1: Honeypot
        if (!$this->check_honeypot()) {
            log_message('error', 'Enquiry form honeypot triggered from IP: ' . $this->input->ip_address());
            redirect(base_url('enquiry'));
            return;
        }

        // Security Check 2: Rate Limiting
        if (!$this->check_rate_limit()) {
            $this->session->set_flashdata('error', 'Too many submissions. Please try again later.');
            redirect(base_url('enquiry'));
            return;
        }

        // Security Check 3: Safari CAPTCHA
        if (!$this->check_safari_captcha()) {
            $this->session->set_flashdata('error', '🦁 Oops! Wrong safari answer. Are you sure you\'re not a hyena bot? Try again!');
            $this->session->set_flashdata('form_data', $this->input->post());
            redirect(base_url('enquiry'));
            return;
        }

        // Form Validation Rules
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|min_length[6]|max_length[30]');
        $this->form_validation->set_rules('country', 'Country', 'max_length[100]');
        $this->form_validation->set_rules('trip_type', 'Trip Type', 'required');
        $this->form_validation->set_rules('duration', 'Trip Duration', 'required');
        $this->form_validation->set_rules('adults', 'Number of Adults', 'required|integer|greater_than[0]|less_than[21]');
        $this->form_validation->set_rules('children', 'Number of Children', 'integer|greater_than_equal_to[0]|less_than[11]');
        $this->form_validation->set_rules('accommodation', 'Accommodation Level', 'required');
        $this->form_validation->set_rules('budget', 'Budget Range', 'required');
        $this->form_validation->set_rules('special_requirements', 'Special Requirements', 'max_length[2000]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata('form_data', $this->input->post());
            redirect(base_url('enquiry'));
            return;
        }

        // Sanitize all inputs
        $full_name = $this->sanitize_input($this->input->post('full_name'));
        $email = $this->sanitize_input($this->input->post('email'));
        $phone = $this->sanitize_input($this->input->post('phone'));
        $country = $this->sanitize_input($this->input->post('country') ?? '');
        
        // Validate email format
        if (!$this->is_valid_email($email)) {
            $this->session->set_flashdata('error', 'Please enter a valid email address.');
            $this->session->set_flashdata('form_data', $this->input->post());
            redirect(base_url('enquiry'));
            return;
        }

        // Validate phone
        if (!preg_match('/^[\d\s\+\-\(\)]{6,30}$/', $phone)) {
            $this->session->set_flashdata('error', 'Please enter a valid phone number.');
            $this->session->set_flashdata('form_data', $this->input->post());
            redirect(base_url('enquiry'));
            return;
        }

        // Get destinations (checkboxes)
        $destinations = $this->input->post('destinations');
        $destinations_json = is_array($destinations) ? json_encode($destinations) : '[]';

        // Get interests (checkboxes)
        $interests = $this->input->post('interests');
        $interests_json = is_array($interests) ? json_encode($interests) : '[]';

        // Get children ages
        $children_ages = $this->sanitize_input($this->input->post('children_ages') ?? '');

        // Check for spam in special requirements
        $special_requirements = $this->sanitize_input($this->input->post('special_requirements') ?? '');
        if ($this->contains_spam($special_requirements)) {
            log_message('error', 'Spam detected in enquiry form from IP: ' . $this->input->ip_address());
            $this->session->set_flashdata('error', 'Your enquiry could not be submitted. Please try again.');
            redirect(base_url('enquiry'));
            return;
        }

        // Prepare data
        $enquiry_data = [
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'country' => $country,
            'destinations' => $destinations_json,
            'trip_type' => $this->sanitize_input($this->input->post('trip_type')),
            'travel_date_from' => $this->sanitize_input($this->input->post('travel_date_from') ?? ''),
            'travel_date_to' => $this->sanitize_input($this->input->post('travel_date_to') ?? ''),
            'duration' => $this->sanitize_input($this->input->post('duration')),
            'adults' => (int) $this->input->post('adults'),
            'children' => (int) ($this->input->post('children') ?? 0),
            'children_ages' => $children_ages,
            'accommodation' => $this->sanitize_input($this->input->post('accommodation')),
            'budget' => $this->sanitize_input($this->input->post('budget')),
            'interests' => $interests_json,
            'special_requirements' => $special_requirements,
            'hear_about_us' => $this->sanitize_input($this->input->post('hear_about_us') ?? ''),
            'newsletter' => $this->input->post('newsletter') ? 1 : 0,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent()
        ];

        // Save to database (PRIMARY)
        log_message('info', 'ENQUIRY: Attempting to create enquiry for customer: ' . $enquiry_data['email']);
        
        $enquiry_id = $this->Enquiry_model->save_enquiry($enquiry_data);

        if (!$enquiry_id) {
            log_message('error', 'ENQUIRY FAILED: Database insert failed for customer: ' . $enquiry_data['email']);
            $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
            $this->session->set_flashdata('form_data', $this->input->post());
            redirect(base_url('enquiry'));
            return;
        }

        log_message('info', 'ENQUIRY SUCCESS: Created enquiry ID: ' . $enquiry_id . ' for customer: ' . $enquiry_data['email']);

        $enquiry = $this->Enquiry_model->get_enquiry($enquiry_id);
        
        // Send emails (SECONDARY - don't block on failure)
        try {
            $this->send_enquiry_email($enquiry);
        } catch (Exception $e) {
            log_message('error', 'ENQUIRY EMAIL EXCEPTION: ' . $e->getMessage());
        }
        
        // Store enquiry data for success page
        $this->session->set_userdata('last_enquiry', $enquiry);
        
        log_message('info', 'ENQUIRY COMPLETE: Redirecting to success for enquiry ID: ' . $enquiry_id);
        redirect(base_url('enquiry/success'));
    } 

    /**
     * Submit floating form
     */
    public function submit_floating_form()
    {
        try {
            // Clear any buffered output before setting headers
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
            
            // Set JSON response header  
            header('Content-Type: application/json; charset=utf-8');
            
            // Detect if AJAX request
            $is_ajax = $this->input->is_ajax_request();
            
            // Check if form was actually submitted (POST request)
            if ($this->input->method() !== 'post' || !$this->input->post('name')) {
                echo json_encode(['success' => false, 'message' => 'Invalid request']);
                exit;
            }


            // Form Validation Rules
            $this->form_validation->set_rules('name', 'Full Name', 'required|min_length[2]|max_length[100]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]');
            $this->form_validation->set_rules('phone', 'Phone Number', 'max_length[30]');
            $this->form_validation->set_rules('program_interest', 'Program of Interest', 'required');
            $this->form_validation->set_rules('message', 'Message', 'max_length[2000]');

            if ($this->form_validation->run() === FALSE) {
                $error_msg = str_replace(['<p>', '</p>'], ['', ' '], validation_errors());
                echo json_encode(['success' => false, 'message' => trim($error_msg)]);
                exit;
            }

            // Sanitize all inputs
            $full_name = $this->sanitize_input($this->input->post('name'));
            $email = $this->sanitize_input($this->input->post('email'));
            $phone = $this->sanitize_input($this->input->post('phone') ?? '');
            $program_interest = $this->sanitize_input($this->input->post('program_interest'));
            $message = $this->sanitize_input($this->input->post('message') ?? '');

            // Validate email format
            if (!$this->is_valid_email($email)) {
                echo json_encode(['success' => false, 'message' => 'Invalid email address']);
                exit;
            }

            // Validate phone if provided
            if (!empty($phone) && !preg_match('/^[\d\s\+\-\(\)]{6,30}$/', $phone)) {
                echo json_encode(['success' => false, 'message' => 'Invalid phone number']);
                exit;
            }

            // Combine message and program interest
            $full_message = "Program Interest: " . $program_interest;
            if (!empty($message)) {
                $full_message .= "\n\nAdditional Message:\n" . $message;
            }

            // Always return JSON for this endpoint
            echo json_encode([
                'success' => true,
                'message' => 'Application submitted successfully! We will contact you shortly.',
                'data' => [
                    'name' => $full_name,
                    'email' => $email,
                    'program' => $program_interest
                ]
            ]);
            exit;
        } catch (Throwable $e) {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
            header('Content-Type: application/json; charset=utf-8');
            log_message('error', 'FLOATING FORM EXCEPTION: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ':' . $e->getLine());
            echo json_encode([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
            exit;
        }
    }


     /**
     * Show success page
     */
    public function success()
    {
        $enquiry = $this->session->userdata('last_enquiry');
        
        if (!$enquiry) {
            redirect(base_url('enquiry'));
            return;
        }

        $data = $this->get_common_data();
        $data['current_page_name'] = 'Enquiry Submitted';
        $data['main_page'] = 'Enquiry';
        $data['enquiry'] = $enquiry;

        // Clear the session data
        $this->session->unset_userdata('last_enquiry');

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('enquiry_success', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }




    /**
     * Send enquiry email to admin + auto-reply to customer
     */
    public function send_enquiry_email($enquiry)
    {
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
            // Send to admin
            $this->email->initialize($config);
            $this->email->from('lembris.internet@gmail.com', 'Osiram Safari Adventure');
            $this->email->to('osiramsafari@gmail.com');
            $this->email->subject('🦁 NEW SAFARI ENQUIRY - ' . $enquiry->reference_number);
            $this->email->message($this->build_admin_email($enquiry));
            @$this->email->send();

            // Send auto-reply to customer
            $this->email->clear();
            $this->email->initialize($config);
            $this->email->from('lembris.internet@gmail.com', 'Osiram Safari Adventure');
            $this->email->to($enquiry->email);
            $this->email->subject('Your Safari Enquiry - ' . $enquiry->reference_number);
            $this->email->message($this->build_customer_email($enquiry));
            
            if (@$this->email->send()) {
                $this->Enquiry_model->mark_email_sent($enquiry->id);
                return true;
            }
            
            log_message('error', 'Enquiry customer email failed: ' . $this->email->print_debugger(['headers']));
            return false;
        } catch (Exception $e) {
            log_message('error', 'Enquiry email exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Build admin notification email
     */
    private function build_admin_email($enquiry)
    {
        $destinations = json_decode($enquiry->destinations, true);
        $interests = json_decode($enquiry->interests, true);
        
        $destinations_str = is_array($destinations) && count($destinations) > 0 ? implode(', ', $destinations) : 'Not specified';
        $interests_str = is_array($interests) && count($interests) > 0 ? implode(', ', $interests) : 'None specified';
        
        $travel_dates = 'Flexible';
        if (!empty($enquiry->travel_date_from) && !empty($enquiry->travel_date_to)) {
            $travel_dates = date('M j, Y', strtotime($enquiry->travel_date_from)) . ' - ' . date('M j, Y', strtotime($enquiry->travel_date_to));
        } elseif (!empty($enquiry->travel_date_from)) {
            $travel_dates = 'From ' . date('M j, Y', strtotime($enquiry->travel_date_from));
        }

        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 650px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #198754, #0d6efd); color: white; padding: 25px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8f9fa; padding: 25px; }
                .ref-box { background: #fff; padding: 15px; border-left: 4px solid #198754; margin: 15px 0; font-size: 18px; }
                .section { background: white; padding: 20px; border-radius: 8px; margin: 15px 0; }
                .section h3 { color: #198754; margin-top: 0; border-bottom: 2px solid #198754; padding-bottom: 10px; }
                .row { display: flex; margin-bottom: 10px; }
                .label { font-weight: bold; width: 150px; color: #666; }
                .value { flex: 1; }
                .highlight { background: #d4edda; padding: 3px 8px; border-radius: 4px; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 13px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1 style="margin:0;">🦁 New Safari Enquiry!</h1>
                    <p style="margin:10px 0 0;opacity:0.9;">A potential customer is interested in a safari</p>
                </div>
                
                <div class="content">
                    <div class="ref-box">
                        <strong>Reference Number:</strong> <span class="highlight">' . htmlspecialchars($enquiry->reference_number) . '</span>
                    </div>
                    
                    <div class="section">
                        <h3>👤 Personal Details</h3>
                        <div class="row"><span class="label">Name:</span><span class="value">' . htmlspecialchars($enquiry->full_name) . '</span></div>
                        <div class="row"><span class="label">Email:</span><span class="value"><a href="mailto:' . htmlspecialchars($enquiry->email) . '">' . htmlspecialchars($enquiry->email) . '</a></span></div>
                        <div class="row"><span class="label">Phone:</span><span class="value"><a href="tel:' . htmlspecialchars($enquiry->phone) . '">' . htmlspecialchars($enquiry->phone) . '</a></span></div>
                        <div class="row"><span class="label">Country:</span><span class="value">' . (htmlspecialchars($enquiry->country) ?: 'Not specified') . '</span></div>
                    </div>
                    
                    <div class="section">
                        <h3>🗺️ Trip Details</h3>
                        <div class="row"><span class="label">Destinations:</span><span class="value">' . htmlspecialchars($destinations_str) . '</span></div>
                        <div class="row"><span class="label">Trip Type:</span><span class="value"><span class="highlight">' . htmlspecialchars($enquiry->trip_type) . '</span></span></div>
                        <div class="row"><span class="label">Travel Dates:</span><span class="value">' . $travel_dates . '</span></div>
                        <div class="row"><span class="label">Duration:</span><span class="value">' . htmlspecialchars($enquiry->duration) . '</span></div>
                        <div class="row"><span class="label">Adults:</span><span class="value">' . $enquiry->adults . '</span></div>
                        <div class="row"><span class="label">Children:</span><span class="value">' . $enquiry->children . ($enquiry->children_ages ? ' (Ages: ' . htmlspecialchars($enquiry->children_ages) . ')' : '') . '</span></div>
                    </div>
                    
                    <div class="section">
                        <h3>⭐ Preferences</h3>
                        <div class="row"><span class="label">Accommodation:</span><span class="value">' . htmlspecialchars($enquiry->accommodation) . '</span></div>
                        <div class="row"><span class="label">Budget:</span><span class="value"><span class="highlight">' . htmlspecialchars($enquiry->budget) . '</span></span></div>
                        <div class="row"><span class="label">Interests:</span><span class="value">' . htmlspecialchars($interests_str) . '</span></div>
                    </div>
                    
                    ' . ($enquiry->special_requirements ? '
                    <div class="section">
                        <h3>📝 Special Requirements</h3>
                        <p>' . nl2br(htmlspecialchars($enquiry->special_requirements)) . '</p>
                    </div>
                    ' : '') . '
                    
                    <div class="section">
                        <h3>📊 Additional Info</h3>
                        <div class="row"><span class="label">Heard About Us:</span><span class="value">' . (htmlspecialchars($enquiry->hear_about_us) ?: 'Not specified') . '</span></div>
                        <div class="row"><span class="label">Newsletter:</span><span class="value">' . ($enquiry->newsletter ? '✅ Subscribed' : '❌ No') . '</span></div>
                        <div class="row"><span class="label">IP Address:</span><span class="value">' . htmlspecialchars($enquiry->ip_address) . '</span></div>
                        <div class="row"><span class="label">Submitted:</span><span class="value">' . date('F j, Y \a\t g:i A', strtotime($enquiry->created_at)) . '</span></div>
                    </div>
                    
                    <p style="text-align:center;margin-top:25px;">
                        <a href="https://wa.me/' . htmlspecialchars($enquiry->phone) . '" style="display:inline-block;padding:12px 30px;background:#25D366;color:white;text-decoration:none;border-radius:25px;font-weight:bold;">💬 WhatsApp Customer</a>
                    </p>
                </div>
                
                <div class="footer">
                    <p>This enquiry was submitted via the website contact form.</p>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Build customer auto-reply email
     */
    private function build_customer_email($enquiry)
    {
        $destinations = json_decode($enquiry->destinations, true);
        $destinations_str = is_array($destinations) && count($destinations) > 0 ? implode(', ', $destinations) : 'Not specified';
        
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #0d6efd, #198754); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8f9fa; padding: 30px; }
                .ref-box { background: #fff; padding: 20px; border-left: 4px solid #0d6efd; margin: 20px 0; }
                .summary { background: white; padding: 25px; border-radius: 10px; margin: 20px 0; }
                .steps { counter-reset: step; }
                .step { position: relative; padding-left: 50px; margin-bottom: 20px; }
                .step::before { counter-increment: step; content: counter(step); position: absolute; left: 0; top: 0; width: 35px; height: 35px; background: #0d6efd; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
                .footer { text-align: center; padding: 25px; color: #666; font-size: 14px; }
                .btn { display: inline-block; padding: 15px 35px; background: #0d6efd; color: white; text-decoration: none; border-radius: 30px; font-weight: 600; margin: 10px 5px; }
                .btn-whatsapp { background: #25D366; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1 style="margin:0;">🦁 Thank You for Your Enquiry!</h1>
                    <p style="margin:15px 0 0;font-size:1.1rem;">Your African adventure is about to begin</p>
                </div>
                
                <div class="content">
                    <p>Dear <strong>' . htmlspecialchars($enquiry->full_name) . '</strong>,</p>
                    
                    <p>Thank you for your interest in exploring Tanzania with Osiram Safari Adventure! We have received your safari enquiry and our team is excited to help you plan an unforgettable experience.</p>
                    
                    <div class="ref-box">
                        <strong>Your Reference Number:</strong><br>
                        <span style="font-size: 28px; color: #0d6efd; font-weight: bold;">' . htmlspecialchars($enquiry->reference_number) . '</span><br>
                        <small style="color: #666;">Please keep this for your records</small>
                    </div>
                    
                    <div class="summary">
                        <h3 style="margin-top:0;color:#198754;">📋 Your Enquiry Summary</h3>
                        <p><strong>Interested Destinations:</strong> ' . htmlspecialchars($destinations_str) . '</p>
                        <p><strong>Trip Type:</strong> ' . htmlspecialchars($enquiry->trip_type) . '</p>
                        <p><strong>Duration:</strong> ' . htmlspecialchars($enquiry->duration) . '</p>
                        <p><strong>Travelers:</strong> ' . $enquiry->adults . ' Adult(s)' . ($enquiry->children > 0 ? ', ' . $enquiry->children . ' Child(ren)' : '') . '</p>
                        <p><strong>Accommodation:</strong> ' . htmlspecialchars($enquiry->accommodation) . '</p>
                        <p><strong>Budget:</strong> ' . htmlspecialchars($enquiry->budget) . '</p>
                    </div>
                    
                    <h3>🚀 What Happens Next?</h3>
                    <div class="steps">
                        <div class="step">
                            <strong>Personal Consultation</strong><br>
                            Our safari expert will review your requirements and contact you within 24 hours.
                        </div>
                        <div class="step">
                            <strong>Custom Itinerary</strong><br>
                            We\'ll create a personalized safari itinerary tailored to your preferences.
                        </div>
                        <div class="step">
                            <strong>Quote & Booking</strong><br>
                            Receive a detailed quote with transparent pricing and easy booking options.
                        </div>
                        <div class="step">
                            <strong>Adventure Begins!</strong><br>
                            Pack your bags and get ready for the experience of a lifetime!
                        </div>
                    </div>
                    
                    <p style="text-align:center;margin-top:30px;">
                        <a href="https://wa.me/255787033777?text=Hi!%20My%20enquiry%20reference%20is%20' . urlencode($enquiry->reference_number) . '" class="btn btn-whatsapp">💬 WhatsApp Us</a>
                        <a href="tel:+255787033777" class="btn">📞 Call Us</a>
                    </p>
                    
                    <div style="background:#fff3cd;padding:15px;border-radius:8px;margin-top:25px;">
                        <strong>⏰ Need Urgent Assistance?</strong><br>
                        Call us directly at <a href="tel:+255787033777">+255 787 033 777</a> for immediate help.
                    </div>
                </div>
                
                <div class="footer">
                    <p><strong>Osiram Safari Adventure</strong></p>
                    <p>📍 Box 15907 Arusha, Tanzania</p>
                    <p>📞 +255 789 356 961 | ✉️ welcome@osiramsafari.com</p>
                    <p><a href="https://www.osiramsafari.com">www.osiramsafari.com</a></p>
                    <p style="margin-top:15px;font-size:12px;color:#999;">This is an automated response. Please do not reply directly to this email.</p>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * AJAX: Refresh Safari CAPTCHA
     */
    public function refresh_captcha()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        
        $type = $this->input->post('type') ?? 'enquiry';
        $refresh_key = 'captcha_refresh_count_' . $type;
        $refresh_count = $this->session->userdata($refresh_key) ?? 0;
        
        if ($refresh_count >= 3) {
            echo json_encode([
                'success' => false,
                'message' => 'No more refreshes available! Answer this one 🦁',
                'remaining' => 0
            ]);
            return;
        }
        
        $questions = $this->get_safari_questions();
        $random_key = array_rand($questions);
        $captcha = $questions[$random_key];
        
        $this->session->set_userdata('safari_captcha_enquiry', strtolower($captcha['a']));
        $this->session->set_userdata($refresh_key, $refresh_count + 1);
        
        echo json_encode([
            'success' => true,
            'question' => $captcha['q'],
            'hint' => $captcha['hint'],
            'remaining' => 3 - ($refresh_count + 1)
        ]);
    }

    /**
     * Security: Check honeypot field
     */
    private function check_honeypot()
    {
        $honeypot = $this->input->post('website_url');
        return empty($honeypot);
    }

    /**
     * Security: Rate limiting
     */
    private function check_rate_limit()
    {
        $session_key = 'enquiry_submissions';
        $time_key = 'enquiry_last_submit';
        
        $submissions = $this->session->userdata($session_key) ?? 0;
        $last_submit = $this->session->userdata($time_key) ?? 0;
        
        if ($submissions >= 5 && (time() - $last_submit) < 3600) {
            return false;
        }
        
        if ((time() - $last_submit) >= 3600) {
            $submissions = 0;
        }
        
        $this->session->set_userdata($session_key, $submissions + 1);
        $this->session->set_userdata($time_key, time());
        
        return true;
    }

    /**
     * Security: Sanitize input
     */
    private function sanitize_input($input)
    {
        $input = trim($input);
        $input = strip_tags($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        return $this->security->xss_clean($input);
    }

    /**
     * Validate email format
     */
    private function is_valid_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Check for spam keywords
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
        
        $link_count = preg_match_all('/https?:\/\//', $text);
        if ($link_count > 2) {
            return true;
        }
        
        return false;
    }

    /**
     * Validate Safari CAPTCHA
     */
    private function check_safari_captcha()
    {
        $user_answer = strtolower(trim($this->input->post('safari_answer') ?? ''));
        $correct_answer = $this->session->userdata('safari_captcha_enquiry');
        
        $this->session->unset_userdata('safari_captcha_enquiry');
        $this->session->unset_userdata('captcha_refresh_count_enquiry');
        
        if (empty($correct_answer)) {
            return false;
        }
        
        return $user_answer === $correct_answer;
    }

    /**
     * Get Safari CAPTCHA questions
     */
    private function get_safari_questions()
    {
        return [
            ['q' => '🦓 What color are a zebra\'s stripes?', 'a' => 'black', 'hint' => 'Not white...'],
            ['q' => '🦁 Who is the "King of the Jungle"?', 'a' => 'lion', 'hint' => 'Starts with L...'],
            ['q' => '🐘 Which animal never forgets?', 'a' => 'elephant', 'hint' => 'Has a trunk...'],
            ['q' => '🦒 Which animal has the longest neck?', 'a' => 'giraffe', 'hint' => 'Reaches treetops...'],
            ['q' => '🦛 What\'s the most dangerous animal in Africa?', 'a' => 'hippo', 'hint' => 'Lives in water...'],
            ['q' => '🐆 Spots or stripes: What does a leopard have?', 'a' => 'spots', 'hint' => 'Not stripes...'],
            ['q' => '🦏 How many horns does a rhino have?', 'a' => '2', 'hint' => 'More than 1...'],
            ['q' => '🌍 Mount Kilimanjaro is in which country?', 'a' => 'tanzania', 'hint' => 'You\'re booking with us!'],
            ['q' => '🦩 What color is a flamingo?', 'a' => 'pink', 'hint' => 'Think about it...'],
            ['q' => '🐆 Is a cheetah fast or slow?', 'a' => 'fast', 'hint' => 'Fastest land animal!'],
            ['q' => '🦁 What sound does a lion make?', 'a' => 'roar', 'hint' => 'It\'s loud!'],
            ['q' => '🌊 What ocean borders Tanzania?', 'a' => 'indian', 'hint' => 'Not Atlantic...'],
            ['q' => '🌍 Is Tanzania in Africa or Antarctica?', 'a' => 'africa', 'hint' => 'It\'s warm there!'],
            ['q' => '🏝️ Zanzibar is an... (island/mountain)?', 'a' => 'island', 'hint' => 'Surrounded by water...'],
            ['q' => '🐘 Is an elephant big or small?', 'a' => 'big', 'hint' => 'Very, very...'],
            ['q' => '🦒 Does a giraffe have a long or short neck?', 'a' => 'long', 'hint' => 'Reaches the trees...'],
            ['q' => '🐘 Do elephants have wings? (yes/no)', 'a' => 'no', 'hint' => 'They can\'t fly!'],
            ['q' => '🦁 Can a lion fly? (yes/no)', 'a' => 'no', 'hint' => 'They run instead!'],
            ['q' => '🦁 1 lion + 1 lion = how many lions?', 'a' => '2', 'hint' => 'Basic math!'],
            ['q' => '🦓 How many legs does a zebra have?', 'a' => '4', 'hint' => 'Same as a horse...'],
            ['q' => '🦁 The Big 5: Lion, Leopard, Elephant, Buffalo and...?', 'a' => 'rhino', 'hint' => 'Has a horn...'],
        ];
    }
}
