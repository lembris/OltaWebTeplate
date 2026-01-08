<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends Admin_Controller 
{
    private $upload_path = './assets/img/pages/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Page_model');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['form', 'url', 'text']);
        
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Pages';
        $data['active_template'] = get_active_template();
        $data['pages'] = $this->Page_model->get_all_by_theme();
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/pages/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Create Page';
        $data['page'] = null;
        $data['templates'] = $this->Page_model->get_templates();
        $data['form_action'] = base_url('admin/pages/create');
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('content', 'Content', 'required');

            if ($this->form_validation->run() === TRUE) {
                $slug = $this->input->post('slug', TRUE);
                if (empty($slug)) {
                    $slug = $this->Page_model->generate_slug($this->input->post('title', TRUE));
                } else {
                    $slug = url_title($slug, '-', TRUE);
                    if ($this->Page_model->slug_exists($slug)) {
                        $slug = $slug . '-' . time();
                    }
                }

                $page_data = [
                    'title' => $this->input->post('title', TRUE),
                    'slug' => $slug,
                    'content' => $this->input->post('content'),
                    'excerpt' => $this->input->post('excerpt', TRUE),
                    'seo_title' => $this->input->post('seo_title', TRUE),
                    'seo_description' => $this->input->post('seo_description', TRUE),
                    'seo_keywords' => $this->input->post('seo_keywords', TRUE),
                    'template' => $this->input->post('template', TRUE) ?: 'default',
                    'status' => $this->input->post('status', TRUE) ?: 'draft',
                    'sort_order' => (int)$this->input->post('sort_order', TRUE),
                    'show_in_footer' => $this->input->post('show_in_footer') ? 1 : 0,
                    'show_in_header' => $this->input->post('show_in_header') ? 1 : 0,
                    'theme' => get_active_template()
                ];

                if (!empty($_FILES['featured_image']['name'])) {
                    $image = $this->upload_image('featured_image');
                    if ($image) {
                        $page_data['featured_image'] = $image;
                    }
                }

                $uid = $this->Page_model->create($page_data);
                if ($uid) {
                    $this->session->set_flashdata('success', 'Page created successfully.');
                    redirect('admin/pages');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create page.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/pages/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $page = $this->Page_model->get_by_uid($uid);
        if (!$page) {
            $this->session->set_flashdata('error', 'Page not found.');
            redirect('admin/pages');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Page';
        $data['page'] = $page;
        $data['templates'] = $this->Page_model->get_templates();
        $data['form_action'] = base_url('admin/pages/edit/' . $uid);
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_hash'] = $this->security->get_csrf_hash();

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('content', 'Content', 'required');

            if ($this->form_validation->run() === TRUE) {
                $slug = $this->input->post('slug', TRUE);
                if (empty($slug)) {
                    $slug = $this->Page_model->generate_slug($this->input->post('title', TRUE), $uid);
                } else {
                    $slug = url_title($slug, '-', TRUE);
                    if ($this->Page_model->slug_exists($slug, $uid)) {
                        $slug = $slug . '-' . time();
                    }
                }

                $page_data = [
                    'title' => $this->input->post('title', TRUE),
                    'slug' => $slug,
                    'content' => $this->input->post('content'),
                    'excerpt' => $this->input->post('excerpt', TRUE),
                    'seo_title' => $this->input->post('seo_title', TRUE),
                    'seo_description' => $this->input->post('seo_description', TRUE),
                    'seo_keywords' => $this->input->post('seo_keywords', TRUE),
                    'template' => $this->input->post('template', TRUE) ?: 'default',
                    'status' => $this->input->post('status', TRUE) ?: 'draft',
                    'sort_order' => (int)$this->input->post('sort_order', TRUE),
                    'show_in_footer' => $this->input->post('show_in_footer') ? 1 : 0,
                    'show_in_header' => $this->input->post('show_in_header') ? 1 : 0
                ];

                if (!empty($_FILES['featured_image']['name'])) {
                    $image = $this->upload_image('featured_image');
                    if ($image) {
                        if (!empty($page->featured_image) && file_exists($this->upload_path . $page->featured_image)) {
                            unlink($this->upload_path . $page->featured_image);
                        }
                        $page_data['featured_image'] = $image;
                    }
                }

                if ($this->Page_model->update_by_uid($uid, $page_data)) {
                    $this->session->set_flashdata('success', 'Page updated successfully.');
                    redirect('admin/pages');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update page.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/pages/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        $page = $this->Page_model->get_by_uid($uid);
        if (!$page) {
            $this->session->set_flashdata('error', 'Page not found.');
            redirect('admin/pages');
        }

        if (!empty($page->featured_image) && file_exists($this->upload_path . $page->featured_image)) {
            unlink($this->upload_path . $page->featured_image);
        }

        if ($this->Page_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Page deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete page.');
        }

        redirect('admin/pages');
    }

    public function toggle_status($uid)
    {
        $page = $this->Page_model->get_by_uid($uid);
        if (!$page) {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Page not found']);
                exit;
            }
            $this->session->set_flashdata('error', 'Page not found.');
            redirect('admin/pages');
        }

        $result = $this->Page_model->toggle_status($uid);
        $new_status = ($page->status === 'published') ? 'draft' : 'published';

        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $result,
                'status' => $new_status,
                'message' => $result ? 'Status updated successfully' : 'Failed to update status'
            ]);
            exit;
        }

        if ($result) {
            $this->session->set_flashdata('success', 'Page status updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update status.');
        }
        redirect('admin/pages');
    }

    private function upload_image($field_name)
    {
        $config = [
            'upload_path' => $this->upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size' => 2048,
            'encrypt_name' => TRUE
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        }

        $this->session->set_flashdata('warning', 'Image upload failed: ' . $this->upload->display_errors('', ''));
        return false;
    }
}
