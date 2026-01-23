<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cookie_policy extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('template');
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['current_page_name'] = 'Cookie Policy';
        $data['main_page'] = '';

        $active_template = get_active_template();

        if ($active_template === 'medical') {
            $data['page_title'] = 'Cookie Policy | TNA CARE - Website Cookie Usage';
            $data['meta_description'] = 'Learn about how TNA CARE uses cookies and tracking technologies on our healthcare website.';
            $data['meta_keywords'] = 'cookie policy, website cookies, tracking, TNA CARE privacy';
        } elseif ($active_template === 'college') {
            $data['page_title'] = 'Cookie Policy | Academic Institution Cookie Usage';
            $data['meta_description'] = 'Learn about how we use cookies and tracking technologies on our educational website.';
            $data['meta_keywords'] = 'cookie policy, website cookies, tracking, academic privacy';
        } else {
            $data['page_title'] = 'Cookie Policy | Safari Adventure Tours Cookie Usage';
            $data['meta_description'] = 'Learn about how we use cookies and tracking technologies on our safari website.';
            $data['meta_keywords'] = 'cookie policy, website cookies, tracking, safari privacy';
        }

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('cookie-policy', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}