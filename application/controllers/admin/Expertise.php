<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expertise extends Admin_Controller 
{
    private $upload_path = './assets/img/expertises/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Expertise_model');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['form', 'url', 'text']);
        
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Medical Expertise';
        $data['active_template'] = get_active_template();
        $data['expertises'] = $this->Expertise_model->get_all(100, 0);
        $data['categories'] = $this->Expertise_model->get_default_categories();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/expertise/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Create Medical Expertise';
        $data['expertise'] = null;
        $data['categories'] = $this->Expertise_model->get_default_categories();
        $data['form_action'] = base_url('admin/expertise/create');

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim|max_length[255]');

            if ($this->form_validation->run() === TRUE) {
                $slug = $this->input->post('slug', TRUE);
                if (empty($slug)) {
                    $slug = $this->generate_slug($this->input->post('name', TRUE));
                }

                $features = $this->input->post('features', TRUE);
                if (is_string($features)) {
                    $features_array = array_filter(array_map('trim', explode("\n", $features)));
                    $features = json_encode($features_array);
                }

                $expertise_data = [
                    'name' => $this->input->post('name', TRUE),
                    'slug' => $slug,
                    'category' => $this->input->post('category', TRUE),
                    'short_description' => $this->input->post('short_description', TRUE),
                    'description' => $this->input->post('description'),
                    'icon' => $this->input->post('icon', TRUE),
                    'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'status' => $this->input->post('status') ? 'active' : 'inactive',
                    'features' => $features,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['image']['name'])) {
                    $image = $this->upload_image('image');
                    if ($image) {
                        $expertise_data['image'] = $image;
                    }
                }

                if ($this->Expertise_model->create($expertise_data)) {
                    $this->session->set_flashdata('message', 'Medical expertise created successfully!');
                    $this->session->set_flashdata('message_type', 'success');
                    redirect(base_url('admin/expertise'));
                    return;
                } else {
                    $this->session->set_flashdata('message', 'Error creating expertise!');
                    $this->session->set_flashdata('message_type', 'danger');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/expertise/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Medical Expertise';
        $data['expertise'] = $this->Expertise_model->get_by_uid($uid);
        $data['categories'] = $this->Expertise_model->get_default_categories();
        $data['form_action'] = base_url('admin/expertise/edit/' . $uid);

        if (!$data['expertise']) {
            $this->session->set_flashdata('message', 'Expertise not found!');
            $this->session->set_flashdata('message_type', 'danger');
            redirect(base_url('admin/expertise'));
            return;
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim|max_length[255]');

            if ($this->form_validation->run() === TRUE) {
                $slug = $this->input->post('slug', TRUE);
                if (empty($slug)) {
                    $slug = $this->generate_slug($this->input->post('name', TRUE));
                }

                $features = $this->input->post('features', TRUE);
                if (is_string($features)) {
                    $features_array = array_filter(array_map('trim', explode("\n", $features)));
                    $features = json_encode($features_array);
                }

                $expertise_data = [
                    'name' => $this->input->post('name', TRUE),
                    'slug' => $slug,
                    'category' => $this->input->post('category', TRUE),
                    'short_description' => $this->input->post('short_description', TRUE),
                    'description' => $this->input->post('description'),
                    'icon' => $this->input->post('icon', TRUE),
                    'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'status' => $this->input->post('status') ? 'active' : 'inactive',
                    'features' => $features,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['image']['name'])) {
                    $image = $this->upload_image('image');
                    if ($image) {
                        $expertise_data['image'] = $image;
                        if (!empty($data['expertise']->image) && file_exists($this->upload_path . $data['expertise']->image)) {
                            unlink($this->upload_path . $data['expertise']->image);
                        }
                    }
                }

                if ($this->Expertise_model->update_by_uid($uid, $expertise_data)) {
                    $this->session->set_flashdata('message', 'Medical expertise updated successfully!');
                    $this->session->set_flashdata('message_type', 'success');
                    redirect(base_url('admin/expertise'));
                    return;
                } else {
                    $this->session->set_flashdata('message', 'Error updating expertise!');
                    $this->session->set_flashdata('message_type', 'danger');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/expertise/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        $expertise = $this->Expertise_model->get_by_uid($uid);
        if ($expertise) {
            if (!empty($expertise->image) && file_exists($this->upload_path . $expertise->image)) {
                unlink($this->upload_path . $expertise->image);
            }
            $this->Expertise_model->delete_by_uid($uid);
            $this->session->set_flashdata('message', 'Medical expertise deleted successfully!');
            $this->session->set_flashdata('message_type', 'success');
        } else {
            $this->session->set_flashdata('message', 'Expertise not found!');
            $this->session->set_flashdata('message_type', 'danger');
        }
        redirect(base_url('admin/expertise'));
    }

    public function toggle_status($uid)
    {
        $expertise = $this->Expertise_model->get_by_uid($uid);
        if ($expertise) {
            $new_status = $expertise->status === 'active' ? 'inactive' : 'active';
            $this->Expertise_model->toggle_status_by_uid($uid, $new_status);
            $this->session->set_flashdata('message', 'Status updated successfully!');
            $this->session->set_flashdata('message_type', 'success');
        }
        redirect(base_url('admin/expertise'));
    }

    public function toggle_featured($uid)
    {
        $expertise = $this->Expertise_model->get_by_uid($uid);
        if ($expertise) {
            $new_featured = $expertise->is_featured ? 0 : 1;
            $this->Expertise_model->toggle_featured_by_uid($uid, $new_featured);
            $this->session->set_flashdata('message', 'Featured status updated!');
            $this->session->set_flashdata('message_type', 'success');
        }
        redirect(base_url('admin/expertise'));
    }

    private function generate_slug($name)
    {
        $slug = url_title($name, '-', TRUE);
        if ($this->Expertise_model->slug_exists($slug)) {
            $slug = $slug . '-' . time();
        }
        return $slug;
    }

    private function upload_image($field_name)
    {
        $config['upload_path'] = $this->upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048;
        $config['file_ext_tolower'] = TRUE;
        $config['file_name'] = time() . '_' . rand(1000, 9999);

        $this->upload->initialize($config);
        if ($this->upload->do_upload($field_name)) {
            return $this->upload->data('file_name');
        }
        return FALSE;
    }
}
