<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DirectoryController extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Directory_model');
        $this->load->model('Faculty_staff_model');
        $this->load->model('Department_model');
        $this->load->helper('template');
        $this->active_theme = get_active_template();
    }

    /**
     * Main directory listing
     */
    public function index()
    {
        $data = $this->get_common_data();
        $data['main_page'] = 'Directory';
        $data['current_page_name'] = 'Directory';
        
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $type = $this->input->get('type');
        
        if ($type) {
            $data['entries'] = $this->Directory_model->get_by_type($type, $limit, $offset);
            $data['type'] = $type;
            $total = $this->Directory_model->count_by_type($type);
            $data['page_title'] = 'Directory - ' . ucfirst($type);
            $data['current_page_name'] = ucfirst($type);
        } else {
            $data['entries'] = $this->Directory_model->get_active($limit, $offset);
            $total = $this->Directory_model->count_all_active();
            $data['page_title'] = 'Institute Directory';
        }

        $data['types'] = $this->Directory_model->get_types();
        $data['meta_description'] = 'Browse the Institute Directory to find faculty, staff, and department contacts.';
        
        // Load footer programs (college template)
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('directory', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * View single directory entry
     */
    public function view($uid = null)
    {
        if (!$uid) {
            show_404();
        }

        $data = $this->get_common_data();
        $data['entry'] = $this->Directory_model->get_by_uid($uid);
        
        if (!$data['entry']) {
            show_404();
        }

        $data['main_page'] = 'Directory';
        $data['current_page_name'] = $data['entry']->name;
        $data['page_title'] = $data['entry']->name;
        $data['meta_description'] = 'Contact information for ' . $data['entry']->name;
        
        // Load related faculty if this is a department entry
        $data['related_faculty'] = array();
        if ($data['entry']->type == 'department') {
            // Try to match directory entry name to department
            $department = $this->Department_model->get_by_name($data['entry']->name);
            if ($department) {
                // Get all active faculty for this department
                $data['related_faculty'] = $this->Faculty_staff_model->get_by_department($department->id);
            }
        }
        
        // Load footer programs (college template)
        $data['footer_programs'] = $this->get_footer_programs();
        
        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('directory-detail', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * Filter by type
     */
    public function by_type($type = null)
    {
        if (!$type) {
            show_404();
        }

        $data = $this->get_common_data();
        
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $data['entries'] = $this->Directory_model->get_by_type($type, $limit, $offset);
        $data['type'] = $type;
        $total = $this->Directory_model->count_by_type($type);
        $data['types'] = $this->Directory_model->get_types();
        
        $data['main_page'] = 'Directory';
        $data['current_page_name'] = ucfirst($type);
        $data['page_title'] = 'Directory - ' . ucfirst($type);
        $data['meta_description'] = 'Browse ' . strtolower($type) . ' contacts in the directory.';
        
        // Load footer programs (college template)
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('directory', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * Search directory
     */
    public function search()
    {
        $data = $this->get_common_data();
        
        $keyword = $this->input->get('q');
        
        if (!$keyword || strlen($keyword) < 2) {
            redirect('directory');
        }

        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $data['entries'] = $this->Directory_model->search($keyword, $limit, $offset);
        $data['keyword'] = $keyword;
        $data['types'] = $this->Directory_model->get_types();
        
        $data['main_page'] = 'Directory';
        $data['current_page_name'] = 'Search Results';
        $data['page_title'] = 'Directory Search: ' . $keyword;
        $data['meta_description'] = 'Search results for "' . $keyword . '" in the directory.';

        // Load footer programs (college template)
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('directory', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}
