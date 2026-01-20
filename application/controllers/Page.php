<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Page_model');
        $this->load->helper('template');
    }

    /**
     * Display single page by slug
     */
    public function view($slug)
    {
        // Get page by slug
        $page = $this->Page_model->get_by_slug($slug);

        // Check if page exists and is published
        if (!$page) {
            show_404();
            return;
        }

        if ($page->status !== 'published') {
            show_404();
            return;
        }

        // Prepare data
        $data['page'] = $page;
        $data['page_title'] = $page->seo_title ?: $page->title;
        $data['meta_description'] = $page->seo_description ?: $page->excerpt;
        $data['meta_keywords'] = $page->seo_keywords ?: '';
        $data['current_page_name'] = $page->title;
        $data['main_page'] = $page->title;
        $data['all_pages'] = $this->Page_model->get_published();

        // Merge common data
        $data = array_merge($this->get_common_data(), $data);
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        // Load views
        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('sections/page-hero', $data);
        load_template_page('page-view', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}
