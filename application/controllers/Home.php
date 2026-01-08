<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('text');
		$this->load->helper('template');
		
		// Load models based on active template
		$active_template = get_active_template();
		
		if ($active_template === 'college') {
			// College template models
			$this->load->model('Academic_program_model');
			$this->load->model('Department_model');
			$this->load->model('Faculty_staff_model');
			$this->load->model('Gallery_model');
		} else {
			// Tourism template models
			$this->load->model('Package_model');
			$this->load->model('Destination_model');
			$this->load->model('Gallery_model');
		}
		
		// Load Blog model if exists
		if (file_exists(APPPATH . 'models/Blog_model.php')) {
			$this->load->model('Blog_model');
		}
		
		// Load common content models (Events, Notices, Announcements)
		$this->load->model('Event_calendar_model');
		$this->load->model('Notice_model');
		$this->load->model('Announcement_model');
	}

	public function index()
	{
		// Get common site data from database settings
		$data = $this->get_common_data();
		$data['main_page'] = '';
		
		$active_template = get_active_template();
		$data['current_page_name'] = 'Home';
		
		// Load template-specific content
		if ($active_template === 'college') {
			$this->load_college_content($data);
		} else {
			$this->load_tourism_content($data);
		}

		// Load template-specific header, navigation, page, and footer
		load_template_view('header', $data);
		load_template_view('navigation', $data);
		load_template_page('home', $data);
		load_template_view('footer', $data);
	}
	
	/**
	 * Load content specific to the College template
	 */
	private function load_college_content(&$data)
	{
		// SEO Meta Tags for College
		$data['page_title'] = 'Quality Education & Academic Excellence';
		$data['meta_description'] = 'Discover world-class education with expert instructors and industry-relevant programs. Apply now for our diverse range of courses and certifications.';
		$data['meta_keywords'] = 'college, education, courses, programs, university, learning, diploma, degree, certification, academic';
		
		// Load academic programs instead of packages
		$data['featured_programs'] = [];
		$data['programs'] = [];
		$data['program_count'] = 0;
		$data['footer_programs'] = [];
		
		try {
			$data['featured_programs'] = $this->Academic_program_model->get_featured(3);
			$data['programs'] = $this->Academic_program_model->get_active(9);
			$data['program_count'] = $this->Academic_program_model->count_programs('active');
			$data['footer_programs'] = $this->Academic_program_model->get_active(6);
		} catch (Exception $e) {
			// Silent fail - use empty arrays
		}
		
		// Load departments for homepage
		$data['departments'] = [];
		try {
			$data['departments'] = $this->Department_model->get_active(3);
		} catch (Exception $e) {
			$data['departments'] = [];
		}
		
		// Load featured faculty
		$data['featured_faculty'] = [];
		try {
			$data['featured_faculty'] = $this->Faculty_staff_model->get_active(4);
		} catch (Exception $e) {
			$data['featured_faculty'] = [];
		}
		
		// Clear tourism-specific data
		$data['packages'] = [];
		$data['featured_packages'] = [];
		$data['featured_destinations'] = [];
		
		// Load gallery images
		$data['gallery_images'] = [];
		try {
			$data['gallery_images'] = $this->Gallery_model->get_featured(8);
		} catch (Exception $e) {
			$data['gallery_images'] = [];
		}
		
		// Load Events, Notices, and Announcements
		$data['upcoming_events'] = [];
		$data['latest_notices'] = [];
		$data['homepage_announcements'] = [];
		
		try {
			$data['upcoming_events'] = $this->Event_calendar_model->get_featured(4);
		} catch (Exception $e) {
			$data['upcoming_events'] = [];
		}
		
		try {
			$data['latest_notices'] = $this->Notice_model->get_latest(4);
		} catch (Exception $e) {
			$data['latest_notices'] = [];
		}
		
		try {
			$data['homepage_announcements'] = $this->Announcement_model->get_homepage_announcements(3);
		} catch (Exception $e) {
			$data['homepage_announcements'] = [];
		}
		
		// For now, don't load blog posts for college template
		// (existing blog posts are tourism-related)
		// TODO: Add blog category filtering by template
		$data['latest_blogs'] = [];
	}
	
	/**
	 * Load content specific to the Tourism template
	 */
	private function load_tourism_content(&$data)
	{
		// SEO Meta Tags for Tourism
		$data['page_title'] = 'African Safari Tours & Wildlife Adventures in Tanzania';
		$data['meta_description'] = 'Experience unforgettable African safari tours in Tanzania. Expert guides, luxury camping, Big Five wildlife guaranteed. 500+ happy travelers. Book your adventure today!';
		$data['meta_keywords'] = 'safari tours, African wildlife, Tanzania safari, Serengeti, Kilimanjaro, Ngorongoro, Big Five, African adventure, safari packages';
		
		// Load dynamic packages from database
		$data['packages'] = $this->Package_model->get_homepage_packages(9);
		$data['featured_packages'] = $this->Package_model->get_featured_packages(3);
		$data['package_count'] = $this->Package_model->count_packages();
		$data['package_filters'] = $this->Package_model->get_filter_buttons(6);

		// Load latest blog posts for homepage
		$data['latest_blogs'] = [];
		if (isset($this->Blog_model)) {
			try {
				$data['latest_blogs'] = $this->Blog_model->get_latest_posts(3);
			} catch (Exception $e) {
				$data['latest_blogs'] = [];
			}
		}

		// Load featured destinations for homepage
		$data['featured_destinations'] = [];
		try {
			$data['featured_destinations'] = $this->Destination_model->get_featured_destinations(4);
		} catch (Exception $e) {
			$data['featured_destinations'] = [];
		}

		// Load featured gallery images for homepage
		$data['gallery_images'] = [];
		try {
			$data['gallery_images'] = $this->Gallery_model->get_featured(8);
		} catch (Exception $e) {
			$data['gallery_images'] = [];
		}
	}
}
