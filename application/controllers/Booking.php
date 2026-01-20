<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends Frontend_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model(['Booking_model', 'Model_common']);
        $this->load->library(['form_validation', 'email']);
        $this->load->helper(['url', 'form', 'template']);
    }

    /**
     * Show booking form
     */
    public function index()
    {
        $data = $this->get_common_data();
        $data['current_page_name'] = 'Book Your Safari';
        $data['main_page'] = 'Booking';
        
        $data['packages'] = $this->Booking_model->get_packages();
        
        $data['pre_selected_package'] = $this->input->get('package');
        $data['pre_selected_date'] = $this->input->get('date');

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('booking', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * AJAX endpoint to check availability for calendar
     */
    public function check_availability()
    {
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }
        
        header('Content-Type: application/json');

        $package_id = (int) $this->input->post('package_id');
        $month = (int) $this->input->post('month');
        $year = (int) $this->input->post('year');

        if (!$package_id || !$month || !$year) {
            echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
            return;
        }

        $availability = $this->Booking_model->get_available_dates($package_id, $month, $year);
        
        $dates = [];
        foreach ($availability as $day) {
            $spots_remaining = $day->spots_available - $day->spots_booked;
            $dates[$day->date] = [
                'available' => $spots_remaining > 0,
                'spots' => $spots_remaining,
                'modifier' => (float) $day->price_modifier,
                'status' => $spots_remaining <= 0 ? 'full' : ($spots_remaining <= 3 ? 'limited' : 'available')
            ];
        }

        echo json_encode([
            'success' => true,
            'dates' => $dates,
            'month' => $month,
            'year' => $year
        ]);
    }

    /**
     * AJAX endpoint to calculate price
     */
    public function calculate_price()
    {
        // Allow both AJAX and direct POST requests for testing
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }
        
        // Set JSON header
        header('Content-Type: application/json');

        $package_id = (int) $this->input->post('package_id');
        $date = $this->input->post('travel_date');
        $adults = (int) $this->input->post('adults') ?: 1;
        $children = (int) $this->input->post('children') ?: 0;
        $accommodation = $this->input->post('accommodation') ?: 'mid-range';

        if (!$package_id || !$date) {
            echo json_encode(['success' => false, 'message' => 'Please select a package and date']);
            return;
        }

        $package = $this->Booking_model->get_package($package_id);
        if (!$package) {
            echo json_encode(['success' => false, 'message' => 'Package not found']);
            return;
        }

        $pricing = $this->Booking_model->get_package_pricing($package_id, $date, $adults, $children, $accommodation);
        
        if (!$pricing) {
            echo json_encode(['success' => false, 'message' => 'Pricing not available']);
            return;
        }

        $availability = $this->Booking_model->check_date_availability($package_id, $date, $adults + $children);
        
        echo json_encode([
            'success' => true,
            'pricing' => $pricing,
            'package' => [
                'name' => $package->name,
                'duration' => $package->duration_days,
                'category' => $package->category
            ],
            'availability' => $availability ? [
                'available' => true,
                'spots' => $availability->spots_available
            ] : [
                'available' => false,
                'message' => 'Not enough spots available for this date'
            ]
        ]);
    }

    /**
     * Process booking form submission
     */
    public function process()
    {
        // Check if form was actually submitted (POST request with required fields)
        if ($this->input->method() !== 'post' || !$this->input->post('package_id')) {
            redirect(base_url('booking'));
            return;
        }

        if (!$this->check_honeypot()) {
            log_message('error', 'Booking honeypot triggered from IP: ' . $this->input->ip_address());
            redirect(base_url('booking'));
            return;
        }

        if (!$this->check_rate_limit()) {
            $this->session->set_flashdata('error', 'Too many booking attempts. Please try again in an hour.');
            redirect(base_url('booking'));
            return;
        }

        $this->form_validation->set_rules('package_id', 'Package', 'required|integer');
        $this->form_validation->set_rules('travel_date', 'Travel Date', 'required|callback_validate_future_date');
        $this->form_validation->set_rules('adults', 'Number of Adults', 'required|integer|greater_than[0]|less_than[21]');
        $this->form_validation->set_rules('children', 'Number of Children', 'integer|greater_than_equal_to[0]|less_than[11]');
        $this->form_validation->set_rules('customer_name', 'Full Name', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('customer_email', 'Email', 'required|valid_email|max_length[150]');
        $this->form_validation->set_rules('customer_phone', 'Phone Number', 'required|min_length[6]|max_length[30]');
        $this->form_validation->set_rules('customer_country', 'Country', 'required|max_length[100]');
        $this->form_validation->set_rules('terms_agree', 'Terms & Conditions', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata('form_data', $this->input->post());
            redirect(base_url('booking'));
            return;
        }

        $package_id = (int) $this->input->post('package_id');
        $travel_date = $this->sanitize_input($this->input->post('travel_date'));
        $adults = (int) $this->input->post('adults');
        $children = (int) ($this->input->post('children') ?? 0);
        $accommodation = $this->sanitize_input($this->input->post('accommodation') ?? 'mid-range');

        $package = $this->Booking_model->get_package($package_id);
        if (!$package) {
            $this->session->set_flashdata('error', 'Selected package is not available.');
            redirect(base_url('booking'));
            return;
        }

        $availability = $this->Booking_model->check_date_availability($package_id, $travel_date, $adults + $children);
        if (!$availability || !$availability->available) {
            $this->session->set_flashdata('error', 'Sorry, the selected date is no longer available. Please choose another date.');
            redirect(base_url('booking'));
            return;
        }

        $pricing = $this->Booking_model->get_package_pricing($package_id, $travel_date, $adults, $children, $accommodation);
        if (!$pricing) {
            $this->session->set_flashdata('error', 'Unable to calculate pricing. Please try again.');
            redirect(base_url('booking'));
            return;
        }

        $end_date = date('Y-m-d', strtotime($travel_date . ' + ' . ($package->duration_days - 1) . ' days'));

        $booking_data = [
            'package_id' => $package_id,
            'travel_date' => $travel_date,
            'end_date' => $end_date,
            'travelers_adults' => $adults,
            'travelers_children' => $children,
            'customer_name' => $this->sanitize_input($this->input->post('customer_name')),
            'customer_email' => $this->sanitize_input($this->input->post('customer_email')),
            'customer_phone' => $this->sanitize_input($this->input->post('customer_phone')),
            'customer_country' => $this->sanitize_input($this->input->post('customer_country')),
            'special_requests' => $this->sanitize_input($this->input->post('special_requests') ?? ''),
            'accommodation_preference' => $accommodation,
            'base_price' => $pricing->base_price,
            'total_price' => $pricing->total,
            'currency' => 'USD',
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent()
        ];

        // Step 1: Save booking to database (PRIMARY)
        log_message('info', 'BOOKING: Attempting to create booking for package_id: ' . $package_id . ', customer: ' . $booking_data['customer_email']);
        
        $booking_id = $this->Booking_model->create_booking($booking_data);

        if (!$booking_id) {
            log_message('error', 'BOOKING FAILED: Database insert failed for package_id: ' . $package_id . ', customer: ' . $booking_data['customer_email']);
            $this->session->set_flashdata('error', 'Unable to create booking. Please try again or contact support.');
            redirect(base_url('booking'));
            return;
        }

        log_message('info', 'BOOKING SUCCESS: Created booking ID: ' . $booking_id . ' for customer: ' . $booking_data['customer_email']);

        // Step 2: Try to send emails (SECONDARY - don't block on failure)
        $email_sent = false;
        $admin_email_sent = false;

        try {
            $email_sent = $this->send_confirmation_email($booking_id);
            if ($email_sent) {
                log_message('info', 'EMAIL: Customer confirmation sent for booking ID: ' . $booking_id);
            } else {
                log_message('error', 'EMAIL FAILED: Customer confirmation failed for booking ID: ' . $booking_id);
            }
        } catch (Exception $e) {
            log_message('error', 'EMAIL EXCEPTION: Customer email error for booking ID: ' . $booking_id . ' - ' . $e->getMessage());
        }

        try {
            $admin_email_sent = $this->send_admin_notification($booking_id);
            if ($admin_email_sent) {
                log_message('info', 'EMAIL: Admin notification sent for booking ID: ' . $booking_id);
            } else {
                log_message('error', 'EMAIL FAILED: Admin notification failed for booking ID: ' . $booking_id);
            }
        } catch (Exception $e) {
            log_message('error', 'EMAIL EXCEPTION: Admin email error for booking ID: ' . $booking_id . ' - ' . $e->getMessage());
        }

        // Step 3: Update is_mail_success status in database
        $mail_update_data = [
            'is_mail_success' => ($email_sent ? 1 : 0),
            'is_admin_mail_success' => ($admin_email_sent ? 1 : 0),
            'mail_sent_at' => ($email_sent || $admin_email_sent) ? date('Y-m-d H:i:s') : null
        ];
        $this->Booking_model->update_booking($booking_id, $mail_update_data);
        
        // Write to dedicated booking log file
        $this->write_booking_log($booking_id, $booking_data, $email_sent, $admin_email_sent);
        
        log_message('info', 'BOOKING: Updated mail status for booking ID: ' . $booking_id . ' - Customer: ' . ($email_sent ? 'YES' : 'NO') . ', Admin: ' . ($admin_email_sent ? 'YES' : 'NO'));

        // Step 4: Respond success to user (data is captured)
        log_message('info', 'BOOKING COMPLETE: Redirecting to confirmation for booking ID: ' . $booking_id);
        redirect(base_url('booking/confirmation/' . $booking_id));
    }

    /**
     * Show booking confirmation page
     */
    public function confirmation($booking_id = null)
    {
        if (!$booking_id) {
            redirect(base_url('booking'));
            return;
        }

        $booking = $this->Booking_model->get_booking($booking_id);
        
        if (!$booking) {
            $this->session->set_flashdata('error', 'Booking not found.');
            redirect(base_url('booking'));
            return;
        }

        $data = $this->get_common_data();
        $data['current_page_name'] = 'Booking Confirmed';
        $data['main_page'] = 'Booking';
        $data['booking'] = $booking;

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('booking_confirmation', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * Send confirmation email to customer
     * @param int $booking_id
     * @return bool Success status
     */
    public function send_confirmation_email($booking_id)
    {
        log_message('debug', 'EMAIL: Starting customer email for booking ID: ' . $booking_id);
        
        $booking = $this->Booking_model->get_booking($booking_id);
        
        if (!$booking) {
            log_message('error', 'EMAIL: Booking not found for ID: ' . $booking_id);
            return false;
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
            'smtp_timeout' => 10,
        ];

        $this->email->clear();
        $this->email->initialize($config);
        $this->email->from('lembris.internet@gmail.com', 'Osiram Safari Adventure');
        $this->email->to($booking->customer_email);
        $this->email->subject('Booking Confirmation - ' . $booking->booking_ref);

        $body = $this->build_confirmation_email($booking);
        $this->email->message($body);

        log_message('debug', 'EMAIL: Sending to customer: ' . $booking->customer_email);

        if ($this->email->send()) {
            log_message('info', 'EMAIL SUCCESS: Customer email sent to ' . $booking->customer_email . ' for booking ' . $booking->booking_ref);
            return true;
        }
        
        $debug_info = $this->email->print_debugger(['headers', 'subject']);
        log_message('error', 'EMAIL FAILED: Customer email to ' . $booking->customer_email . ' - Debug: ' . $debug_info);
        return false;
    }

    /**
     * Build confirmation email HTML
     */
    private function build_confirmation_email($booking)
    {
        $travel_date_formatted = date('l, F j, Y', strtotime($booking->travel_date));
        $total_travelers = $booking->travelers_adults + $booking->travelers_children;
        
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
                .booking-ref { background: #fff; padding: 15px; border-left: 4px solid #198754; margin: 20px 0; }
                .details-table { width: 100%; border-collapse: collapse; }
                .details-table th, .details-table td { padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6; }
                .details-table th { background: #e9ecef; font-weight: 600; }
                .price-box { background: #198754; color: white; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
                .btn { display: inline-block; padding: 12px 30px; background: #0d6efd; color: white; text-decoration: none; border-radius: 25px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1 style="margin:0;">🦁 Safari Booking Confirmed!</h1>
                    <p style="margin:10px 0 0;">Thank you for choosing Osiram Safari Adventure</p>
                </div>
                
                <div class="content">
                    <p>Dear <strong>' . htmlspecialchars($booking->customer_name) . '</strong>,</p>
                    <p>We are thrilled to confirm your safari booking! Here are your booking details:</p>
                    
                    <div class="booking-ref">
                        <strong>Booking Reference:</strong><br>
                        <span style="font-size: 24px; color: #198754; font-weight: bold;">' . $booking->booking_ref . '</span>
                    </div>
                    
                    <table class="details-table">
                        <tr>
                            <th>Safari Package</th>
                            <td>' . htmlspecialchars($booking->package_name) . '</td>
                        </tr>
                        <tr>
                            <th>Travel Date</th>
                            <td>' . $travel_date_formatted . '</td>
                        </tr>
                        <tr>
                            <th>Duration</th>
                            <td>' . $booking->duration_days . ' Days</td>
                        </tr>
                        <tr>
                            <th>Travelers</th>
                            <td>' . $booking->travelers_adults . ' Adult(s)' . ($booking->travelers_children > 0 ? ', ' . $booking->travelers_children . ' Child(ren)' : '') . '</td>
                        </tr>
                        <tr>
                            <th>Accommodation</th>
                            <td>' . ucfirst($booking->accommodation_preference) . '</td>
                        </tr>
                    </table>
                    
                    <div class="price-box">
                        <p style="margin:0;font-size:14px;">Total Amount</p>
                        <p style="margin:5px 0;font-size:32px;font-weight:bold;">$' . number_format($booking->total_price, 2) . ' USD</p>
                    </div>
                    
                    <h3>What Happens Next?</h3>
                    <ol>
                        <li><strong>Confirmation Call:</strong> Our team will call you within 24 hours to confirm details.</li>
                        <li><strong>Deposit Payment:</strong> A 30% deposit secures your booking.</li>
                        <li><strong>Full Itinerary:</strong> Receive your detailed day-by-day safari itinerary.</li>
                        <li><strong>Pre-Trip Info:</strong> Packing lists, visa info, and travel tips.</li>
                    </ol>
                    
                    ' . ($booking->special_requests ? '<p><strong>Your Special Requests:</strong><br>' . nl2br(htmlspecialchars($booking->special_requests)) . '</p>' : '') . '
                    
                    <p style="text-align:center;margin-top:30px;">
                        <a href="https://wa.me/255787033777?text=Hi!%20My%20booking%20ref%20is%20' . $booking->booking_ref . '" class="btn">💬 WhatsApp Us</a>
                    </p>
                </div>
                
                <div class="footer">
                    <p><strong>Osiram Safari Adventure</strong></p>
                    <p>📍 Box 15907 Arusha, Tanzania</p>
                    <p>📞 +255 789 356 961 | ✉️ welcome@osiramsafari.com</p>
                    <p><a href="https://www.osiramsafari.com">www.osiramsafari.com</a></p>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Send notification email to admin
     * @param int $booking_id
     * @return bool Success status
     */
    private function send_admin_notification($booking_id)
    {
        log_message('debug', 'EMAIL: Starting admin notification for booking ID: ' . $booking_id);
        
        $booking = $this->Booking_model->get_booking($booking_id);
        
        if (!$booking) {
            log_message('error', 'EMAIL: Booking not found for admin notification, ID: ' . $booking_id);
            return false;
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
            'smtp_timeout' => 10,
        ];

        $this->email->clear();
        $this->email->initialize($config);
        $this->email->from('lembris.internet@gmail.com', 'Booking System');
        $this->email->to('osiramsafari@gmail.com');
        $this->email->subject('NEW BOOKING - ' . $booking->booking_ref);

        $body = '
        <h2>New Safari Booking Received!</h2>
        <p><strong>Booking Reference:</strong> ' . $booking->booking_ref . '</p>
        <p><strong>Package:</strong> ' . htmlspecialchars($booking->package_name ?? 'N/A') . '</p>
        <p><strong>Travel Date:</strong> ' . date('F j, Y', strtotime($booking->travel_date)) . '</p>
        <p><strong>Travelers:</strong> ' . $booking->travelers_adults . ' Adults, ' . $booking->travelers_children . ' Children</p>
        <hr>
        <p><strong>Customer:</strong> ' . htmlspecialchars($booking->customer_name) . '</p>
        <p><strong>Email:</strong> ' . htmlspecialchars($booking->customer_email) . '</p>
        <p><strong>Phone:</strong> ' . htmlspecialchars($booking->customer_phone) . '</p>
        <p><strong>Country:</strong> ' . htmlspecialchars($booking->customer_country ?? 'N/A') . '</p>
        <hr>
        <p><strong>Accommodation:</strong> ' . ucfirst($booking->accommodation_preference ?? 'mid-range') . '</p>
        <p><strong>Total Price:</strong> $' . number_format($booking->total_price, 2) . ' USD</p>
        <p><strong>Special Requests:</strong><br>' . nl2br(htmlspecialchars($booking->special_requests ?: 'None')) . '</p>
        <hr>
        <p><small>IP: ' . ($booking->ip_address ?? 'N/A') . ' | Booked: ' . ($booking->created_at ?? date('Y-m-d H:i:s')) . '</small></p>';

        $this->email->message($body);
        
        log_message('debug', 'EMAIL: Sending admin notification to osiramsafari@gmail.com');
        
        if ($this->email->send()) {
            log_message('info', 'EMAIL SUCCESS: Admin notification sent for booking ' . $booking->booking_ref);
            return true;
        }
        
        $debug_info = $this->email->print_debugger(['headers', 'subject']);
        log_message('error', 'EMAIL FAILED: Admin notification - Debug: ' . $debug_info);
        return false;
    }

    /**
     * Custom validation: Check if date is in the future
     */
    public function validate_future_date($date)
    {
        $timestamp = strtotime($date);
        $tomorrow = strtotime('tomorrow');
        
        if ($timestamp === false || $timestamp < $tomorrow) {
            $this->form_validation->set_message('validate_future_date', 'Please select a date at least 24 hours from now.');
            return false;
        }
        
        $max_date = strtotime('+18 months');
        if ($timestamp > $max_date) {
            $this->form_validation->set_message('validate_future_date', 'Bookings can only be made up to 18 months in advance.');
            return false;
        }
        
        return true;
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
        $session_key = 'booking_submissions';
        $time_key = 'booking_last_submit';
        
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
     * Write detailed booking log to file for troubleshooting
     * @param int $booking_id
     * @param array $booking_data
     * @param bool $email_sent
     * @param bool $admin_email_sent
     */
    private function write_booking_log($booking_id, $booking_data, $email_sent, $admin_email_sent)
    {
        $log_dir = APPPATH . 'logs/bookings/';
        
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        
        $log_file = $log_dir . 'booking_' . date('Y-m-d') . '.log';
        
        $log_entry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'booking_id' => $booking_id,
            'package_id' => $booking_data['package_id'],
            'customer_name' => $booking_data['customer_name'],
            'customer_email' => $booking_data['customer_email'],
            'customer_phone' => $booking_data['customer_phone'],
            'travel_date' => $booking_data['travel_date'],
            'total_price' => $booking_data['total_price'],
            'status' => $booking_data['status'],
            'email_to_customer' => $email_sent ? 'SUCCESS' : 'FAILED',
            'email_to_admin' => $admin_email_sent ? 'SUCCESS' : 'FAILED',
            'ip_address' => $booking_data['ip_address'],
        ];
        
        $log_line = '[' . $log_entry['timestamp'] . '] BOOKING #' . $booking_id . "\n";
        $log_line .= "  Customer: {$log_entry['customer_name']} ({$log_entry['customer_email']})\n";
        $log_line .= "  Phone: {$log_entry['customer_phone']}\n";
        $log_line .= "  Package ID: {$log_entry['package_id']} | Travel: {$log_entry['travel_date']} | Total: \${$log_entry['total_price']}\n";
        $log_line .= "  Email Status - Customer: {$log_entry['email_to_customer']} | Admin: {$log_entry['email_to_admin']}\n";
        $log_line .= "  IP: {$log_entry['ip_address']}\n";
        $log_line .= str_repeat('-', 80) . "\n";
        
        file_put_contents($log_file, $log_line, FILE_APPEND | LOCK_EX);
    }

    /**
     * Lookup booking by reference (public page)
     */
    public function lookup()
    {
        $data = $this->get_common_data();
        $data['current_page_name'] = 'Find My Booking';
        $data['main_page'] = 'Booking';
        $data['booking'] = null;

        if ($this->input->post('booking_ref')) {
            $ref = $this->sanitize_input($this->input->post('booking_ref'));
            $booking = $this->Booking_model->get_booking_by_ref($ref);
            
            if ($booking) {
                $data['booking'] = $booking;
            } else {
                $data['lookup_error'] = 'No booking found with that reference number.';
            }
        }

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('booking_lookup', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * Generate UUID
     * @return string UUID v4 string
     */
    private function generate_uid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Setup/check booking database tables
     * Access: /booking/setup
     */
    public function setup()
    {
        $this->load->dbforge();
        $results = [];

        // Check and create bookings table
        if (!$this->db->table_exists('bookings')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                'booking_ref' => ['type' => 'VARCHAR', 'constraint' => 20],
                'package_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                'travel_date' => ['type' => 'DATE'],
                'end_date' => ['type' => 'DATE', 'null' => TRUE],
                'travelers_adults' => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
                'travelers_children' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
                'customer_name' => ['type' => 'VARCHAR', 'constraint' => 255],
                'customer_email' => ['type' => 'VARCHAR', 'constraint' => 255],
                'customer_phone' => ['type' => 'VARCHAR', 'constraint' => 50],
                'customer_country' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE],
                'special_requests' => ['type' => 'TEXT', 'null' => TRUE],
                'accommodation_preference' => ['type' => 'ENUM', 'constraint' => ['budget', 'mid-range', 'luxury'], 'default' => 'mid-range'],
                'base_price' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
                'total_price' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
                'currency' => ['type' => 'VARCHAR', 'constraint' => 3, 'default' => 'USD'],
                'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'confirmed', 'deposit_paid', 'paid', 'cancelled', 'completed'], 'default' => 'pending'],
                'payment_status' => ['type' => 'ENUM', 'constraint' => ['unpaid', 'partial', 'paid', 'refunded'], 'default' => 'unpaid'],
                'admin_notes' => ['type' => 'TEXT', 'null' => TRUE],
                'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => TRUE],
                'user_agent' => ['type' => 'TEXT', 'null' => TRUE],
                'email_sent' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                'is_mail_success' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                'is_admin_mail_success' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                'mail_sent_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
                'updated_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
                'deleted_at' => ['type' => 'DATETIME', 'null' => TRUE],
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('booking_ref');
            $this->dbforge->add_key('package_id');
            $this->dbforge->add_key('customer_email');
            $this->dbforge->create_table('bookings', TRUE);
            $results[] = 'Created bookings table';
        } else {
            $results[] = 'Bookings table exists';
            
            // Add new email tracking columns if they don't exist
            $fields = $this->db->field_data('bookings');
            $existing_fields = array_column($fields, 'name');
            
            if (!in_array('is_mail_success', $existing_fields)) {
                $this->dbforge->add_column('bookings', [
                    'is_mail_success' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'email_sent']
                ]);
                $results[] = 'Added is_mail_success column';
            }
            
            if (!in_array('is_admin_mail_success', $existing_fields)) {
                $this->dbforge->add_column('bookings', [
                    'is_admin_mail_success' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'is_mail_success']
                ]);
                $results[] = 'Added is_admin_mail_success column';
            }
            
            if (!in_array('mail_sent_at', $existing_fields)) {
                $this->dbforge->add_column('bookings', [
                    'mail_sent_at' => ['type' => 'DATETIME', 'null' => TRUE, 'after' => 'is_admin_mail_success']
                ]);
                $results[] = 'Added mail_sent_at column';
            }
            
            if (!in_array('deleted_at', $existing_fields)) {
                $this->dbforge->add_column('bookings', [
                    'deleted_at' => ['type' => 'DATETIME', 'null' => TRUE, 'after' => 'updated_at']
                ]);
                $results[] = 'Added deleted_at column for soft deletes';
            }
            
            if (!in_array('uid', $existing_fields)) {
                $this->dbforge->add_column('bookings', [
                    'uid' => ['type' => 'VARCHAR', 'constraint' => 36, 'unique' => TRUE, 'after' => 'id']
                ]);
                $results[] = 'Added uid column';
                
                // Generate UIDs for existing bookings
                $existing = $this->db->get($this->bookings_table)->result();
                foreach ($existing as $booking) {
                    if (empty($booking->uid)) {
                        $uid = $this->generate_uid();
                        $this->db->where('id', $booking->id)->update($this->bookings_table, ['uid' => $uid]);
                    }
                }
            }
        }

        // Check and create package_availability table
        if (!$this->db->table_exists('package_availability')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                'package_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                'date' => ['type' => 'DATE'],
                'spots_available' => ['type' => 'INT', 'constraint' => 11, 'default' => 10],
                'spots_booked' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
                'price_modifier' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 1.00],
                'is_blocked' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                'notes' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
                'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
                'updated_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('package_id');
            $this->dbforge->add_key('date');
            $this->dbforge->create_table('package_availability', TRUE);
            $results[] = 'Created package_availability table';
        } else {
            $results[] = 'Package_availability table exists';
        }

        // Check and create package_pricing table
        if (!$this->db->table_exists('package_pricing')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                'package_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                'base_price' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
                'price_per_person' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
                'min_travelers' => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
                'max_travelers' => ['type' => 'INT', 'constraint' => 11, 'default' => 20],
                'single_supplement' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
                'child_discount_percent' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 25],
                'season' => ['type' => 'ENUM', 'constraint' => ['low', 'mid', 'high', 'peak'], 'default' => 'mid'],
                'valid_from' => ['type' => 'DATE', 'null' => TRUE],
                'valid_to' => ['type' => 'DATE', 'null' => TRUE],
                'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
                'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
                'updated_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('package_id');
            $this->dbforge->add_key('season');
            $this->dbforge->create_table('package_pricing', TRUE);
            $results[] = 'Created package_pricing table';
        } else {
            $results[] = 'Package_pricing table exists';
        }

        // Insert default pricing for packages without pricing
        $packages = $this->db->where('is_active', 1)->get('safari_packages')->result();
        foreach ($packages as $pkg) {
            $has_pricing = $this->db->where('package_id', $pkg->id)->where('season', 'mid')->get('package_pricing')->row();
            if (!$has_pricing) {
                $this->db->insert('package_pricing', [
                    'package_id' => $pkg->id,
                    'base_price' => $pkg->duration_days * 400,
                    'price_per_person' => $pkg->duration_days * 100,
                    'single_supplement' => $pkg->duration_days * 60,
                    'child_discount_percent' => 25,
                    'season' => 'mid',
                    'is_active' => 1
                ]);
                $results[] = "Added default pricing for package: {$pkg->name}";
            }
        }

        // Create booking_status_history table
        if (!$this->db->table_exists('booking_status_history')) {
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
                'booking_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
                'old_status' => ['type' => 'VARCHAR', 'constraint' => 50],
                'new_status' => ['type' => 'VARCHAR', 'constraint' => 50],
                'changed_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
                'notes' => ['type' => 'TEXT', 'null' => TRUE],
                'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP']
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('booking_id');
            $this->dbforge->create_table('booking_status_history', TRUE);
            $results[] = 'Created booking_status_history table';
        } else {
            $results[] = 'booking_status_history table exists';
        }

        // admins table should already exist from auth system
        $results[] = $this->db->table_exists('admins') ? 'admins table exists' : 'admins table needs to be created via auth setup';

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Booking system setup complete',
            'details' => $results
        ]);
    }
}
