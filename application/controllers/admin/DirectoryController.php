<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminDirectory extends Admin_Controller 
{
    private $upload_path = './assets/img/directory/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Directory_model');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['form', 'url']);
        
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
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
        log_message('error', 'Directory image upload failed: ' . $error_msg);
        $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
        return false;
    }

    /**
     * List all directory entries
     */
    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Directory';
        
        // Search functionality
        $keyword = $this->input->get('keyword');
        if ($keyword) {
            $data['directory'] = $this->Directory_model->search($keyword, 100);
            $data['keyword'] = $keyword;
        } else {
            $data['directory'] = $this->Directory_model->get_all(100);
            $data['keyword'] = '';
        }
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/directory/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Create new directory entry
     */
    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add Directory Entry';
        $data['entry'] = null;
        $data['types'] = ['department' => 'Department', 'faculty' => 'Faculty', 'staff' => 'Staff', 'office' => 'Office', 'service' => 'Service'];

        if ($this->input->post()) {
            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'trim');
            $this->form_validation->set_rules('location', 'Location', 'trim');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $entry_data = [
                    'type' => $this->input->post('type', TRUE),
                    'name' => $this->input->post('name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'alternate_phone' => $this->input->post('alternate_phone', TRUE),
                    'location' => $this->input->post('location', TRUE),
                    'room_number' => $this->input->post('room_number', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'website' => $this->input->post('website', TRUE),
                    'contact_person' => $this->input->post('contact_person', TRUE),
                    'status' => $this->input->post('status', TRUE) ?: 'active'
                ];

                if (!empty($_FILES['image']['name'])) {
                    $image = $this->upload_image('image');
                    if ($image) {
                        $entry_data['image'] = $image;
                    }
                }

                if ($this->Directory_model->create($entry_data)) {
                    $this->session->set_flashdata('success', 'Directory entry created successfully.');
                    redirect('admin/directory');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create directory entry.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/directory/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Edit directory entry
     */
    public function edit($uid)
    {
        $entry = $this->Directory_model->get_by_uid($uid);
        if (!$entry) {
            $this->session->set_flashdata('error', 'Directory entry not found.');
            redirect('admin/directory');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Directory Entry';
        $data['entry'] = $entry;
        $data['types'] = ['department' => 'Department', 'faculty' => 'Faculty', 'staff' => 'Staff', 'office' => 'Office', 'service' => 'Service'];

        if ($this->input->post()) {
            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'trim');
            $this->form_validation->set_rules('location', 'Location', 'trim');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $entry_data = [
                    'type' => $this->input->post('type', TRUE),
                    'name' => $this->input->post('name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'alternate_phone' => $this->input->post('alternate_phone', TRUE),
                    'location' => $this->input->post('location', TRUE),
                    'room_number' => $this->input->post('room_number', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'website' => $this->input->post('website', TRUE),
                    'contact_person' => $this->input->post('contact_person', TRUE),
                    'status' => $this->input->post('status', TRUE) ?: 'active'
                ];

                if (!empty($_FILES['image']['name'])) {
                    $image = $this->upload_image('image');
                    if ($image) {
                        if (!empty($entry->image) && file_exists($this->upload_path . $entry->image)) {
                            @unlink($this->upload_path . $entry->image);
                        }
                        $entry_data['image'] = $image;
                    }
                }

                if ($this->Directory_model->update_by_uid($uid, $entry_data)) {
                    $this->session->set_flashdata('success', 'Directory entry updated successfully.');
                    redirect('admin/directory');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update directory entry.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/directory/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * View directory entry details
     */
    public function view($uid)
    {
        $entry = $this->Directory_model->get_by_uid($uid);
        if (!$entry) {
            $this->session->set_flashdata('error', 'Directory entry not found.');
            redirect('admin/directory');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Directory Entry Details';
        $data['entry'] = $entry;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/directory/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Delete directory entry
     */
    public function delete($uid)
    {
        $entry = $this->Directory_model->get_by_uid($uid);
        if (!$entry) {
            $this->session->set_flashdata('error', 'Directory entry not found.');
            redirect('admin/directory');
        }

        if ($this->Directory_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Directory entry deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete directory entry.');
        }

        redirect('admin/directory');
    }

    /**
     * Toggle directory entry status
     */
    public function toggle_status($uid)
    {
        if (!$this->input->is_ajax_request()) {
            return;
        }

        $entry = $this->Directory_model->get_by_uid($uid);
        if (!$entry) {
            echo json_encode(['status' => 'error', 'message' => 'Directory entry not found']);
            return;
        }

        $new_status = $entry->status === 'active' ? 'inactive' : 'active';
        
        if ($this->Directory_model->toggle_status_by_uid($uid, $new_status)) {
            echo json_encode(['status' => 'success', 'new_status' => $new_status]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
        }
    }
}
