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
			$this->load->model('About_accreditations_model');
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
		} elseif ($active_template === 'medical') {
			$this->load_medical_content($data);
		} else {
			$this->load_tourism_content($data);
		}

		// Load template-specific header, navigation, page, and footer
		// Use direct view loading for template components (header, navigation, footer are in template root)
		$template = get_active_template();
		$this->load->view('templates/' . $template . '/header', $data);
		$this->load->view('templates/' . $template . '/navigation', $data);
		load_template_page('home', $data);
		$this->load->view('templates/' . $template . '/footer', $data);
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
		
		// Load accreditations for homepage
		$data['accreditations'] = [];
		try {
			$data['accreditations'] = $this->About_accreditations_model->get_active(10, 0, 'college');
		} catch (Exception $e) {
			$data['accreditations'] = [];
		}
		
		// Load testimonials for homepage
		$data['testimonials'] = [];
		if ($this->db->table_exists('testimonials')) {
			try {
				$this->load->model('Testimonial_model');
				$data['testimonials'] = $this->Testimonial_model->get_active(6);
			} catch (Exception $e) {
				$data['testimonials'] = [];
			}
		}
	}
	
	/**
	 * Load content specific to the Medical template
	 */
	private function load_medical_content(&$data)
	{
		// SEO Meta Tags for Medical
		$data['page_title'] = 'TNA CARE | Connecting Communities to Better Health';
		$data['meta_description'] = 'TNA CARE is a Tanzanian health service facilitator offering digital health education, corporate wellness programs, medical outreach, and health media solutions.';
		$data['meta_keywords'] = 'TNA CARE, healthcare Tanzania, digital health, health education, corporate wellness, medical outreach, public health media';
		
		// Stats counters - can be configured in settings or use defaults
		$data['stats'] = [
			'people_reached' => $this->get_setting('medical_people_reached', '1'),
			'subscribers' => $this->get_setting('medical_subscribers', '19.7'),
			'partnerships' => $this->get_setting('medical_partnerships', '50'),
			'years_service' => $this->get_setting('medical_years_service', '5')
		];
		
		// Load testimonials - only if table exists
		$data['testimonials'] = [];
		if ($this->db->table_exists('testimonials')) {
			try {
				$this->load->model('Testimonial_model');
				$data['testimonials'] = $this->Testimonial_model->get_featured(6);
			} catch (Exception $e) {
				$data['testimonials'] = [];
			}
		}
		
		// Load gallery images
		$data['gallery_images'] = [];
		try {
			$data['gallery_images'] = $this->Gallery_model->get_featured(8);
		} catch (Exception $e) {
			$data['gallery_images'] = [];
		}
		
		// Load latest blog posts
		$data['latest_blogs'] = [];
		if (isset($this->Blog_model)) {
			try {
				$data['latest_blogs'] = $this->Blog_model->get_latest_posts(3);
			} catch (Exception $e) {
				$data['latest_blogs'] = [];
			}
		}
		
		// Load medical specialties (TNA CARE services)
		$data['medical_specialties'] = [];
		$data['featured_specialties'] = [];
		if ($this->db->table_exists('specialties')) {
			try {
				$this->load->model('Specialty_model');
				$data['medical_specialties'] = $this->Specialty_model->get_active(8);
				$data['featured_specialties'] = $this->Specialty_model->get_featured(4);
			} catch (Exception $e) {
				$data['medical_specialties'] = [];
				$data['featured_specialties'] = [];
			}
		}
		
		// Load medical expertises (Clinical expertise like Cardiology, Surgery, etc.)
		$data['medical_expertises'] = [];
		$data['featured_expertises'] = [];
		if ($this->db->table_exists('expertises')) {
			try {
				$this->load->model('Expertise_model');
				$data['medical_expertises'] = $this->Expertise_model->get_active(8);
				$data['featured_expertises'] = $this->Expertise_model->get_featured(6);
			} catch (Exception $e) {
				$data['medical_expertises'] = [];
				$data['featured_expertises'] = [];
			}
		}
		
		// Load partner hospitals - Tanzanian
		$data['tz_partners'] = [];
		if ($this->db->table_exists('partners')) {
			try {
				$this->load->model('Partner_model');
				$data['tz_partners'] = $this->Partner_model->get_by_type('tanzania', 4);
				$data['int_partners'] = $this->Partner_model->get_by_type('international', 4);
			} catch (Exception $e) {
				$data['tz_partners'] = [];
				$data['int_partners'] = [];
			}
		}
		
		// Load team members for leadership section
		$data['team_members'] = [];
		$data['featured_team_members'] = [];
		if ($this->db->table_exists('team_members')) {
			try {
				$this->load->model('Team_member_model');
				$active_template = get_active_template();
				$data['team_members'] = $this->Team_member_model->get_by_template($active_template, 8);
				$data['featured_team_members'] = $this->Team_member_model->get_featured(4);
			} catch (Exception $e) {
				$data['team_members'] = [];
				$data['featured_team_members'] = [];
			}
		}
		
		// Clear tourism-specific data
		$data['packages'] = [];
		$data['featured_packages'] = [];
		$data['featured_destinations'] = [];
		$data['featured_programs'] = [];
		$data['programs'] = [];
	}
	
	/**
	 * Helper to get setting with default value
	 */
	protected function get_setting($key, $default = '')
	{
		try {
			$setting = $this->Settings_model->get($key);
			return $setting ? $setting : $default;
		} catch (Exception $e) {
			return $default;
		}
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
