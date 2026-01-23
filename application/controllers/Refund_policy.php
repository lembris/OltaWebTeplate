<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refund_policy extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('template');
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['current_page_name'] = 'Refund Policy';
        $data['main_page'] = '';

        $active_template = get_active_template();

        if ($active_template === 'medical') {
            $data['page_title'] = 'Refund Policy | TNA CARE - Service Refund Terms';
            $data['meta_description'] = 'Learn about TNA CARE\'s refund policy for healthcare services, consultations, and treatments.';
            $data['meta_keywords'] = 'refund policy, healthcare refunds, TNA CARE refunds, cancellation policy';
        } elseif ($active_template === 'college') {
            $data['page_title'] = 'Refund Policy | Academic Institution Refund Terms';
            $data['meta_description'] = 'Learn about our refund policy for courses, programs, and educational services.';
            $data['meta_keywords'] = 'refund policy, course refunds, academic refunds, cancellation policy';
        } else {
            $data['page_title'] = 'Refund Policy | Safari Adventure Tours Refund Terms';
            $data['meta_description'] = 'Learn about our refund policy for safari tours, packages, and travel services.';
            $data['meta_keywords'] = 'refund policy, safari refunds, travel refunds, cancellation policy';
        }

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('refund-policy', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}