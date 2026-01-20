<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends Frontend_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->model('About_faq_model');
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['main_page'] = '';
        $data['current_page_name'] = 'FAQ';
        
        $active_template = get_active_template();
        
        if ($active_template === 'medical') {
            $data['page_title'] = 'Frequently Asked Questions | TNA CARE';
            $data['meta_description'] = 'Browse our complete FAQ library for answers about TNA CARE services, consultations, corporate wellness, partnerships, and more healthcare solutions in Tanzania.';
            $data['canonical_url'] = base_url('faq');
            $data['og_image'] = base_url('assets/templates/medical/img/health/tna-female-doctor-community-health.png');
            
            // Load all FAQs grouped by category
            $data['all_faqs'] = $this->About_faq_model->get_grouped_by_category('medical');
        } else {
            $data['page_title'] = 'Frequently Asked Questions';
            $data['meta_description'] = 'Find answers to frequently asked questions.';
        }
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('faq', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}
