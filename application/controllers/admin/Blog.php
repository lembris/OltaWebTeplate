<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Admin_Controller 
{
    private $upload_path = './assets/img/blog/';
    private $default_categories = [
        'Safari Tips' => 'Safari Tips',
        'Wildlife' => 'Wildlife',
        'Destinations' => 'Destinations',
        'Travel Guide' => 'Travel Guide',
        'Adventure' => 'Adventure',
        'Culture' => 'Culture',
        'Campus News' => 'Campus News',
        'Academic' => 'Academic',
        'Events' => 'Events'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->model('Category_model');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['form', 'url', 'text']);
        
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }
    
    /**
     * Get categories - from DB if available, otherwise use defaults
     */
    private function get_categories()
    {
        if ($this->Category_model->table_exists()) {
            $db_categories = $this->Category_model->get_dropdown('blog');
            if (!empty($db_categories)) {
                return $db_categories;
            }
        }
        return $this->default_categories;
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Blog Posts';
        $data['active_template'] = get_active_template();
        $data['posts'] = $this->Blog_model->get_all_posts_by_theme(100, 0);
        $data['categories'] = $this->get_categories();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/blog/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Create Blog Post';
        $data['categories'] = $this->get_categories();
        $data['post'] = null;
        $data['form_action'] = base_url('admin/blog/create');

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('content', 'Content', 'required');

            if ($this->form_validation->run() === TRUE) {
                $slug = $this->input->post('slug', TRUE);
                if (empty($slug)) {
                    $slug = $this->generate_slug($this->input->post('title', TRUE));
                }

                $post_data = [
                    'title' => $this->input->post('title', TRUE),
                    'slug' => $slug,
                    'category' => $this->input->post('category', TRUE),
                    'theme' => get_active_template(),
                    'content' => $this->input->post('content'),
                    'excerpt' => $this->input->post('excerpt', TRUE),
                    'author' => $this->input->post('author', TRUE),
                    'seo_title' => $this->input->post('seo_title', TRUE),
                    'seo_description' => $this->input->post('seo_description', TRUE),
                    'published' => $this->input->post('published') ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['featured_image']['name'])) {
                    $image = $this->upload_image('featured_image');
                    if ($image) {
                        $post_data['featured_image'] = $image;
                    }
                }

                if ($this->Blog_model->create_post($post_data)) {
                    $this->session->set_flashdata('success', 'Blog post created successfully.');
                    redirect('admin/blog');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create blog post.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/blog/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $post = $this->Blog_model->get_by_uid($uid);
        if (!$post) {
            $this->session->set_flashdata('error', 'Blog post not found.');
            redirect('admin/blog');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Blog Post';
        $data['categories'] = $this->get_categories();
        $data['post'] = $post;
        $data['form_action'] = base_url('admin/blog/edit/' . $uid);

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('content', 'Content', 'required');

            if ($this->form_validation->run() === TRUE) {
                $slug = $this->input->post('slug', TRUE);
                if (empty($slug)) {
                    $slug = $this->generate_slug($this->input->post('title', TRUE), $post->id);
                }

                $post_data = [
                    'title' => $this->input->post('title', TRUE),
                    'slug' => $slug,
                    'category' => $this->input->post('category', TRUE),
                    'content' => $this->input->post('content'),
                    'excerpt' => $this->input->post('excerpt', TRUE),
                    'author' => $this->input->post('author', TRUE),
                    'seo_title' => $this->input->post('seo_title', TRUE),
                    'seo_description' => $this->input->post('seo_description', TRUE),
                    'published' => $this->input->post('published') ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['featured_image']['name'])) {
                    $image = $this->upload_image('featured_image');
                    if ($image) {
                        if (!empty($post->featured_image) && file_exists($this->upload_path . $post->featured_image)) {
                            @unlink($this->upload_path . $post->featured_image);
                        }
                        $post_data['featured_image'] = $image;
                    }
                }

                log_message('debug', 'Updating blog post UID: ' . $uid . ' with data: ' . json_encode($post_data));

                if ($this->Blog_model->update_post_by_uid($uid, $post_data)) {
                    $this->session->set_flashdata('success', 'Blog post updated successfully.');
                    redirect('admin/blog');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update blog post.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/blog/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        $post = $this->Blog_model->get_by_uid($uid);
        if (!$post) {
            $this->session->set_flashdata('error', 'Blog post not found.');
            redirect('admin/blog');
        }

        if ($this->Blog_model->delete_post_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Blog post deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete blog post.');
        }

        redirect('admin/blog');
    }

    public function toggle_publish($uid)
    {
        $post = $this->Blog_model->get_by_uid($uid);
        if (!$post) {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Post not found']);
                exit;
            }
            $this->session->set_flashdata('error', 'Post not found.');
            redirect('admin/blog');
        }

        $new_status = $post->published ? 0 : 1;
        $result = $this->Blog_model->toggle_publish_by_uid($uid, $new_status);

        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $result,
                'published' => $new_status,
                'message' => $result ? 'Status updated successfully' : 'Failed to update status'
            ]);
            exit;
        }

        if ($result) {
            $this->session->set_flashdata('success', 'Post status updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update status.');
        }
        redirect('admin/blog');
    }

    private function upload_image($field_name)
    {
        $config = [
            'upload_path' => $this->upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size' => 5120,
            'encrypt_name' => TRUE
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        }

        $error_msg = $this->upload->display_errors('', '');
        log_message('error', 'Blog image upload failed: ' . $error_msg);
        $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
        return false;
    }

    private function generate_slug($title, $exclude_id = null)
    {
        $slug = url_title($title, '-', TRUE);
        
        if ($this->Blog_model->slug_exists($slug, $exclude_id)) {
            $slug = $slug . '-' . time();
        }
        
        return $slug;
    }
}
