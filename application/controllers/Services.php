<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends Frontend_Controller {

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
        $data['current_page_name'] = 'Our Services';
        
        $active_template = get_active_template();
        
        if ($active_template === 'medical') {
            $data['page_title'] = 'Our Services - TNA CARE';
            $data['meta_description'] = 'Discover TNA CARE comprehensive healthcare services including health education, medical outreach, corporate wellness, and digital health solutions.';
            
            $this->load->model('Testimonial_model');
            $data['testimonials'] = $this->Testimonial_model->get_featured(6);
            
            // Load medical specialties (TNA CARE services) - same as home page
            $data['medical_specialties'] = [];
            if ($this->db->table_exists('specialties')) {
                try {
                    $data['medical_specialties'] = $this->Specialty_model->get_active(20, 0);
                } catch (Exception $e) {
                    $data['medical_specialties'] = [];
                }
            }
        } else {
            $data['page_title'] = 'Our Services - Safari Adventure Tours';
            $data['meta_description'] = 'Learn about our safari packages and adventure services.';
        }

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('services', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}
