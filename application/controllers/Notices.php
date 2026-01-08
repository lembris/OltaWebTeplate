<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notices extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notice_model');
        $this->load->library('pagination');
    }

    /**
     * Notices listing page with pagination
     */
    public function index($page = 1)
    {
        $limit = 15;
        $page = max(1, (int)$page);
        $total = $this->Notice_model->get_published_count();

        // Pagination config
        $config['base_url'] = base_url('notices/page/');
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;

        // Bootstrap 5 pagination styling
        $config['attributes'] = ['class' => 'pagination'];
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $offset = max(0, ($page - 1) * $limit);
        $data['notices'] = $this->Notice_model->get_published($limit, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['total_notices'] = $total;
        $data['pinned_notices'] = $this->Notice_model->get_pinned(3);
        $data['categories'] = $this->Notice_model->get_categories();
        
        // Page meta
        $data['current_page_name'] = 'Notices';
        $data['main_page'] = 'Notices';
        $data['page_title'] = 'Notices & Announcements';
        $data['meta_description'] = 'Stay updated with the latest notices, announcements and important information.';
        
        // Merge common data
        $data = array_merge($this->get_common_data(), $data);
        
        // Load footer programs (college template)
        $data['footer_programs'] = $this->get_footer_programs();

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/sections/page-hero-unified', $data);
        $this->load->view('notices/notices-listing', $data);
        $this->load->view('includes/footer', $data);
    }

    /**
     * Single notice detail page
     */
    public function view($slug)
    {
        $data['notice'] = $this->Notice_model->get_by_slug($slug);

        if (!$data['notice']) {
            show_404();
        }

        // Increment views
        $this->Notice_model->increment_views($data['notice']->id);

        // Get related notices
        $data['latest_notices'] = $this->Notice_model->get_latest(5);
        $data['categories'] = $this->Notice_model->get_categories();
        
        // Page meta
        $data['current_page_name'] = $data['notice']->title;
        $data['main_page'] = 'Notices';
        $data['page_title'] = $data['notice']->title . ' | Notice';
        $data['meta_description'] = $data['notice']->excerpt ?: substr(strip_tags($data['notice']->content), 0, 160);
        
        // Merge common data
        $data = array_merge($this->get_common_data(), $data);
        
        // Load footer programs (college template)
        $data['footer_programs'] = $this->get_footer_programs();

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/sections/page-hero-unified', $data);
        $this->load->view('notices/notice-single', $data);
        $this->load->view('includes/footer', $data);
    }

    /**
     * Notices by category
     */
    public function category($category, $page = 1)
    {
        $limit = 15;
        $page = max(1, (int)$page);
        
        $notices = $this->Notice_model->get_by_category($category, $limit, max(0, ($page - 1) * $limit));
        
        if (empty($notices)) {
            show_404();
        }

        $data['notices'] = $notices;
        $data['category'] = $category;
        $data['categories'] = $this->Notice_model->get_categories();
        $data['pinned_notices'] = $this->Notice_model->get_pinned(3);
        
        // Page meta
        $category_name = ucfirst(str_replace('-', ' ', $category));
        $data['current_page_name'] = $category_name . ' Notices';
        $data['main_page'] = 'Notices';
        $data['page_title'] = $category_name . ' Notices';
        $data['meta_description'] = 'Browse ' . $category_name . ' notices and announcements.';
        
        // Merge common data
        $data = array_merge($this->get_common_data(), $data);
        
        // Load footer programs (college template)
        $data['footer_programs'] = $this->get_footer_programs();

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/sections/page-hero-unified', $data);
        $this->load->view('notices/notices-listing', $data);
        $this->load->view('includes/footer', $data);
    }

    /**
     * Download notice attachment
     */
    public function download($slug)
    {
        $notice = $this->Notice_model->get_by_slug($slug);
        
        if (!$notice || empty($notice->attachment)) {
            show_404();
        }

        $file_path = './assets/uploads/notices/' . $notice->attachment;
        
        if (!file_exists($file_path)) {
            show_404();
        }

        $this->load->helper('download');
        force_download($file_path, NULL);
    }

    /**
     * API endpoint: Get latest notices
     */
    public function api_latest()
    {
        $this->output->set_content_type('application/json');
        $notices = $this->Notice_model->get_latest(5);
        echo json_encode($notices);
    }

    /**
     * API endpoint: Get pinned notices
     */
    public function api_pinned()
    {
        $this->output->set_content_type('application/json');
        $notices = $this->Notice_model->get_pinned(5);
        echo json_encode($notices);
    }
}
