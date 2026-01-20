<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_youtube extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Youtube_videos_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');

        // Check if admin is logged in
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    /**
     * YouTube Videos dashboard - list all videos
     */
    public function index($page = 0)
    {
        $limit = 20;
        $total = $this->Youtube_videos_model->get_count_admin();

        // Pagination config
        $config['base_url'] = base_url('admin-youtube/index/');
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        // Get videos
        $offset = ($page - 1) * $limit;
        $data['videos'] = $this->Youtube_videos_model->get_all_admin($limit, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['total'] = $total;
        $data['page'] = 'admin_youtube_dashboard';

        $this->load->view('admin/header');
        $this->load->view('admin/youtube/dashboard', $data);
        $this->load->view('admin/footer');
    }

    /**
     * Create new YouTube video
     */
    public function create()
    {
        if ($this->input->method() == 'post') {
            // Form validation
            $this->form_validation->set_rules('title', 'Title', 'required|min_length[5]|max_length[255]');
            $this->form_validation->set_rules('youtube_url', 'YouTube URL', 'required|valid_url');
            $this->form_validation->set_rules('description', 'Description', 'max_length[2000]');
            $this->form_validation->set_rules('category', 'Category', 'max_length[100]');

            if ($this->form_validation->run() == FALSE) {
                $data['page'] = 'admin_youtube_create';
                $data['categories'] = $this->Youtube_videos_model->get_categories();
                $this->load->view('admin/header');
                $this->load->view('admin/youtube/create', $data);
                $this->load->view('admin/footer');
                return;
            }

            // Prepare data
            $video_data = [
                'title' => $this->input->post('title', TRUE),
                'youtube_url' => $this->input->post('youtube_url', TRUE),
                'description' => $this->input->post('description', TRUE),
                'category' => $this->input->post('category', TRUE),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
            ];

            // Create video
            if ($this->Youtube_videos_model->create($video_data)) {
                $this->session->set_flashdata('success', 'YouTube video added successfully!');
                redirect('admin-youtube');
            } else {
                $this->session->set_flashdata('error', 'Failed to add YouTube video!');
                redirect('admin-youtube/create');
            }
        }

        $data['page'] = 'admin_youtube_create';
        $data['categories'] = $this->Youtube_videos_model->get_categories();
        $this->load->view('admin/header');
        $this->load->view('admin/youtube/create', $data);
        $this->load->view('admin/footer');
    }

    /**
     * Edit YouTube video
     */
    public function edit($uid)
    {
        $video = $this->Youtube_videos_model->get_by_uid($uid);
        
        if (!$video) {
            $this->session->set_flashdata('error', 'Video not found!');
            redirect('admin-youtube');
        }

        if ($this->input->method() == 'post') {
            // Form validation
            $this->form_validation->set_rules('title', 'Title', 'required|min_length[5]|max_length[255]');
            $this->form_validation->set_rules('youtube_url', 'YouTube URL', 'required|valid_url');
            $this->form_validation->set_rules('description', 'Description', 'max_length[2000]');
            $this->form_validation->set_rules('category', 'Category', 'max_length[100]');

            if ($this->form_validation->run() == FALSE) {
                $data['video'] = $video;
                $data['page'] = 'admin_youtube_edit';
                $data['categories'] = $this->Youtube_videos_model->get_categories();
                $this->load->view('admin/header');
                $this->load->view('admin/youtube/edit', $data);
                $this->load->view('admin/footer');
                return;
            }

            // Prepare data
            $update_data = [
                'title' => $this->input->post('title', TRUE),
                'youtube_url' => $this->input->post('youtube_url', TRUE),
                'description' => $this->input->post('description', TRUE),
                'category' => $this->input->post('category', TRUE),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
            ];

            // Update video
            if ($this->Youtube_videos_model->update($uid, $update_data)) {
                $this->session->set_flashdata('success', 'YouTube video updated successfully!');
                redirect('admin-youtube');
            } else {
                $this->session->set_flashdata('error', 'Failed to update YouTube video!');
                redirect('admin-youtube/edit/' . $uid);
            }
        }

        $data['video'] = $video;
        $data['page'] = 'admin_youtube_edit';
        $data['categories'] = $this->Youtube_videos_model->get_categories();
        $this->load->view('admin/header');
        $this->load->view('admin/youtube/edit', $data);
        $this->load->view('admin/footer');
    }

    /**
     * Delete YouTube video
     */
    public function delete($uid)
    {
        $video = $this->Youtube_videos_model->get_by_uid($uid);
        
        if (!$video) {
            $this->session->set_flashdata('error', 'Video not found!');
            redirect('admin-youtube');
        }

        if ($this->Youtube_videos_model->delete($uid)) {
            $this->session->set_flashdata('success', 'YouTube video deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete YouTube video!');
        }

        redirect('admin-youtube');
    }

    /**
     * Toggle active status via AJAX
     */
    public function toggle_active($uid)
    {
        $video = $this->Youtube_videos_model->get_by_uid($uid);
        
        if (!$video) {
            return $this->output->set_content_type('application/json')->set_output(
                json_encode(['success' => false, 'message' => 'Video not found'])
            );
        }

        $new_status = !$video->is_active;
        $result = $this->Youtube_videos_model->toggle_active($uid, $new_status);

        return $this->output->set_content_type('application/json')->set_output(
            json_encode(['success' => $result ? true : false, 'is_active' => $new_status])
        );
    }

    /**
     * Toggle featured status via AJAX
     */
    public function toggle_featured($uid)
    {
        $video = $this->Youtube_videos_model->get_by_uid($uid);
        
        if (!$video) {
            return $this->output->set_content_type('application/json')->set_output(
                json_encode(['success' => false, 'message' => 'Video not found'])
            );
        }

        $new_status = !$video->is_featured;
        $result = $this->Youtube_videos_model->toggle_featured($uid, $new_status);

        return $this->output->set_content_type('application/json')->set_output(
            json_encode(['success' => $result ? true : false, 'is_featured' => $new_status])
        );
    }

    /**
     * Update display order via AJAX
     */
    public function update_order()
    {
        if ($this->input->method() != 'post') {
            return $this->output->set_content_type('application/json')->set_output(
                json_encode(['success' => false, 'message' => 'Invalid request'])
            );
        }

        $uid = $this->input->post('uid');
        $order = $this->input->post('order');

        if (!$uid || $order === null) {
            return $this->output->set_content_type('application/json')->set_output(
                json_encode(['success' => false, 'message' => 'Missing parameters'])
            );
        }

        $result = $this->Youtube_videos_model->update_order($uid, $order);

        return $this->output->set_content_type('application/json')->set_output(
            json_encode(['success' => $result ? true : false])
        );
    }
}
