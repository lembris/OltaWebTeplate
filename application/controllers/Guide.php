<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guide extends Frontend_Controller {

    public function weather()
    {
        $data = $this->get_common_data();
        $data['main_page'] = 'Guide';
        $data['current_page_name'] = 'Weather condition';

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/travel-guide/weather', $data);
        $this->load->view('includes/footer', $data);
    }

    public function food()
    {
        $data = $this->get_common_data();
        $data['main_page'] = 'Guide';
        $data['current_page_name'] = 'Food';

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/travel-guide/food', $data);
        $this->load->view('includes/footer', $data);
    }

    public function cost()
    {
        $data = $this->get_common_data();
        $data['main_page'] = 'Guide';
        $data['current_page_name'] = 'Cost';

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/travel-guide/cost', $data);
        $this->load->view('includes/footer', $data);
    }

    public function visa()
    {
        $data = $this->get_common_data();
        $data['main_page'] = 'Guide';
        $data['current_page_name'] = 'Visa';

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/travel-guide/visa', $data);
        $this->load->view('includes/footer', $data);
    }
}
