<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookings extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->model('Package_model');
        $this->load->library('pagination');
        $this->load->helper('security');
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Bookings';

        $status = $this->input->get('status') ?? 'all';
        $search = $this->input->get('search') ?? '';
        $date_from = $this->input->get('date_from') ?? '';
        $date_to = $this->input->get('date_to') ?? '';
        $per_page = 20;
        $page = $this->input->get('page') ?? 1;
        $offset = ($page - 1) * $per_page;

        $data['bookings'] = $this->Booking_model->get_all_bookings_admin(
            $per_page, 
            $offset, 
            $status, 
            $search,
            $date_from,
            $date_to
        );
        
        $total_bookings = $this->Booking_model->count_bookings_admin($status, $search, $date_from, $date_to);
        
        $data['pagination'] = [
            'total' => $total_bookings,
            'per_page' => $per_page,
            'current_page' => $page,
            'total_pages' => ceil($total_bookings / $per_page)
        ];

        $data['filters'] = [
            'status' => $status,
            'search' => $search,
            'date_from' => $date_from,
            'date_to' => $date_to
        ];

        $data['stats'] = [
            'total' => $this->Booking_model->get_booking_count(),
            'pending' => $this->Booking_model->get_booking_count('pending'),
            'confirmed' => $this->Booking_model->get_booking_count('confirmed'),
            'completed' => $this->Booking_model->get_booking_count('completed'),
            'cancelled' => $this->Booking_model->get_booking_count('cancelled')
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/bookings/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function view($uid)
    {
        $data = $this->get_admin_data();
        
        $booking = $this->Booking_model->get_booking_details($uid);
        
        if (!$booking) {
            $this->session->set_flashdata('error', 'Booking not found.');
            redirect('admin/bookings');
        }

        $this->load->model('Settings_model');
        $data['settings'] = $this->Settings_model->get_all();
        $data['page_title'] = 'Booking: ' . $booking->booking_ref;
        $data['booking'] = $booking;
        $data['status_history'] = $this->Booking_model->get_status_history($booking->id);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/bookings/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function update_status($uid)
    {
        // Only accept POST requests
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/bookings');
            return;
        }

        // CSRF token validation is handled automatically by CodeIgniter
        // No manual validation needed when csrf_protection is enabled in config

        $booking = $this->Booking_model->get_booking_details($uid);
        
        if (!$booking) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode(['success' => false, 'message' => 'Booking not found']);
                return;
            }
            $this->session->set_flashdata('error', 'Booking not found.');
            redirect('admin/bookings');
            return;
        }

        $new_status = $this->input->post('status');
        $notes = $this->input->post('notes') ?? '';
        $old_status = $booking->status;

        $valid_statuses = ['pending', 'confirmed', 'deposit_paid', 'paid', 'cancelled', 'completed'];
        
        if (!in_array($new_status, $valid_statuses)) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode(['success' => false, 'message' => 'Invalid status']);
                return;
            }
            $this->session->set_flashdata('error', 'Invalid status.');
            redirect('admin/bookings/view/' . $uid);
            return;
        }

        if ($this->Booking_model->update_booking_status($booking->id, $new_status)) {
            $admin_id = $this->session->userdata('admin_id');
            $this->Booking_model->add_status_history($booking->id, $old_status, $new_status, $admin_id, $notes);
            
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode([
                    'success' => true, 
                    'message' => 'Status updated successfully',
                    'new_status' => $new_status
                ]);
                return;
            }
            $this->session->set_flashdata('success', 'Booking status updated successfully.');
        } else {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode(['success' => false, 'message' => 'Failed to update status']);
                return;
            }
            $this->session->set_flashdata('error', 'Failed to update booking status.');
        }

        redirect('admin/bookings/view/' . $uid);
    }

    public function delete($uid)
    {
        // Only accept POST requests
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/bookings');
            return;
        }

        // CSRF token validation is handled automatically by CodeIgniter
        // No manual validation needed when csrf_protection is enabled in config

        $booking = $this->Booking_model->get_booking_details($uid);
        
        if (!$booking) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode(['success' => false, 'message' => 'Booking not found']);
                return;
            }
            $this->session->set_flashdata('error', 'Booking not found.');
            redirect('admin/bookings');
            return;
        }

        if ($this->Booking_model->delete_booking($booking->id)) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode(['success' => true, 'message' => 'Booking deleted successfully']);
                return;
            }
            $this->session->set_flashdata('success', 'Booking deleted successfully.');
        } else {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json');
                echo json_encode(['success' => false, 'message' => 'Failed to delete booking']);
                return;
            }
            $this->session->set_flashdata('error', 'Failed to delete booking.');
        }

        redirect('admin/bookings');
    }

    public function export()
    {
        $status = $this->input->get('status') ?? 'all';
        $date_from = $this->input->get('date_from') ?? '';
        $date_to = $this->input->get('date_to') ?? '';

        $bookings = $this->Booking_model->get_bookings_for_export($status, $date_from, $date_to);

        $filename = 'bookings_export_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        fputcsv($output, [
            'Booking Ref',
            'Customer Name',
            'Email',
            'Phone',
            'Country',
            'Package',
            'Travel Date',
            'Adults',
            'Children',
            'Accommodation',
            'Total Price (USD)',
            'Status',
            'Special Requests',
            'Booked On'
        ]);
        
        foreach ($bookings as $booking) {
            fputcsv($output, [
                $booking->booking_ref,
                $booking->customer_name,
                $booking->customer_email,
                $booking->customer_phone,
                $booking->customer_country ?? '',
                $booking->package_name,
                $booking->travel_date,
                $booking->travelers_adults,
                $booking->travelers_children,
                $booking->accommodation_preference ?? '',
                $booking->total_price,
                ucfirst($booking->status),
                $booking->special_requests ?? '',
                $booking->created_at
            ]);
        }
        
        fclose($output);
        exit;
    }

    /**
     * Send custom email to customer (internal - no external email client)
     */
    public function send_email($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/bookings/view/' . $uid);
            return;
        }

        $booking = $this->Booking_model->get_booking_details($uid);
        
        if (!$booking) {
            $this->session->set_flashdata('error', 'Booking not found.');
            redirect('admin/bookings');
            return;
        }

        $subject = $this->input->post('email_subject');
        $message = $this->input->post('email_message');

        if (empty($subject) || empty($message)) {
            $this->session->set_flashdata('error', 'Subject and message are required.');
            redirect('admin/bookings/view/' . $uid);
            return;
        }

        $this->load->model('Settings_model');
        $settings = $this->Settings_model->get_all();

        $this->load->library('email');
        
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
        $this->email->from($settings['site_email'] ?? 'noreply@osiramsafari.com', $settings['site_name'] ?? 'Osiram Safari Adventure');
        $this->email->to($booking->customer_email);
        $this->email->subject($subject);
        $this->email->message($this->build_email_template($booking, $message, $settings));

        if ($this->email->send()) {
            $this->session->set_flashdata('success', 'Email sent successfully to ' . $booking->customer_email);
        } else {
            $this->session->set_flashdata('error', 'Failed to send email. Please check your email settings.');
        }

        redirect('admin/bookings/view/' . $uid);
    }

    /**
     * Send Invoice to customer
     */
    public function send_invoice($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/bookings/view/' . $uid);
            return;
        }

        $booking = $this->Booking_model->get_booking_details($uid);
        
        if (!$booking) {
            $this->session->set_flashdata('error', 'Booking not found.');
            redirect('admin/bookings');
            return;
        }

        $this->load->model('Settings_model');
        $settings = $this->Settings_model->get_all();

        $this->load->library('email');
        
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
        $this->email->from($settings['site_email'] ?? 'noreply@osiramsafari.com', $settings['site_name'] ?? 'Osiram Safari Adventure');
        $this->email->to($booking->customer_email);
        $this->email->subject('Invoice - ' . $booking->booking_ref . ' | ' . ($settings['site_name'] ?? 'Osiram Safari Adventure'));
        $this->email->message($this->build_invoice_email($booking, $settings));

        if ($this->email->send()) {
            $this->session->set_flashdata('success', 'Invoice sent successfully to ' . $booking->customer_email);
        } else {
            $this->session->set_flashdata('error', 'Failed to send invoice. Please check your email settings.');
        }

        redirect('admin/bookings/view/' . $uid);
    }

    /**
     * Send Bank Details to customer
     */
    public function send_bank_details($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/bookings/view/' . $uid);
            return;
        }

        $booking = $this->Booking_model->get_booking_details($uid);
        
        if (!$booking) {
            $this->session->set_flashdata('error', 'Booking not found.');
            redirect('admin/bookings');
            return;
        }

        $this->load->model('Settings_model');
        $settings = $this->Settings_model->get_all();

        // Check if bank details are configured
        if (empty($settings['bank_name']) || empty($settings['bank_account_number'])) {
            $this->session->set_flashdata('error', 'Bank details not configured. Please update them in Settings → Payment tab.');
            redirect('admin/bookings/view/' . $uid);
            return;
        }

        $this->load->library('email');
        
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
        $this->email->from($settings['site_email'] ?? 'noreply@osiramsafari.com', $settings['site_name'] ?? 'Osiram Safari Adventure');
        $this->email->to($booking->customer_email);
        $this->email->subject('Payment Details - ' . $booking->booking_ref . ' | ' . ($settings['site_name'] ?? 'Osiram Safari Adventure'));
        $this->email->message($this->build_bank_details_email($booking, $settings));

        if ($this->email->send()) {
            $this->session->set_flashdata('success', 'Bank details sent successfully to ' . $booking->customer_email);
        } else {
            $this->session->set_flashdata('error', 'Failed to send bank details. Please check your email settings.');
        }

        redirect('admin/bookings/view/' . $uid);
    }

    /**
     * Build email template wrapper
     */
    private function build_email_template($booking, $message, $settings)
    {
        $site_name = $settings['site_name'] ?? 'Osiram Safari Adventure';
        $site_email = $settings['site_email'] ?? 'welcome@osiramsafari.com';
        $site_phone = $settings['site_phone'] ?? '+255 789 356 961';
        
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
                .booking-ref { background: #fff; padding: 15px; border-left: 4px solid #198754; margin: 20px 0; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; background: #e9ecef; border-radius: 0 0 10px 10px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1 style="margin:0;">🦁 ' . htmlspecialchars($site_name) . '</h1>
                </div>
                
                <div class="content">
                    <p>Dear <strong>' . htmlspecialchars($booking->customer_name) . '</strong>,</p>
                    
                    <div class="booking-ref">
                        <strong>Booking Reference:</strong> ' . htmlspecialchars($booking->booking_ref) . '
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
     * Build Invoice Email HTML
     */
    private function build_invoice_email($booking, $settings)
    {
        $site_name = $settings['site_name'] ?? 'Osiram Safari Adventure';
        $site_email = $settings['site_email'] ?? 'welcome@osiramsafari.com';
        $site_phone = $settings['site_phone'] ?? '+255 789 356 961';
        $site_address = $settings['site_address'] ?? 'Box 15907 Arusha, Tanzania';
        $currency_symbol = $settings['currency_symbol'] ?? '$';
        
        $travel_date_formatted = date('F d, Y', strtotime($booking->travel_date));
        $invoice_date = date('F d, Y');
        $due_date = date('F d, Y', strtotime('+7 days'));
        
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
                .container { max-width: 700px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #0d6efd, #198754); color: white; padding: 30px; text-align: center; }
                .invoice-info { background: #f8f9fa; padding: 20px; margin: 20px 0; border-radius: 8px; }
                .invoice-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                .invoice-table th, .invoice-table td { padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6; }
                .invoice-table th { background: #e9ecef; font-weight: 600; }
                .total-row { background: #198754; color: white; font-size: 18px; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1 style="margin:0;">🦁 INVOICE</h1>
                    <p style="margin:10px 0 0;">' . htmlspecialchars($site_name) . '</p>
                </div>
                
                <div class="invoice-info">
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                <strong>Invoice To:</strong><br>
                                ' . htmlspecialchars($booking->customer_name) . '<br>
                                ' . htmlspecialchars($booking->customer_email) . '<br>
                                ' . htmlspecialchars($booking->customer_phone) . '<br>
                                ' . htmlspecialchars($booking->customer_country ?? '') . '
                            </td>
                            <td width="50%" style="text-align: right;">
                                <strong>Invoice #:</strong> ' . htmlspecialchars($booking->booking_ref) . '<br>
                                <strong>Date:</strong> ' . $invoice_date . '<br>
                                <strong>Due Date:</strong> ' . $due_date . '<br>
                                <strong>Status:</strong> <span style="color: #dc3545;">' . ucfirst($booking->payment_status ?? 'Unpaid') . '</span>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>' . htmlspecialchars($booking->package_name ?? 'Safari Package') . '</strong><br>
                                <small>Travel Date: ' . $travel_date_formatted . '</small><br>
                                <small>Duration: ' . ($booking->duration_days ?? 'N/A') . ' Days</small><br>
                                <small>Accommodation: ' . ucfirst($booking->accommodation_preference ?? 'Mid-range') . '</small>
                            </td>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: right;">' . $currency_symbol . number_format($booking->base_price ?? 0, 2) . '</td>
                        </tr>
                        <tr>
                            <td>Adults</td>
                            <td style="text-align: center;">' . $booking->travelers_adults . '</td>
                            <td style="text-align: right;">' . $currency_symbol . number_format($booking->adult_total ?? 0, 2) . '</td>
                        </tr>
                        ' . ($booking->travelers_children > 0 ? '
                        <tr>
                            <td>Children</td>
                            <td style="text-align: center;">' . $booking->travelers_children . '</td>
                            <td style="text-align: right;">' . $currency_symbol . number_format($booking->children_total ?? 0, 2) . '</td>
                        </tr>
                        ' : '') . '
                        ' . (($booking->single_supplement ?? 0) > 0 ? '
                        <tr>
                            <td>Single Supplement</td>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: right;">' . $currency_symbol . number_format($booking->single_supplement, 2) . '</td>
                        </tr>
                        ' : '') . '
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <th colspan="2">TOTAL AMOUNT</th>
                            <th style="text-align: right;">' . $currency_symbol . number_format($booking->total_price, 2) . ' USD</th>
                        </tr>
                    </tfoot>
                </table>
                
                <div style="background: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0;">
                    <strong>⚠️ Payment Terms:</strong>
                    <ul style="margin: 10px 0;">
                        <li>A 30% deposit is required to confirm your booking</li>
                        <li>Full payment is due 30 days before travel date</li>
                        <li>Please reference your booking number when making payment</li>
                    </ul>
                </div>
                
                <div class="footer">
                    <p><strong>' . htmlspecialchars($site_name) . '</strong></p>
                    <p>📍 ' . htmlspecialchars($site_address) . '</p>
                    <p>📞 ' . htmlspecialchars($site_phone) . ' | ✉️ ' . htmlspecialchars($site_email) . '</p>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Build Bank Details Email HTML
     */
    private function build_bank_details_email($booking, $settings)
    {
        $site_name = $settings['site_name'] ?? 'Osiram Safari Adventure';
        $site_email = $settings['site_email'] ?? 'welcome@osiramsafari.com';
        $site_phone = $settings['site_phone'] ?? '+255 789 356 961';
        $currency_symbol = $settings['currency_symbol'] ?? '$';
        
        $bank_name = $settings['bank_name'] ?? '';
        $bank_account_name = $settings['bank_account_name'] ?? '';
        $bank_account_number = $settings['bank_account_number'] ?? '';
        $bank_swift_code = $settings['bank_swift_code'] ?? '';
        $bank_branch = $settings['bank_branch'] ?? '';
        $bank_currency = $settings['bank_currency'] ?? 'USD';
        $bank_additional_info = $settings['bank_additional_info'] ?? '';
        
        $deposit_amount = $booking->total_price * 0.30;
        
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
                .bank-details { background: #fff; padding: 20px; border: 2px solid #198754; border-radius: 8px; margin: 20px 0; }
                .bank-details table { width: 100%; }
                .bank-details th { text-align: left; padding: 8px; color: #666; width: 40%; }
                .bank-details td { padding: 8px; font-weight: bold; }
                .amount-box { background: #198754; color: white; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; background: #e9ecef; border-radius: 0 0 10px 10px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1 style="margin:0;">🏦 Payment Details</h1>
                    <p style="margin:10px 0 0;">' . htmlspecialchars($site_name) . '</p>
                </div>
                
                <div class="content">
                    <p>Dear <strong>' . htmlspecialchars($booking->customer_name) . '</strong>,</p>
                    
                    <p>Thank you for booking with us! Please find our bank details below for your payment:</p>
                    
                    <div style="background: #fff; padding: 15px; border-left: 4px solid #0d6efd; margin: 20px 0;">
                        <strong>Booking Reference:</strong> ' . htmlspecialchars($booking->booking_ref) . '<br>
                        <strong>Package:</strong> ' . htmlspecialchars($booking->package_name ?? 'Safari Package') . '
                    </div>
                    
                    <div class="amount-box">
                        <p style="margin:0; font-size: 14px;">Total Amount</p>
                        <p style="margin: 5px 0; font-size: 28px; font-weight: bold;">' . $currency_symbol . number_format($booking->total_price, 2) . ' USD</p>
                        <p style="margin: 10px 0 0; font-size: 14px;">Deposit Required (30%): <strong>' . $currency_symbol . number_format($deposit_amount, 2) . ' USD</strong></p>
                    </div>
                    
                    <div class="bank-details">
                        <h3 style="margin-top: 0; color: #198754;"><i>🏦</i> Bank Transfer Details</h3>
                        <table>
                            <tr>
                                <th>Bank Name:</th>
                                <td>' . htmlspecialchars($bank_name) . '</td>
                            </tr>
                            <tr>
                                <th>Account Name:</th>
                                <td>' . htmlspecialchars($bank_account_name) . '</td>
                            </tr>
                            <tr>
                                <th>Account Number:</th>
                                <td>' . htmlspecialchars($bank_account_number) . '</td>
                            </tr>
                            ' . (!empty($bank_swift_code) ? '
                            <tr>
                                <th>SWIFT Code:</th>
                                <td>' . htmlspecialchars($bank_swift_code) . '</td>
                            </tr>
                            ' : '') . '
                            ' . (!empty($bank_branch) ? '
                            <tr>
                                <th>Branch:</th>
                                <td>' . htmlspecialchars($bank_branch) . '</td>
                            </tr>
                            ' : '') . '
                            <tr>
                                <th>Currency:</th>
                                <td>' . htmlspecialchars($bank_currency) . '</td>
                            </tr>
                        </table>
                        ' . (!empty($bank_additional_info) ? '
                        <hr style="margin: 15px 0; border: none; border-top: 1px solid #ddd;">
                        <p style="margin: 0; font-size: 14px; color: #666;">' . nl2br(htmlspecialchars($bank_additional_info)) . '</p>
                        ' : '') . '
                    </div>
                    
                    <div style="background: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0;">
                        <strong>⚠️ Important:</strong>
                        <ul style="margin: 10px 0 0;">
                            <li>Please include your booking reference <strong>' . htmlspecialchars($booking->booking_ref) . '</strong> in the payment description</li>
                            <li>Send us the payment receipt via email or WhatsApp for faster confirmation</li>
                            <li>Bank transfers may take 2-3 business days to process</li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer">
                    <p><strong>' . htmlspecialchars($site_name) . '</strong></p>
                    <p>📞 ' . htmlspecialchars($site_phone) . ' | ✉️ ' . htmlspecialchars($site_email) . '</p>
                    <p>
                        <a href="https://wa.me/' . preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '') . '?text=Hi!%20My%20booking%20ref%20is%20' . $booking->booking_ref . '" style="color: #25d366; text-decoration: none;">
                            💬 WhatsApp Us
                        </a>
                    </p>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Print-friendly booking view
     */
    public function print_view($uid)
    {
        $booking = $this->Booking_model->get_booking_details($uid);
        
        if (!$booking) {
            $this->session->set_flashdata('error', 'Booking not found.');
            redirect('admin/bookings');
            return;
        }

        $this->load->model('Settings_model');
        $data['settings'] = $this->Settings_model->get_all();
        $data['booking'] = $booking;
        $data['page_title'] = 'Print Booking: ' . $booking->booking_ref;

        $this->load->view('admin/bookings/print', $data);
    }
}
