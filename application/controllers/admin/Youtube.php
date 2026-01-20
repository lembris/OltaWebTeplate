<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Youtube extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Youtube_videos_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('text');
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'YouTube Videos';
        $data['active_template'] = get_active_template();
        $data['videos'] = $this->Youtube_videos_model->get_all_admin(50, 0);
        $data['categories'] = $this->Youtube_videos_model->get_categories();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/youtube/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add YouTube Video';
        $data['active_template'] = get_active_template();
        $data['video'] = null;
        $data['form_action'] = base_url('admin/youtube/create');
        $data['categories'] = $this->Youtube_videos_model->get_categories();
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('youtube_url', 'YouTube URL', 'required|trim|callback_validate_youtube_url');
            
            if ($this->form_validation->run() === TRUE) {
                $video_data = [
                    'title' => $this->input->post('title', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'youtube_url' => $this->input->post('youtube_url', TRUE),
                    'youtube_video_id' => $this->Youtube_videos_model->extract_video_id($this->input->post('youtube_url', TRUE)),
                    'category' => $this->input->post('category', TRUE),
                    'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                    'is_featured' => $this->input->post('is_featured', TRUE) ? 1 : 0,
                    'is_active' => $this->input->post('is_active', TRUE) ? 1 : 0,
                    'thumbnail_url' => 'https://img.youtube.com/vi/' . $this->Youtube_videos_model->extract_video_id($this->input->post('youtube_url', TRUE)) . '/hqdefault.jpg'
                ];
                
                if ($this->Youtube_videos_model->create($video_data)) {
                    $this->session->set_flashdata('success', 'YouTube video added successfully.');
                    redirect('admin/youtube');
                    return;
                } else {
                    $this->session->set_flashdata('error', 'Failed to add YouTube video.');
                }
            }
        }
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/youtube/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit YouTube Video';
        $data['active_template'] = get_active_template();
        $data['video'] = $this->Youtube_videos_model->get_by_uid($uid);
        $data['form_action'] = base_url('admin/youtube/edit/' . $uid);
        $data['categories'] = $this->Youtube_videos_model->get_categories();
        
        if (!$data['video']) {
            $this->session->set_flashdata('error', 'Video not found.');
            redirect('admin/youtube');
            return;
        }
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('youtube_url', 'YouTube URL', 'required|trim|callback_validate_youtube_url');
            
            if ($this->form_validation->run() === TRUE) {
                $video_id = $this->Youtube_videos_model->extract_video_id($this->input->post('youtube_url', TRUE));
                
                $video_data = [
                    'title' => $this->input->post('title', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'youtube_url' => $this->input->post('youtube_url', TRUE),
                    'youtube_video_id' => $video_id,
                    'category' => $this->input->post('category', TRUE),
                    'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                    'is_featured' => $this->input->post('is_featured', TRUE) ? 1 : 0,
                    'is_active' => $this->input->post('is_active', TRUE) ? 1 : 0,
                    'thumbnail_url' => 'https://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg'
                ];
                
                if ($this->Youtube_videos_model->update($uid, $video_data)) {
                    $this->session->set_flashdata('success', 'YouTube video updated successfully.');
                    redirect('admin/youtube');
                    return;
                } else {
                    $this->session->set_flashdata('error', 'Failed to update YouTube video.');
                }
            }
        }
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/youtube/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/youtube');
            return;
        }
        
        if ($this->Youtube_videos_model->delete($uid)) {
            $this->session->set_flashdata('success', 'YouTube video deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete YouTube video.');
        }
        redirect('admin/youtube');
    }

    public function toggle_featured($uid)
    {
        $video = $this->Youtube_videos_model->get_by_uid($uid);
        if (!$video) {
            $this->session->set_flashdata('error', 'Video not found.');
            redirect('admin/youtube');
            return;
        }
        
        $new_status = $video->is_featured ? 0 : 1;
        if ($this->Youtube_videos_model->toggle_featured($uid, $new_status)) {
            $this->session->set_flashdata('success', 'Featured status updated.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update featured status.');
        }
        redirect('admin/youtube');
    }

    public function toggle_active($uid)
    {
        $video = $this->Youtube_videos_model->get_by_uid($uid);
        if (!$video) {
            $this->session->set_flashdata('error', 'Video not found.');
            redirect('admin/youtube');
            return;
        }
        
        $new_status = $video->is_active ? 0 : 1;
        if ($this->Youtube_videos_model->toggle_active($uid, $new_status)) {
            $this->session->set_flashdata('success', 'Status updated.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update status.');
        }
        redirect('admin/youtube');
    }

    public function validate_youtube_url($url)
    {
        $video_id = $this->Youtube_videos_model->extract_video_id($url);
        if (!$video_id) {
            $this->form_validation->set_message('validate_youtube_url', 'Please enter a valid YouTube URL.');
            return FALSE;
        }
        return TRUE;
    }
}
