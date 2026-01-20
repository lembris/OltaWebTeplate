<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expertise extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Expertise_model');
        $this->load->helper('template');
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['current_page_name'] = 'Our Expertise';
        $data['page_title'] = 'Medical Expertise | TNA CARE';
        $data['page_description'] = 'Our team of medical professionals brings expertise across various specialized fields including cardiology, surgery, oncology, and more.';
        
        $data['expertises'] = $this->Expertise_model->get_all_active('display_order', 'asc');
        
        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('expertise', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    public function view($slug = null)
    {
        if (empty($slug)) {
            redirect('expertise');
        }

        $data = $this->get_common_data();
        
        $expertise = $this->Expertise_model->get_by_slug($slug);
        
        if (!$expertise) {
            show_404();
        }

        $data['current_page_name'] = $expertise->name;
        $data['page_title'] = $expertise->name . ' | TNA CARE';
        $data['page_description'] = $expertise->short_description;
        $data['expertise'] = $expertise;
        
        $data['related_expertises'] = $this->Expertise_model->get_all_active('display_order', 'asc');
        
        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('expertise-detail', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}
