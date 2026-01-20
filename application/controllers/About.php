<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('template');
        $this->load->model('Faculty_staff_model');
        $this->load->model('About_timeline_model');
        $this->load->model('About_accreditations_model');
        $this->load->model('About_faq_model');
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['main_page'] = '';
        $data['current_page_name'] = 'About Us';
        
        $active_template = get_active_template();
        
        if ($active_template === 'college') {
            $data['page_title'] = 'About Us - Quality Education Excellence';
            $data['meta_description'] = 'Learn about our institution, our mission, and our commitment to providing quality education.';
            
            // Load featured faculty members for team section
            $featured = $this->Faculty_staff_model->get_featured(8, 0);
            if (!empty($featured)) {
                $data['team_members'] = $featured;
            } else {
                $data['team_members'] = $this->Faculty_staff_model->get_active(8, 0);
            }
            
            // Load featured testimonials (only featured ones show on About page)
            $this->load->model('Testimonial_model');
            $data['testimonials'] = $this->Testimonial_model->get_featured(6);
            
            // Load timeline/history events
            $data['timeline_items'] = $this->About_timeline_model->get_active(20, 0, 'college');
            
            // Load accreditations
            $data['accreditations'] = $this->About_accreditations_model->get_active(20, 0, 'college');
            
            // Load FAQs grouped by category
            $data['faqs'] = $this->About_faq_model->get_grouped_by_category('college');
        } elseif ($active_template === 'medical') {
            $data['page_title'] = 'About Us - TNA CARE';
            $data['meta_description'] = 'Learn about TNA CARE, our mission to bridge the gap between communities and quality healthcare through education, consultation, and strategic partnerships.';
            
            $this->load->model('Testimonial_model');
            $data['testimonials'] = $this->Testimonial_model->get_featured(6);
            
            // Load team members for leadership section (filtered by active template)
            $this->load->model('Team_member_model');
            $active_template = get_active_template();
            
            // Get members filtered by template (all + active theme)
            $data['team_members'] = $this->Team_member_model->get_by_template($active_template, 8);
            
            // Load timeline/history events
            $data['timeline_items'] = $this->About_timeline_model->get_active(20, 0, 'medical');
        } else {
            $data['page_title'] = 'About Us - Safari Adventure Tours';
            $data['meta_description'] = 'Learn about Osiram Safari Adventure and our commitment to exceptional wildlife experiences.';
        }
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('about', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}
