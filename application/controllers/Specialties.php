<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Specialties extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('template');
        $this->load->model('Specialty_model');
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['main_page'] = '';
        $data['current_page_name'] = 'Medical Services';
        
        $active_template = get_active_template();
        
        if ($active_template === 'medical') {
            $data['page_title'] = 'Our Medical Services | TNA CARE';
            $data['meta_description'] = 'Comprehensive health and medical services including health education, medical outreach, corporate wellness, and media production.';
            
            $data['specialties'] = $this->Specialty_model->get_active(100, 0);
        } else {
            $data['page_title'] = 'Our Services - Safari Adventure Tours';
            $data['meta_description'] = 'Learn about our safari packages and adventure services.';
            
            $data['specialties'] = $this->Specialty_model->get_active(100, 0);
        }

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('specialties', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    public function view($slug = null)
    {
        if (empty($slug)) {
            redirect('specialties');
        }

        $data = $this->get_common_data();
        
        $specialty = $this->Specialty_model->get_by_slug($slug);
        
        if (!$specialty) {
            show_404();
        }

        $data['main_page'] = '';
        $data['current_page_name'] = $specialty->name;
        $data['page_title'] = $specialty->name . ' | TNA CARE';
        $data['meta_description'] = $specialty->short_description;
        $data['specialty'] = $specialty;
        
        $data['related_specialties'] = $this->Specialty_model->get_active(100, 0);
        
        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('specialty-detail', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}
