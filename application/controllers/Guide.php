<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guide extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('template');
    }

    public function weather()
    {
        $data = $this->get_common_data();
        $data['main_page'] = 'Guide';
        $data['current_page_name'] = 'Weather condition';

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('travel-guide/weather', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    public function food()
    {
        $data = $this->get_common_data();
        $data['main_page'] = 'Guide';
        $data['current_page_name'] = 'Food';

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('travel-guide/food', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    public function cost()
    {
        $data = $this->get_common_data();
        $data['main_page'] = 'Guide';
        $data['current_page_name'] = 'Cost';

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('travel-guide/cost', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    public function visa()
    {
        $data = $this->get_common_data();
        $data['main_page'] = 'Guide';
        $data['current_page_name'] = 'Visa';

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('travel-guide/visa', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}
