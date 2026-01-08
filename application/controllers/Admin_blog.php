<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_blog extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');

        // Check if admin is logged in (adjust this based on your auth system)
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    /**
     * Blog dashboard - list all posts
     */
    public function index($page = 0)
    {
        $limit = 20;
        $total = $this->Blog_model->get_all_count();

        // Pagination config
        $config['base_url'] = base_url('admin-blog/index/');
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        // Get posts
        $offset = ($page - 1) * $limit;
        $data['posts'] = $this->Blog_model->get_all_posts($limit, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['total'] = $total;
        $data['page'] = 'admin_blog_dashboard';

        $this->load->view('admin/header');
        $this->load->view('admin/blog/dashboard', $data);
        $this->load->view('admin/footer');
    }

    /**
     * Create new blog post
     */
    public function create()
    {
        if ($this->input->method() == 'post') {
            // Form validation
            $this->form_validation->set_rules('title', 'Title', 'required|min_length[5]|max_length[255]');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('content', 'Content', 'required|min_length[50]');
            $this->form_validation->set_rules('excerpt', 'Excerpt', 'max_length[500]');
            $this->form_validation->set_rules('seo_title', 'SEO Title', 'max_length[255]');
            $this->form_validation->set_rules('seo_description', 'SEO Description', 'max_length[255]');

            if ($this->form_validation->run() == FALSE) {
                $data['page'] = 'admin_blog_create';
                $this->load->view('admin/header');
                $this->load->view('admin/blog/create', $data);
                $this->load->view('admin/footer');
                return;
            }

            // Prepare data
            $post_data = [
                'title' => $this->input->post('title', TRUE),
                'category' => $this->input->post('category', TRUE),
                'content' => $this->input->post('content'),
                'excerpt' => $this->input->post('excerpt', TRUE),
                'author' => $this->input->post('author', TRUE) ?: 'Osiram Safari',
                'seo_title' => $this->input->post('seo_title', TRUE),
                'seo_description' => $this->input->post('seo_description', TRUE),
                'published' => $this->input->post('published') ? 1 : 0,
            ];

            // Handle featured image upload
            if (!empty($_FILES['featured_image']['name'])) {
                $upload_result = $this->upload_image('featured_image');
                if ($upload_result['status']) {
                    $post_data['featured_image'] = $upload_result['file'];
                } else {
                    $this->session->set_flashdata('error', $upload_result['message']);
                    redirect('admin-blog/create');
                }
            }

            // Create post
            if ($this->Blog_model->create_post($post_data)) {
                $this->session->set_flashdata('success', 'Blog post created successfully!');
                redirect('admin-blog');
            } else {
                $this->session->set_flashdata('error', 'Failed to create blog post!');
                redirect('admin-blog/create');
            }
        }

        $data['page'] = 'admin_blog_create';
        $this->load->view('admin/header');
        $this->load->view('admin/blog/create', $data);
        $this->load->view('admin/footer');
    }

    /**
     * Edit blog post
     */
    public function edit($id)
    {
        $post = $this->Blog_model->get_by_id($id);

        if (!$post) {
            show_404();
        }

        if ($this->input->method() == 'post') {
            // Form validation
            $this->form_validation->set_rules('title', 'Title', 'required|min_length[5]|max_length[255]');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('content', 'Content', 'required|min_length[50]');
            $this->form_validation->set_rules('excerpt', 'Excerpt', 'max_length[500]');
            $this->form_validation->set_rules('seo_title', 'SEO Title', 'max_length[255]');
            $this->form_validation->set_rules('seo_description', 'SEO Description', 'max_length[255]');

            if ($this->form_validation->run() == FALSE) {
                $data['post'] = $post;
                $data['page'] = 'admin_blog_edit';
                $this->load->view('admin/header');
                $this->load->view('admin/blog/edit', $data);
                $this->load->view('admin/footer');
                return;
            }

            // Prepare data
            $post_data = [
                'title' => $this->input->post('title', TRUE),
                'category' => $this->input->post('category', TRUE),
                'content' => $this->input->post('content'),
                'excerpt' => $this->input->post('excerpt', TRUE),
                'author' => $this->input->post('author', TRUE) ?: 'Osiram Safari',
                'seo_title' => $this->input->post('seo_title', TRUE),
                'seo_description' => $this->input->post('seo_description', TRUE),
                'published' => $this->input->post('published') ? 1 : 0,
            ];

            // Handle featured image upload
            if (!empty($_FILES['featured_image']['name'])) {
                $upload_result = $this->upload_image('featured_image');
                if ($upload_result['status']) {
                    // Delete old image if exists
                    if (!empty($post->featured_image)) {
                        $old_file = FCPATH . 'assets/img/blog/' . $post->featured_image;
                        if (file_exists($old_file)) {
                            unlink($old_file);
                        }
                    }
                    $post_data['featured_image'] = $upload_result['file'];
                } else {
                    $this->session->set_flashdata('error', $upload_result['message']);
                    redirect('admin-blog/edit/' . $id);
                }
            }

            // Update post
            if ($this->Blog_model->update_post($id, $post_data)) {
                $this->session->set_flashdata('success', 'Blog post updated successfully!');
                redirect('admin-blog');
            } else {
                $this->session->set_flashdata('error', 'Failed to update blog post!');
                redirect('admin-blog/edit/' . $id);
            }
        }

        $data['post'] = $post;
        $data['page'] = 'admin_blog_edit';
        $this->load->view('admin/header');
        $this->load->view('admin/blog/edit', $data);
        $this->load->view('admin/footer');
    }

    /**
     * Delete blog post
     */
    public function delete($id)
    {
        $post = $this->Blog_model->get_by_id($id);

        if (!$post) {
            show_404();
        }

        // Delete featured image if exists
        if (!empty($post->featured_image)) {
            $file_path = FCPATH . 'assets/img/blog/' . $post->featured_image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        // Delete post
        if ($this->Blog_model->delete_post($id)) {
            $this->session->set_flashdata('success', 'Blog post deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete blog post!');
        }

        redirect('admin-blog');
    }

    /**
     * Toggle publish status
     */
    public function toggle_publish($id)
    {
        $post = $this->Blog_model->get_by_id($id);

        if (!$post) {
            show_404();
        }

        $new_status = $post->published ? 0 : 1;

        if ($this->Blog_model->toggle_publish($id, $new_status)) {
            $status_text = $new_status ? 'published' : 'unpublished';
            $this->session->set_flashdata('success', 'Post ' . $status_text . '!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update post status!');
        }

        redirect('admin-blog');
    }

    /**
     * Upload image
     */
    private function upload_image($field_name)
    {
        $config['upload_path'] = FCPATH . 'assets/img/blog/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
        $config['max_size'] = 5120; // 5MB
        $config['file_name'] = 'blog_' . time() . '_' . random_string('alnum', 8);

        // Create directory if not exists
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($field_name)) {
            return [
                'status' => TRUE,
                'file' => $this->upload->data('file_name')
            ];
        } else {
            return [
                'status' => FALSE,
                'message' => $this->upload->display_errors()
            ];
        }
    }
}
