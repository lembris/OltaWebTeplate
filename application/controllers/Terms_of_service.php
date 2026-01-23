<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms_of_service extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('template');
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['current_page_name'] = 'Terms of Service';
        $data['main_page'] = '';

        $active_template = get_active_template();

        if ($active_template === 'medical') {
            $data['page_title'] = 'Terms of Service | TNA CARE - Healthcare Service Terms';
            $data['meta_description'] = 'Read TNA CARE\'s terms of service for our healthcare consultation, education, and outreach services.';
            $data['meta_keywords'] = 'terms of service, healthcare terms, TNA CARE terms, service conditions';
        } elseif ($active_template === 'college') {
            $data['page_title'] = 'Terms of Service | Academic Institution Service Terms';
            $data['meta_description'] = 'Read our terms of service for educational programs, courses, and academic services.';
            $data['meta_keywords'] = 'terms of service, academic terms, course terms, education conditions';
        } else {
            $data['page_title'] = 'Terms of Service | Safari Adventure Tours Service Terms';
            $data['meta_description'] = 'Read our terms of service for safari tours, travel packages, and adventure services.';
            $data['meta_keywords'] = 'terms of service, safari terms, travel terms, tour conditions';
        }

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('terms-of-service', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}