<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
    }
}

/**
 * Frontend Controller
 * Base controller for all frontend pages
 * Automatically loads site settings from database
 */
class Frontend_Controller extends CI_Controller 
{
    protected $site_settings = [];
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Settings_model');
        $this->load->helper('url');
        $this->load_site_settings();
        $this->track_visitor();
    }
    
    /**
     * Track visitor for analytics
     */
    protected function track_visitor()
    {
        // Don't track AJAX requests or admin pages
        if ($this->input->is_ajax_request()) {
            return;
        }
        
        try {
            $this->load->model('Visitor_model');
            
            $ua = $this->input->user_agent();
            $ip = $this->input->ip_address();
            $parsed = Visitor_model::parse_user_agent($ua);
            
            // Get geolocation (country/city) from IP
            $geo = Visitor_model::get_geolocation($ip);
            
            // Skip bots optionally (or log them with is_bot=1)
            $data = [
                'ip_address' => $ip,
                'user_agent' => substr($ua, 0, 500),
                'page_url' => current_url(),
                'page_title' => '', // Will be set by individual controllers
                'referrer' => isset($_SERVER['HTTP_REFERER']) ? substr($_SERVER['HTTP_REFERER'], 0, 500) : null,
                'country' => $geo['country'],
                'city' => $geo['city'],
                'device_type' => $parsed['device_type'],
                'browser' => $parsed['browser'],
                'os' => $parsed['os'],
                'session_id' => session_id(),
                'is_bot' => $parsed['is_bot'],
                'visited_at' => date('Y-m-d H:i:s')
            ];
            
            $this->Visitor_model->log_visit($data);
        } catch (Exception $e) {
            // Silently fail - don't break the page if tracking fails
            log_message('error', 'Visitor tracking failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Load all site settings from database
     * Loads template-specific settings if a template is active
     */
    protected function load_site_settings()
    {
        // Get active template
        $this->load->helper('template');
        $active_template = get_active_template();
        
        // Load settings with template overrides
        $settings = $this->Settings_model->get_all($active_template);
        $this->site_settings = $settings;
    }
    
    /**
     * Get common data for all frontend pages
     * Maps database settings to view variables
     */
    protected function get_common_data()
    {
        $s = $this->site_settings;
        
        // Load navigation destinations
        $nav_destinations = $this->get_nav_destinations();
        
        // Load footer pages
        $footer_pages = $this->get_footer_pages();
        
        return [
            // Page navigation variables (controllers should override these)
            'current_page_name' => '',
            'main_page' => '',
            // Navigation Destinations (dynamic)
            'nav_destinations' => $nav_destinations,
            // Footer Pages (dynamic)
            'footer_pages' => $footer_pages,
            // General Settings
            'site_name' => $s['site_name'] ?? 'Osiram Safari Adventure',
            'site_tag' => $s['site_tagline'] ?? 'Tour Operators',
            'site_name_abb' => $this->get_abbreviation($s['site_name'] ?? 'Osiram Safari Adventure'),
            
            // Contact Settings (fixed key mappings to match database)
            'phone_number' => $s['site_phone'] ?? '',
            'secondary_phone' => $s['site_phone_secondary'] ?? '',
            'consult_number_call' => $s['whatsapp_number'] ?? $s['site_whatsapp'] ?? '',
            'work_hours' => '9:00AM - 8:00PM',
            'physical_address' => $s['site_address'] ?? '',
            'email_address' => $s['site_email'] ?? '',
            'site_email' => $s['site_email'] ?? '',
            'google_maps_embed' => $s['map_embed_code'] ?? '',
            
            // Social Links
            'facebook' => $s['facebook_url'] ?? '',
            'instagram' => $s['instagram_url'] ?? '',
            'twitter' => $s['twitter_url'] ?? '',
            'youtube' => $s['youtube_url'] ?? '',
            'linkedin' => $s['linkedin_url'] ?? '',
            'tripadvisor' => $s['tripadvisor_url'] ?? '',
            'pinterest' => $s['pinterest_url'] ?? '',
            
            // Email Settings
            'admin_email' => $s['admin_email'] ?? '',
            'booking_email' => $s['booking_email'] ?? '',
            'enquiry_email' => $s['enquiry_email'] ?? '',
            
            // Branding (fix paths - prepend assets/images/ if not already prefixed)
            'site_logo' => !empty($s['site_logo']) 
                ? (strpos($s['site_logo'], 'assets/') === 0 ? $s['site_logo'] : 'assets/images/' . $s['site_logo']) 
                : '',
            'site_favicon' => !empty($s['site_favicon']) 
                ? (strpos($s['site_favicon'], 'assets/') === 0 ? $s['site_favicon'] : 'assets/images/' . $s['site_favicon']) 
                : '',
            
            // Currency
            'currency' => $s['currency'] ?? 'USD',
            'currency_symbol' => $s['currency_symbol'] ?? '$',
            
            // Theme/Branding Colors
            'theme_primary' => $s['theme_primary'] ?? '#5c6bc0',
            'theme_secondary' => $s['theme_secondary'] ?? '#3f51b5',
            'theme_accent' => $s['theme_accent'] ?? '#ff6b6b',
            'footer_bg_color' => $s['footer_bg_color'] ?? '#f4f4f4',
            'footer_text_color' => $s['footer_text_color'] ?? '#333',
            'footer_link_color' => $s['footer_link_color'] ?? '#5c6bc0',
            'footer_heading_color' => $s['footer_heading_color'] ?? '#333',
            
            // SEO/Analytics
            'google_analytics_id' => $s['google_analytics_id'] ?? '',
            'google_tag_manager_id' => $s['google_tag_manager_id'] ?? '',
            
            // All settings for advanced use
            'settings' => $this->site_settings
        ];
    }
    
    /**
     * Generate abbreviation from site name
     */
    private function get_abbreviation($name)
    {
        $words = explode(' ', $name);
        $abbr = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $abbr .= strtoupper($word[0]);
            }
        }
        return $abbr ?: 'OSA';
    }
    
    /**
     * Get a specific setting value
     */
    protected function get_setting($key, $default = '')
    {
        return $this->site_settings[$key] ?? $default;
    }
    
    /**
     * Get destinations for navigation menu
     */
    protected function get_nav_destinations()
    {
        // Load Destination_model if not loaded
        if (!isset($this->Destination_model)) {
            $this->load->model('Destination_model');
        }
        
        try {
            $destinations = $this->Destination_model->get_nav_destinations(6);
            return $destinations;
        } catch (Exception $e) {
            // Return empty array if table doesn't exist yet
            return [];
        }
    }
    
    /**
     * Get pages for footer
     */
    protected function get_footer_pages()
    {
        // Load Page_model if not loaded
        if (!isset($this->Page_model)) {
            $this->load->model('Page_model');
        }
        
        try {
            $pages = $this->Page_model->get_footer_pages();
            return $pages;
        } catch (Exception $e) {
            // Return empty array if table doesn't exist yet
            return [];
        }
    }
    
    /**
     * Get programs for footer (college template only)
     */
    protected function get_footer_programs()
    {
        $this->load->helper('template');
        $active_template = get_active_template();
        
        // Only load for college template
        if ($active_template !== 'college') {
            return [];
        }
        
        // Load Academic_program_model if not loaded
        if (!isset($this->Academic_program_model)) {
            $this->load->model('Academic_program_model');
        }
        
        try {
            $programs = $this->Academic_program_model->get_active(6);
            return $programs;
        } catch (Exception $e) {
            // Return empty array if error
            return [];
        }
    }
    
    /**
     * Get color code for event type (for dynamic styling)
     */
    protected function get_event_color($event_type = 'default')
    {
        $colors = [
            'workshop' => '#3498db',
            'academic' => '#e74c3c',
            'conference' => '#f39c12',
            'cultural' => '#9b59b6',
            'sports' => '#27ae60',
            'seminar' => '#2980b9',
            'webinar' => '#16a085',
            'guest_lecture' => '#8e44ad',
            'competition' => '#c0392b',
            'default' => '#34495e'
        ];
        
        $type = strtolower(str_replace(' ', '_', $event_type));
        return $colors[$type] ?? $colors['default'];
    }
}

    class Admin_Controller extends CI_Controller
    {
        protected $admin_user;

        public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->helper('menu');  // Load menu helper for get_admin_menu() and render_admin_menu()
            $this->check_authentication();
            $this->load_admin_data();
        }

    protected function check_authentication()
    {
        if (!$this->session->userdata('admin_logged_in')) {
            $this->session->set_userdata('redirect_after_login', current_url());
            $this->session->set_flashdata('error', 'Please login to access the admin area.');
            redirect('admin/auth/login');
        }
    }

    protected function load_admin_data()
    {
        $this->load->model('Admin_model');
        $admin_id = $this->session->userdata('admin_id');
        $this->admin_user = $this->Admin_model->get_admin($admin_id);

        if (!$this->admin_user || $this->admin_user->status !== 'active') {
            $this->session->sess_destroy();
            redirect('admin/auth/login');
        }
    }

    protected function check_role($allowed_roles = [])
    {
        if (!empty($allowed_roles)) {
            $current_role = $this->session->userdata('admin_role');
            if (!in_array($current_role, $allowed_roles)) {
                $this->session->set_flashdata('error', 'You do not have permission to access this area.');
                redirect('admin/dashboard');
            }
        }
    }

    protected function is_super_admin()
    {
        return $this->session->userdata('admin_role') === 'super_admin';
    }

    protected function is_admin()
    {
        return in_array($this->session->userdata('admin_role'), ['super_admin', 'admin']);
    }

    protected function get_admin_data()
    {
        return [
            'admin_user' => $this->admin_user,
            'admin_id' => $this->session->userdata('admin_id'),
            'admin_name' => $this->session->userdata('admin_name'),
            'admin_role' => $this->session->userdata('admin_role'),
            'admin_email' => $this->session->userdata('admin_email'),
            'admin_avatar' => $this->session->userdata('admin_avatar')
        ];
    }
}
