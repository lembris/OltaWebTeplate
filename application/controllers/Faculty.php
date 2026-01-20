<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Faculty_staff_model');
        $this->load->model('Faculty_review_model');
        $this->load->model('Department_model');
        $this->load->helper('template');
    }

    /**
     * List all faculty and staff
     */
    public function index()
    {
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $data = $this->get_common_data();
        $data['faculty'] = $this->Faculty_staff_model->get_active($limit, $offset);
        
        // Load review stats for each faculty member
        foreach ($data['faculty'] as &$member) {
            $member->review_count = $this->Faculty_review_model->count_by_faculty($member->id, 'approved');
            $member->average_rating = $this->Faculty_review_model->get_average_rating($member->id);
        }
        
        $total = $this->Faculty_staff_model->count_all();
        $data['total_pages'] = ceil($total / $limit);
        $data['current_page'] = $page;
        $data['page_title'] = 'Faculty & Staff';
        $data['current_page_name'] = 'Faculty';
        $data['main_page'] = 'Faculty';
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('faculty', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * View single faculty member by slug
     */
    public function view($slug = null)
    {
        if (!$slug) {
            show_404();
        }

        $data = $this->get_common_data();
        $data['member'] = $this->Faculty_staff_model->get_by_slug($slug);
        
        if (!$data['member']) {
            show_404();
        }

        $data['page_title'] = $data['member']->first_name . ' ' . $data['member']->last_name;
        $data['current_page_name'] = 'Faculty';
        $data['main_page'] = 'Faculty';
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('faculty-detail', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * Filter by department
     */
    public function by_department($dept_id = null)
    {
        if (!$dept_id) {
            show_404();
        }

        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $department = $this->Department_model->get_by_id($dept_id);
        if (!$department) {
            show_404();
        }

        $data = $this->get_common_data();
        $data['faculty'] = $this->Faculty_staff_model->get_by_department($dept_id, $limit, $offset);
        
        // Load review stats for each faculty member
        foreach ($data['faculty'] as &$member) {
            $member->review_count = $this->Faculty_review_model->count_by_faculty($member->id, 'approved');
            $member->average_rating = $this->Faculty_review_model->get_average_rating($member->id);
        }
        
        $total = $this->Faculty_staff_model->count_by_department($dept_id);
        $data['department'] = $department;
        $data['total_pages'] = ceil($total / $limit);
        $data['current_page'] = $page;
        $data['page_title'] = 'Faculty - ' . $department->name;
        $data['current_page_name'] = 'Faculty';
        $data['main_page'] = 'Faculty';

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('faculty', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * Search faculty
     */
    public function search()
    {
        $keyword = $this->input->get('q');
        
        if (!$keyword || strlen($keyword) < 2) {
            redirect('faculty');
        }

        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $data = $this->get_common_data();
        $data['results'] = $this->Faculty_staff_model->search($keyword, $limit, $offset);
        $data['faculty'] = $data['results']; // For compatibility with view
        
        // Load review stats for each search result
        foreach ($data['faculty'] as &$member) {
            $member->review_count = $this->Faculty_review_model->count_by_faculty($member->id, 'approved');
            $member->average_rating = $this->Faculty_review_model->get_average_rating($member->id);
        }
        
        $total = $this->Faculty_staff_model->get_search_count($keyword);
        $data['keyword'] = $keyword;
        $data['total_pages'] = ceil($total / $limit);
        $data['current_page'] = $page;
        $data['page_title'] = 'Search Results for Faculty';
        $data['current_page_name'] = 'Faculty';
        $data['main_page'] = 'Faculty';

        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('faculty', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * Store a new review via AJAX
     */
    public function store_review()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            
            // Validation
            $this->form_validation->set_data($this->input->post());
            $this->form_validation->set_rules('faculty_id', 'Faculty', 'required|integer');
            $this->form_validation->set_rules('student_name', 'Name', 'required|min_length[3]|max_length[255]');
            $this->form_validation->set_rules('email', 'Email', 'valid_email');
            $this->form_validation->set_rules('rating', 'Rating', 'required|integer|greater_than[0]|less_than[6]');
            $this->form_validation->set_rules('review_title', 'Review Title', 'required|min_length[5]|max_length[255]');
            $this->form_validation->set_rules('review_text', 'Review Text', 'required|min_length[20]|max_length[5000]');
            
            if (!$this->form_validation->run()) {
                $this->output->set_content_type('application/json');
                echo json_encode([
                    'success' => false,
                    'errors' => $this->form_validation->error_array()
                ]);
                return;
            }
            
            // Check if faculty exists
            $faculty = $this->Faculty_staff_model->get_by_id($this->input->post('faculty_id'));
            if (!$faculty) {
                $this->output->set_content_type('application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Faculty member not found'
                ]);
                return;
            }
            
            // Check for duplicate reviews within 24 hours
            $email = $this->input->post('email');
            if ($email && $this->Faculty_review_model->has_recent_review($this->input->post('faculty_id'), $email, 24)) {
                $this->output->set_content_type('application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'You have already submitted a review for this faculty member. Please try again later.'
                ]);
                return;
            }
            
            // Prepare data
            $review_data = [
                'faculty_id' => $this->input->post('faculty_id'),
                'student_name' => $this->input->post('student_name'),
                'email' => $email,
                'rating' => $this->input->post('rating'),
                'review_title' => $this->input->post('review_title'),
                'review_text' => $this->input->post('review_text'),
                'theme' => get_active_template()
            ];
            
            // Insert review
            if ($this->Faculty_review_model->create($review_data)) {
                $this->output->set_content_type('application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Thank you for your review! It will be visible after approval.'
                ]);
            } else {
                $this->output->set_content_type('application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to submit review. Please try again.'
                ]);
            }
        } else {
            show_404();
        }
    }

    /**
     * Get reviews for a faculty member via AJAX
     */
    public function get_reviews($faculty_id = null)
    {
        try {
            if (!$this->input->is_ajax_request()) {
                show_404();
            }
            
            if (!$faculty_id) {
                $this->output->set_content_type('application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'No faculty ID provided'
                ]);
                return;
            }
            
            // Verify faculty exists
            $faculty = $this->Faculty_staff_model->get_by_id($faculty_id);
            if (!$faculty) {
                $this->output->set_content_type('application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Faculty not found'
                ]);
                return;
            }
            
            $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
            $limit = 5;
            $offset = ($page - 1) * $limit;
            
            $reviews = $this->Faculty_review_model->get_by_faculty($faculty_id, 'approved', $limit, $offset);
            $total = $this->Faculty_review_model->count_by_faculty($faculty_id, 'approved');
            $avg_rating = $this->Faculty_review_model->get_average_rating($faculty_id);
            
            // Convert reviews to associative array
            $reviews_array = [];
            foreach ($reviews as $review) {
                $reviews_array[] = (array)$review;
            }
            
            $this->output->set_content_type('application/json');
            echo json_encode([
                'success' => true,
                'reviews' => $reviews_array,
                'total' => $total,
                'average_rating' => $avg_rating,
                'total_pages' => $total > 0 ? ceil($total / $limit) : 1,
                'current_page' => $page
            ]);
        } catch (Exception $e) {
            $this->output->set_content_type('application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

}
