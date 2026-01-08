<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('template');
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
        } else {
            $data['page_title'] = 'About Us - Safari Adventure Tours';
            $data['meta_description'] = 'Learn about Osiram Safari Adventure and our commitment to exceptional wildlife experiences.';
        }
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('about', $data);
        load_template_view('footer', $data);
    }
}
