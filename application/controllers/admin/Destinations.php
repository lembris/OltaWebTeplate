<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destinations extends Admin_Controller 
{
    private $upload_path = './assets/img/destinations/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Destination_model');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['form', 'url', 'text']);
        
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    /**
     * List all destinations
     */
    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Destinations';
        
        // Search functionality
        $keyword = $this->input->get('search');
        if (!empty($keyword)) {
            $data['destinations'] = $this->Destination_model->search($keyword);
            $data['search_keyword'] = $keyword;
        } else {
            $data['destinations'] = $this->Destination_model->get_all(100);
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/destinations/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Create new destination
     */
    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add New Destination';
        $data['destination'] = null;
        $data['form_action'] = base_url('admin/destinations/create');

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Destination Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('country', 'Country', 'required|trim');
            $this->form_validation->set_rules('description', 'Description', 'required');

            if ($this->form_validation->run() === TRUE) {
                // Check if name already exists
                if ($this->Destination_model->name_exists($this->input->post('name'))) {
                    $this->session->set_flashdata('error', 'Destination name already exists.');
                    redirect('admin/destinations/create');
                    return;
                }

                $destination_data = [
                    'name' => $this->input->post('name', TRUE),
                    'country' => $this->input->post('country', TRUE),
                    'description' => $this->input->post('description'),
                    'best_time' => $this->input->post('best_time', TRUE),
                    'highlights' => $this->input->post('highlights') ?: NULL,
                    'activities' => $this->input->post('activities') ?: NULL,
                    'seo_title' => $this->input->post('seo_title', TRUE) ?: NULL,
                    'seo_description' => $this->input->post('seo_description', TRUE) ?: NULL,
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['featured_image']['name'])) {
                    $image = $this->upload_image('featured_image');
                    if ($image) {
                        $destination_data['featured_image'] = $image;
                    }
                }

                if ($this->Destination_model->create($destination_data)) {
                    $this->session->set_flashdata('success', 'Destination created successfully.');
                    redirect('admin/destinations');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create destination.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/destinations/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Edit destination
     */
    public function edit($uid)
    {
        $destination = $this->Destination_model->get_by_uid($uid);
        if (!$destination) {
            $this->session->set_flashdata('error', 'Destination not found.');
            redirect('admin/destinations');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Destination';
        $data['destination'] = $destination;
        $data['form_action'] = base_url('admin/destinations/edit/' . $uid);

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Destination Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('country', 'Country', 'required|trim');
            $this->form_validation->set_rules('description', 'Description', 'required');

            if ($this->form_validation->run() === TRUE) {
                // Check if name already exists (excluding current)
                if ($this->Destination_model->name_exists($this->input->post('name'), $destination->id)) {
                    $this->session->set_flashdata('error', 'Destination name already exists.');
                    redirect('admin/destinations/edit/' . $uid);
                    return;
                }

                $destination_data = [
                    'name' => $this->input->post('name', TRUE),
                    'country' => $this->input->post('country', TRUE),
                    'description' => $this->input->post('description'),
                    'best_time' => $this->input->post('best_time', TRUE),
                    'highlights' => $this->input->post('highlights') ?: NULL,
                    'activities' => $this->input->post('activities') ?: NULL,
                    'seo_title' => $this->input->post('seo_title', TRUE) ?: NULL,
                    'seo_description' => $this->input->post('seo_description', TRUE) ?: NULL,
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if (!empty($_FILES['featured_image']['name'])) {
                    $image = $this->upload_image('featured_image');
                    if ($image) {
                        // Delete old image if exists
                        if (!empty($destination->featured_image) && file_exists($this->upload_path . $destination->featured_image)) {
                            unlink($this->upload_path . $destination->featured_image);
                        }
                        $destination_data['featured_image'] = $image;
                    }
                }

                if ($this->Destination_model->update($uid, $destination_data)) {
                    $this->session->set_flashdata('success', 'Destination updated successfully.');
                    redirect('admin/destinations');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update destination.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/destinations/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Delete destination
     */
    public function delete($uid)
    {
        $destination = $this->Destination_model->get_by_uid($uid);
        if (!$destination) {
            $this->session->set_flashdata('error', 'Destination not found.');
            redirect('admin/destinations');
        }

        // Delete image if exists
        if (!empty($destination->featured_image) && file_exists($this->upload_path . $destination->featured_image)) {
            unlink($this->upload_path . $destination->featured_image);
        }

        if ($this->Destination_model->delete($uid)) {
            $this->session->set_flashdata('success', 'Destination deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete destination.');
        }

        redirect('admin/destinations');
    }

    /**
     * Toggle active status
     */
    public function toggle_active($uid)
    {
        if (!$this->input->is_ajax_request()) {
            $this->session->set_flashdata('error', 'Invalid request.');
            redirect('admin/destinations');
        }

        $destination = $this->Destination_model->get_by_uid($uid);
        if (!$destination) {
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Destination not found']);
            return;
        }

        $new_status = $destination->is_active ? 0 : 1;
        $result = $this->Destination_model->toggle_active($uid, $new_status);

        $this->output->set_content_type('application/json');
        echo json_encode([
            'success' => $result,
            'is_active' => $new_status,
            'message' => $result ? 'Status updated successfully' : 'Failed to update status'
        ]);
    }

    /**
     * Upload image
     */
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
