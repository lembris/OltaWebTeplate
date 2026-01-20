<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itinerary extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Itinerary_model');
        $this->load->helper('template');
    }

    /**
     * View itinerary by package ID
     * URL: /itinerary/{package_id}
     */
    public function view($package_id)
    {
        $data = $this->get_common_data();
        
        // Get itinerary
        $data['itinerary'] = $this->Itinerary_model->get_by_package($package_id);

        // Check if exists
        if (!$data['itinerary']) {
            show_404();
        }

        // Get all days
        $data['days'] = $this->Itinerary_model->get_days($data['itinerary']->id);

        // Get next and previous itineraries
        $data['next_itinerary'] = $this->Itinerary_model->get_next_itinerary($data['itinerary']->id);
        $data['prev_itinerary'] = $this->Itinerary_model->get_previous_itinerary($data['itinerary']->id);

        // Page-specific data
        $data['main_page'] = 'Itinerary';
        $data['current_page_name'] = $data['itinerary']->title ?? 'Itinerary Details';

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        // Load views
        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/pages/sections/page-hero-unified', $data);
        $this->load->view('templates/' . $template . '/itinerary/itinerary-detail', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * Get all itineraries listing
     * URL: /itineraries
     */
    public function listing()
    {
        $data = $this->get_common_data();
        $data['itineraries'] = $this->Itinerary_model->get_all();
        
        // Page-specific data
        $data['main_page'] = 'Itineraries';
        $data['current_page_name'] = 'Our Itineraries';

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/pages/sections/page-hero-unified', $data);
        $this->load->view('templates/' . $template . '/itinerary/itinerary-listing', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * API: Get itinerary JSON
     */
    public function api_get($package_id)
    {
        $this->output->set_content_type('application/json');
        $itinerary = $this->Itinerary_model->get_by_package($package_id);
        
        if (!$itinerary) {
            echo json_encode(['error' => 'Itinerary not found']);
            return;
        }

        $days = $this->Itinerary_model->get_days($itinerary->id);
        echo json_encode([
            'itinerary' => $itinerary,
            'days' => $days
        ]);
    }

    /**
     * API: Get all itineraries
     */
    public function api_all()
    {
        $this->output->set_content_type('application/json');
        $itineraries = $this->Itinerary_model->get_all();
        echo json_encode($itineraries);
    }

    /**
     * API: Search itineraries
     */
    public function api_search($keyword)
    {
        $this->output->set_content_type('application/json');
        $results = $this->Itinerary_model->search($keyword);
        echo json_encode($results);
    }
}
