<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Package_model');
        $this->load->helper(['form', 'text']);
        $this->load->library(['form_validation', 'email', 'session']);
    }

    /**
     * Packages listing page - Dynamic from database
     */
    public function index()
    {
        $data = $this->get_common_data();
        $data['current_page_name'] = 'Packages';
        $data['main_page'] = 'Packages';
        
        // Get category filter from URL
        $category = $this->input->get('category');
        
        // Load dynamic packages from database
        if ($category && $category !== 'all') {
            $data['packages'] = $this->Package_model->get_packages_by_category($category);
            $data['active_category'] = $category;
        } else {
            $data['packages'] = $this->Package_model->get_all_packages();
            $data['active_category'] = 'all';
        }
        
        $data['package_filters'] = $this->Package_model->get_filter_buttons(8);
        $data['package_count'] = $this->Package_model->count_packages();
        
        // Page hero data
        $data['page_title'] = 'Safari Packages';
        $data['page_subtitle'] = 'Discover our handcrafted safari experiences';
        $data['page_breadcrumb'] = [
            ['title' => 'Home', 'url' => base_url()],
            ['title' => 'Packages', 'url' => '']
        ];

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/packages-list', $data);
        $this->load->view('includes/footer', $data);
    }

    /**
     * Single package page - Dynamic from database
     * URL format: /packages/package/5-days-safari-package
     */
    public function package($slug)
    {
        // Get package from database
        $package = $this->Package_model->get_package_by_slug($slug);
        
        if (!$package) {
            show_404();
            return;
        }

        $data = $this->get_common_data();
        $data['package'] = $package;
        $data['current_page_name'] = $package->name;
        $data['main_page'] = 'Packages';
        $data['package_filters'] = $this->Package_model->get_filter_buttons(6);
        
        // Get related packages (same category, exclude current)
        $data['related_packages'] = $this->Package_model->get_related_packages($package->id, $package->category, 3);

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/package-detail-dynamic', $data); 
        $this->load->view('includes/footer', $data);
    }

    /**
     * Process package booking enquiry
     */
    public function book_package()
    {
        if (!$this->input->post('enquire_package')) {
            redirect(base_url('packages'));
            return;
        }

        $current_page = $this->input->post('current_page', TRUE);

        $data = [
            'package' => $this->input->post('package', TRUE),
            'fullname' => $this->input->post('fullname', TRUE),
            'adult' => $this->input->post('adult', TRUE),
            'children' => $this->input->post('children', TRUE),
            'email_address' => $this->input->post('email_address', TRUE),
            'arrival' => $this->input->post('arrival', TRUE),
            'departure' => $this->input->post('departure', TRUE),
            'message' => $this->input->post('message', TRUE)
        ];

        if (!empty($data['email_address'])) {
            $receiver_mail = 'osiramsafari@gmail.com';
            $subject = 'PACKAGE ENQUIRY - ' . $data['package'];

            $body = $this->build_enquiry_email($data);

            if ($this->sendEmail($receiver_mail, $subject, $body)) {
                $this->session->set_flashdata('success', 'Your enquiry has been sent successfully! We will contact you within 24 hours.');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again or contact us directly.');
            }
        }

        redirect($current_page);
    }

    /**
     * Build enquiry email HTML
     */
    private function build_enquiry_email($data)
    {
        return '
            <h2>New Package Enquiry</h2>
            <p><strong>Package:</strong> ' . $data['package'] . '</p>
            <p><strong>Name:</strong> ' . $data['fullname'] . '</p>
            <p><strong>Email:</strong> ' . $data['email_address'] . '</p>
            <p><strong>Adults:</strong> ' . $data['adult'] . '</p>
            <p><strong>Children:</strong> ' . $data['children'] . '</p>
            <p><strong>Arrival Date:</strong> ' . $data['arrival'] . '</p>
            <p><strong>Departure Date:</strong> ' . $data['departure'] . '</p>
            <p><strong>Special Request:</strong><br>' . nl2br($data['message']) . '</p>
        ';
    }

    /**
     * Search packages - Dynamic from database
     * Handles Tour Finder form from homepage
     */
    public function search()
    {
        $data = $this->get_common_data();
        $data['current_page_name'] = 'Search Results';
        $data['main_page'] = 'Packages';
        
        // Get search parameters
        $destination = $this->input->get('destination', TRUE);
        $travelers = $this->input->get('travelers', TRUE);
        $travel_date = $this->input->get('date', TRUE);
        
        // Pass to view for display
        $data['destination'] = $destination;
        $data['travelers'] = $travelers;
        $data['travel_date'] = $travel_date;
        
        // Search packages from database
        $data['packages'] = $this->Package_model->search_packages([
            'destination' => $destination,
            'travelers' => $travelers,
            'date' => $travel_date
        ]);
        
        $data['package_filters'] = $this->Package_model->get_filter_buttons(6);
        
        // Page hero data
        $data['page_title'] = 'Search Results';
        $data['page_subtitle'] = 'Find your perfect safari adventure';
        $data['page_breadcrumb'] = [
            ['title' => 'Home', 'url' => base_url()],
            ['title' => 'Search Results', 'url' => '']
        ];

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/search-results', $data);
        $this->load->view('includes/footer', $data);
    }

    /**
     * Send email
     */
    private function sendEmail($to, $subject, $message)
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
            'newline' => "\r\n"
        ];

        $this->email->initialize($config);
        $this->email->from('noreply@osiramsafari.com', 'Osiram Safari');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        return $this->email->send();
    }
}
