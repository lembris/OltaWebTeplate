<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcements extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Announcement_model');
    }

    /**
     * Announcements listing page
     */
    public function index()
    {
        $data['announcements'] = $this->Announcement_model->get_active(20, 0);
        
        // Page meta
        $data['current_page_name'] = 'Announcements';
        $data['main_page'] = 'Announcements';
        $data['page_title'] = 'Announcements';
        $data['meta_description'] = 'View all current announcements and updates.';
        
        // Merge common data
        $data = array_merge($this->get_common_data(), $data);

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/sections/page-hero-unified', $data);
        $this->load->view('announcements/announcements-listing', $data);
        $this->load->view('includes/footer', $data);
    }

    /**
     * Single announcement detail page
     */
    public function view($slug)
    {
        $data['announcement'] = $this->Announcement_model->get_by_slug($slug);

        if (!$data['announcement']) {
            show_404();
        }

        // Increment views
        $this->Announcement_model->increment_views($data['announcement']->id);

        // Get other announcements
        $data['other_announcements'] = $this->Announcement_model->get_active(5, 0);
        
        // Page meta
        $data['current_page_name'] = $data['announcement']->title;
        $data['main_page'] = 'Announcements';
        $data['page_title'] = $data['announcement']->title . ' | Announcement';
        $data['meta_description'] = $data['announcement']->excerpt ?: substr(strip_tags($data['announcement']->content), 0, 160);
        
        // Merge common data
        $data = array_merge($this->get_common_data(), $data);

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/sections/page-hero-unified', $data);
        $this->load->view('announcements/announcement-single', $data);
        $this->load->view('includes/footer', $data);
    }

    /**
     * Track announcement click
     */
    public function track_click($slug)
    {
        $announcement = $this->Announcement_model->get_by_slug($slug);
        
        if ($announcement) {
            $this->Announcement_model->increment_clicks($announcement->id);
            
            if (!empty($announcement->link_url)) {
                redirect($announcement->link_url);
            }
        }
        
        redirect('announcements');
    }

    /**
     * API endpoint: Get homepage announcements
     */
    public function api_homepage()
    {
        $this->output->set_content_type('application/json');
        $announcements = $this->Announcement_model->get_homepage_announcements(5);
        echo json_encode($announcements);
    }

    /**
     * API endpoint: Get header announcements
     */
    public function api_header()
    {
        $this->output->set_content_type('application/json');
        $announcements = $this->Announcement_model->get_header_announcements(3);
        echo json_encode($announcements);
    }

    /**
     * API endpoint: Get popup announcements
     */
    public function api_popup()
    {
        $this->output->set_content_type('application/json');
        $announcements = $this->Announcement_model->get_popup_announcements(1);
        echo json_encode($announcements);
    }
}
