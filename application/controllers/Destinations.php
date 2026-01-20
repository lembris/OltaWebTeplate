<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destinations extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Destination_model');
		$this->load->helper('text');
		$this->load->helper('template');
	}

	public function index()
	{
		$data = $this->get_common_data();
		$data['main_page'] = '';
		$data['current_page_name'] = 'Destinations';
		
		// Load destinations from database
		$data['destinations'] = $this->Destination_model->get_all_destinations();

		// Load footer programs for college template
		$data['footer_programs'] = $this->get_footer_programs();

		$template = get_active_template();
		$this->load->view('templates/' . $template . '/header', $data);
		$this->load->view('templates/' . $template . '/navigation', $data);
		load_template_page('destinations', $data);
		$this->load->view('templates/' . $template . '/footer', $data);
	}

	public function destination($slug)
	{
		$data = $this->get_common_data();
		
		// Try to load from database first
		$destination = $this->Destination_model->get_by_slug($slug);
		
		if ($destination) {
			// Dynamic: Load from database
			$data['destination'] = $this->Destination_model->enrich_destination($destination);
			$data['main_page'] = 'Destinations';
			$data['current_page_name'] = $destination->name;
			$data['page_title'] = $destination->name . ' - Safari Destination';
			$data['meta_description'] = !empty($destination->seo_description) 
				? $destination->seo_description 
				: character_limiter($destination->description, 160);
			
			// Get related destinations
			$data['related_destinations'] = $this->Destination_model->get_related($destination->id, 3);

			// Load footer programs for college template
			$data['footer_programs'] = $this->get_footer_programs();

			$template = get_active_template();
			$this->load->view('templates/' . $template . '/header', $data);
			$this->load->view('templates/' . $template . '/navigation', $data);
			load_template_page('destination-detail', $data);
			$this->load->view('templates/' . $template . '/pages/sections/quick-booking', $data);
			$this->load->view('templates/' . $template . '/footer', $data);
		} else {
			// Fallback: Try static file if exists in template
			$template = get_active_template();
			$view_path = APPPATH . 'views/templates/' . $template . '/pages/destinations/' . $slug . '.php';
			
			if (file_exists($view_path)) {
				$data['main_page'] = 'Destinations';
				$data['current_page_name'] = ucwords(str_replace('-', ' ', $slug));

				// Load footer programs for college template
				$data['footer_programs'] = $this->get_footer_programs();

				$this->load->view('templates/' . $template . '/header', $data);
				$this->load->view('templates/' . $template . '/navigation', $data);
				$this->load->view("templates/{$template}/pages/destinations/{$slug}", $data);
				$this->load->view('templates/' . $template . '/pages/sections/quick-booking', $data);
				$this->load->view('templates/' . $template . '/footer', $data);
			} else {
				// 404 - Destination not found
				show_404();
			}
		}
	}
}
