<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programs extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Academic_program_model');
        $this->load->model('Department_model');
        $this->load->helper('template');
        $this->active_theme = get_active_template();
    }

    /**
     * List all academic programs
     */
    public function index()
    {
        $data = $this->get_common_data();
        $data['main_page'] = 'Programs';
        $data['current_page_name'] = 'Programs';
        
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        // Check if filtering by department code
        $dept_code = $this->input->get('department');
        $level = $this->input->get('level');
        
        if ($dept_code) {
            $department = $this->Department_model->get_by_code($dept_code);
            if ($department) {
                $data['programs'] = $this->Academic_program_model->get_by_department($department->id, $limit, $offset, $this->active_theme);
                $data['department'] = $department;
                $data['page_title'] = 'Programs - ' . $department->name;
                $data['current_page_name'] = $department->name . ' Programs';
            } else {
                $data['programs'] = [];
                $data['page_title'] = 'Department Not Found';
            }
        } elseif ($level) {
            // Filter by program level
            $data['programs'] = $this->Academic_program_model->get_by_level($level, $limit, $offset, $this->active_theme);
            $data['level'] = $level;
            $data['page_title'] = 'Programs - ' . ucfirst($level);
            $data['current_page_name'] = ucfirst($level) . ' Programs';
        } else {
            $data['programs'] = $this->Academic_program_model->get_active($limit, $offset, $this->active_theme);
            $data['total_programs'] = $this->Academic_program_model->count_all();
            $data['page_title'] = 'Academic Programs';
        }
        
        $data['departments'] = $this->Department_model->get_all();
        $data['meta_description'] = 'Explore our diverse range of academic programs and courses designed to prepare you for success.';
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('programs', $data);
        load_template_view('footer', $data);
    }

    /**
     * View single program by code or ID
     */
    public function view($code = null)
    {
        if (!$code) {
            show_404();
        }

        $data = $this->get_common_data();
        
        // Try to get by code first, then by ID
        $data['program'] = $this->Academic_program_model->get_by_code($code);
        if (!$data['program']) {
            $data['program'] = $this->Academic_program_model->get_by_id($code);
        }
        
        if (!$data['program']) {
            show_404();
        }

        $data['courses'] = $this->Academic_program_model->get_program_courses($data['program']->id);
        $data['related_programs'] = $this->Academic_program_model->get_related($data['program']->id, 3);
        
        $data['main_page'] = 'Programs';
        $data['current_page_name'] = $data['program']->name;
        $data['page_title'] = $data['program']->name;
        $data['meta_description'] = $data['program']->description ?? 'Learn more about our ' . $data['program']->name . ' program.';
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('program-detail', $data);
        load_template_view('footer', $data);
    }

    /**
     * Filter by department
     */
    public function by_department($dept_id = null)
    {
        if (!$dept_id) {
            show_404();
        }

        $data = $this->get_common_data();
        
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $department = $this->Department_model->get_by_id($dept_id);
        if (!$department) {
            show_404();
        }

        $data['programs'] = $this->Academic_program_model->get_by_department($dept_id, $limit, $offset, $this->active_theme);
        $data['department'] = $department;
        $data['departments'] = $this->Department_model->get_all();
        
        $data['main_page'] = 'Programs';
        $data['current_page_name'] = $department->name . ' Programs';
        $data['page_title'] = 'Programs - ' . $department->name;
        $data['meta_description'] = 'Browse programs in the ' . $department->name . ' department.';

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('programs', $data);
        load_template_view('footer', $data);
    }

    /**
     * Filter by level
     */
    public function by_level($level = null)
    {
        if (!$level) {
            show_404();
        }

        $data = $this->get_common_data();
        
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $data['programs'] = $this->Academic_program_model->get_by_level($level, $limit, $offset, $this->active_theme);
        $data['level'] = $level;
        $data['departments'] = $this->Department_model->get_all();
        
        $data['main_page'] = 'Programs';
        $data['current_page_name'] = ucfirst($level) . ' Programs';
        $data['page_title'] = 'Programs - ' . ucfirst($level);
        $data['meta_description'] = 'Browse our ' . strtolower($level) . ' level programs.';

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('programs', $data);
        load_template_view('footer', $data);
    }

    /**
     * Search programs
     */
    public function search()
    {
        $data = $this->get_common_data();
        
        $keyword = $this->input->get('q');
        
        if (!$keyword || strlen($keyword) < 2) {
            redirect('programs');
        }

        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $data['programs'] = $this->Academic_program_model->search($keyword, $limit, $offset, $this->active_theme);
        $data['keyword'] = $keyword;
        $data['departments'] = $this->Department_model->get_all();
        
        $data['main_page'] = 'Programs';
        $data['current_page_name'] = 'Search Results';
        $data['page_title'] = 'Program Search: ' . $keyword;
        $data['meta_description'] = 'Search results for "' . $keyword . '" in our academic programs.';

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('programs', $data);
        load_template_view('footer', $data);
    }
}
