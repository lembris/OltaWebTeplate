<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partners extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('template');
        $this->load->model('Partner_model');
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['main_page'] = '';
        $data['current_page_name'] = 'Our Partners';
        
        $active_template = get_active_template();
        
        if ($active_template === 'medical') {
            $data['page_title'] = 'Hospital Partners | TNA CARE';
            $data['meta_description'] = 'TNA CARE partners with leading hospitals and healthcare organizations across Tanzania and internationally.';
            
            $data['tz_partners'] = $this->Partner_model->get_all_by_type('tanzania', 'display_order', 'asc');
            $data['int_partners'] = $this->Partner_model->get_all_by_type('international', 'display_order', 'asc');
        } else {
            $data['page_title'] = 'Our Partners - Safari Adventure Tours';
            $data['meta_description'] = 'Learn about our safari partners and collaborators.';
            
            $data['partners'] = $this->Partner_model->get_all_active('display_order', 'asc');
        }

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('partners', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    public function view($slug = null)
    {
        if (empty($slug)) {
            redirect('partners');
        }

        $data = $this->get_common_data();
        
        $partner = $this->Partner_model->get_by_slug($slug);
        
        if (!$partner) {
            show_404();
        }

        $data['current_page_name'] = $partner->name;
        $data['page_title'] = $partner->name . ' | TNA CARE Partner';
        $data['meta_description'] = $partner->short_description;
        $data['partner'] = $partner;
        
        $data['related_partners'] = $this->Partner_model->get_all_active('display_order', 'asc');
        
        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('partner-detail', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}
