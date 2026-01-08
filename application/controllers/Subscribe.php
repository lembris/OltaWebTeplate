<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribe extends CI_Controller {


    public function index()
	{

        $data['site_name'] = 'Osiram Safari Adventure';
        $data['site_tag'] = 'Tour Operators';
        $data['site_name_abb'] = 'OSA';
        $data['main_page'] = '';

        $data['current_page_name'] = 'About Us';
        $data['consult_number'] = '+255 78 703 3777';
        $data['consult_number_call'] = '255787033777';
        $data['work_hours'] = '9:00AM - 8:00PM';
        $data['address_location'] = 'Suite 3, Mezzanine Floor, R-Square, Plot No. 274, Haile Selassie Road, Opp. IST School, Masaki, P.O. Box 779, Dar es Salaam.';
        $data['email_address']  = 'welcome@osiramsafari.com';

        
    
        // Social Links
        $data['facebook'] = 'SweetandConradLLP?_rdc=1&_rdr';
        $data['instagram'] = 'sweet_and_conrad_advocates';
        $data['linkedin'] = 'company/sweetandconradllp/';
        $data['twitter'] = '';
        $data['youtube'] = '';


        $this->load->view('includes/header', $data);
        //navigation menu
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/home', $data);
        $this->load->view('includes/footer', $data);

	}
}
