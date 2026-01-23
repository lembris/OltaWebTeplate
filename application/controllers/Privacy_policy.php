<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy_policy extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('template');
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['current_page_name'] = 'Privacy Policy';
        $data['main_page'] = '';

        $active_template = get_active_template();

        if ($active_template === 'medical') {
            $data['page_title'] = 'Privacy Policy | TNA CARE - Healthcare Privacy Protection';
            $data['meta_description'] = 'Learn how TNA CARE protects your privacy and handles your personal information in our healthcare services.';
            $data['meta_keywords'] = 'privacy policy, data protection, healthcare privacy, TNA CARE privacy';
        } elseif ($active_template === 'college') {
            $data['page_title'] = 'Privacy Policy | Academic Institution Privacy Protection';
            $data['meta_description'] = 'Learn how we protect your privacy and handle your personal information in our educational services.';
            $data['meta_keywords'] = 'privacy policy, data protection, academic privacy, student privacy';
        } else {
            $data['page_title'] = 'Privacy Policy | Safari Adventure Tours Privacy Protection';
            $data['meta_description'] = 'Learn how we protect your privacy and handle your personal information in our safari tour services.';
            $data['meta_keywords'] = 'privacy policy, data protection, safari privacy, travel privacy';
        }

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('privacy-policy', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}