<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonials extends Admin_Controller {

    private $upload_path = './assets/img/testimonials/';
    private $allowed_types = 'gif|jpg|jpeg|png|webp';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Testimonial_model');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['form', 'url', 'text']);

        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Testimonials';
        $data['active_template'] = get_active_template();
        $data['testimonials'] = $this->Testimonial_model->get_all_by_theme(100, 0);
        $data['rating_options'] = $this->Testimonial_model->get_rating_options();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/testimonials/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Create Testimonial';
        $data['active_template'] = get_active_template();
        $data['testimonial'] = null;
        $data['form_action'] = base_url('admin/testimonials/create');
        $data['rating_options'] = $this->Testimonial_model->get_rating_options();

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('content', 'Testimonial', 'required|trim|min_length[10]');
            $this->form_validation->set_rules('rating', 'Rating', 'required');

            if ($this->form_validation->run() === TRUE) {
                $testimonial_data = [
                    'name' => $this->input->post('name', TRUE),
                    'role' => $this->input->post('role', TRUE),
                    'company' => $this->input->post('company', TRUE),
                    'location' => $this->input->post('location', TRUE),
                    'content' => $this->input->post('content'),
                    'rating' => $this->input->post('rating', TRUE),
                    'theme' => get_active_template(),
                    'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                    'status' => $this->input->post('status') ? 'active' : 'inactive',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['image']['name'])) {
                    $image = $this->upload_image('image');
                    if ($image) {
                        $testimonial_data['image'] = $image;
                    }
                }

                if ($this->Testimonial_model->create($testimonial_data)) {
                    $this->session->set_flashdata('success', 'Testimonial created successfully.');
                    redirect('admin/testimonials');
                    return;
                } else {
                    $this->session->set_flashdata('error', 'Failed to create testimonial.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/testimonials/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Testimonial';
        $data['active_template'] = get_active_template();
        $data['testimonial'] = $this->Testimonial_model->get_by_uid($uid);
        $data['form_action'] = base_url('admin/testimonials/edit/' . $uid);
        $data['rating_options'] = $this->Testimonial_model->get_rating_options();

        if (!$data['testimonial']) {
            $this->session->set_flashdata('error', 'Testimonial not found.');
            redirect('admin/testimonials');
            return;
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('content', 'Testimonial', 'required|trim|min_length[10]');
            $this->form_validation->set_rules('rating', 'Rating', 'required');

            if ($this->form_validation->run() === TRUE) {
                $testimonial_data = [
                    'name' => $this->input->post('name', TRUE),
                    'role' => $this->input->post('role', TRUE),
                    'company' => $this->input->post('company', TRUE),
                    'location' => $this->input->post('location', TRUE),
                    'content' => $this->input->post('content'),
                    'rating' => $this->input->post('rating', TRUE),
                    'display_order' => $this->input->post('display_order', TRUE) ?: 0,
                    'status' => $this->input->post('status') ? 'active' : 'inactive',
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['image']['name'])) {
                    $image = $this->upload_image('image');
                    if ($image) {
                        $testimonial_data['image'] = $image;
                    }
                }

                if ($this->Testimonial_model->update_by_uid($uid, $testimonial_data)) {
                    $this->session->set_flashdata('success', 'Testimonial updated successfully.');
                    redirect('admin/testimonials');
                    return;
                } else {
                    $this->session->set_flashdata('error', 'Failed to update testimonial.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/testimonials/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/testimonials');
            return;
        }

        $testimonial = $this->Testimonial_model->get_by_uid($uid);
        
        if (!$testimonial) {
            $this->session->set_flashdata('error', 'Testimonial not found.');
            redirect('admin/testimonials');
            return;
        }

        if ($this->Testimonial_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Testimonial deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete testimonial.');
        }

        redirect('admin/testimonials');
    }

    public function toggle_status($uid)
    {
        $testimonial = $this->Testimonial_model->get_by_uid($uid);
        
        if (!$testimonial) {
            $this->session->set_flashdata('error', 'Testimonial not found.');
            redirect('admin/testimonials');
            return;
        }

        $new_status = $testimonial->status === 'active' ? 'inactive' : 'active';
        
        if ($this->Testimonial_model->toggle_status_by_uid($uid, $new_status)) {
            $this->session->set_flashdata('success', 'Status updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update status.');
        }

        redirect('admin/testimonials');
    }

    public function toggle_featured($uid)
    {
        $testimonial = $this->Testimonial_model->get_by_uid($uid);
        
        if (!$testimonial) {
            $this->session->set_flashdata('error', 'Testimonial not found.');
            redirect('admin/testimonials');
            return;
        }

        $new_featured = $testimonial->is_featured ? 0 : 1;
        
        if ($this->Testimonial_model->toggle_featured_by_uid($uid, $new_featured)) {
            $this->session->set_flashdata('success', 'Featured status updated.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update featured status.');
        }

        redirect('admin/testimonials');
    }

    private function upload_image($field_name)
    {
        $config['upload_path'] = $this->upload_path;
        $config['allowed_types'] = $this->allowed_types;
        $config['max_size'] = 2048;
        $config['file_ext_tolower'] = TRUE;
        $config['encrypt_name'] = TRUE;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload($field_name)) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            return FALSE;
        }

        return $this->upload->data('file_name');
    }
}
