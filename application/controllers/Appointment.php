<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends CI_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->model(array('Model_common'));
        $this->load->library('form_validation');
        $this->load->helper('template');
    }

    public function index()
    {
        $data['site_name'] = 'Osiram Safari Adventure';
        $data['site_tag'] = 'Tour Operators';
        $data['site_name_abb'] = 'OSA';
        $data['main_page'] = '';

        $data['current_page_name'] = 'Appointment';
        $data['consult_number'] = '+255 78 703 3777';
        $data['consult_number_call'] = '255787033777';
        $data['work_hours'] = '9:00AM - 8:00PM';
        $data['address_location'] = 'Suite 3, Mezzanine Floor, R-Square, Plot No. 274, Haile Selassie Road, Opp. IST School, Masaki, P.O. Box 779, Dar es Salaam.';
        $data['email_address']  = 'welcome@osiramsafari.com';
    
        // Social Links
        $data['facebook'] = 'osiramsafariadventure';
        $data['instagram'] = 'osiramsafariadventure';
        $data['linkedin'] = 'company/osiramsafariadventure/';
        $data['twitter'] = '';
        $data['youtube'] = '';

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('appointment', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
