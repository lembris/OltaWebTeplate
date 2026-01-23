<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disclaimer extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('template');
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['current_page_name'] = 'Disclaimer';
        $data['main_page'] = '';

        $active_template = get_active_template();

        if ($active_template === 'medical') {
            $data['page_title'] = 'Disclaimer | TNA CARE - Healthcare Service Disclaimer';
            $data['meta_description'] = 'Important disclaimer regarding TNA CARE healthcare services, medical advice, and treatment information.';
            $data['meta_keywords'] = 'disclaimer, healthcare disclaimer, medical advice, TNA CARE terms';
        } elseif ($active_template === 'college') {
            $data['page_title'] = 'Disclaimer | Academic Institution Service Disclaimer';
            $data['meta_description'] = 'Important disclaimer regarding our educational services, courses, and academic programs.';
            $data['meta_keywords'] = 'disclaimer, academic disclaimer, educational terms, course disclaimer';
        } else {
            $data['page_title'] = 'Disclaimer | Safari Adventure Tours Service Disclaimer';
            $data['meta_description'] = 'Important disclaimer regarding our safari tours, travel services, and adventure activities.';
            $data['meta_keywords'] = 'disclaimer, safari disclaimer, travel terms, adventure disclaimer';
        }

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('disclaimer', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}