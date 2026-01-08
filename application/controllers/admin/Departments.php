<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends Admin_Controller 
{
    private $upload_path = './assets/img/departments/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Department_model');
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
        log_message('error', 'Department image upload failed: ' . $error_msg);
        $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
        return false;
    }

    /**
     * List all departments
     */
    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Departments';
        
        // Search functionality
        $keyword = $this->input->get('keyword');
        if ($keyword) {
            $data['departments'] = $this->Department_model->search($keyword, 100);
            $data['keyword'] = $keyword;
        } else {
            $data['departments'] = $this->Department_model->get_all(100);
            $data['keyword'] = '';
        }
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/departments/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Create new department
     */
    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add Department';
        $data['department'] = null;

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Department Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('code', 'Department Code', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('head_name', 'Head Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $code = $this->input->post('code', TRUE);
                
                // Check if code already exists
                if ($this->Department_model->code_exists($code)) {
                    $this->session->set_flashdata('error', 'Department code already exists.');
                } else {
                    $dept_data = [
                        'name' => $this->input->post('name', TRUE),
                        'code' => $code,
                        'head_name' => $this->input->post('head_name', TRUE),
                        'head_email' => $this->input->post('head_email', TRUE),
                        'head_phone' => $this->input->post('head_phone', TRUE),
                        'description' => $this->input->post('description', TRUE),
                        'status' => $this->input->post('status', TRUE) ?: 'active'
                    ];

                    if (!empty($_FILES['image']['name'])) {
                        $image = $this->upload_image('image');
                        if ($image) {
                            $dept_data['image'] = $image;
                        }
                    }

                    if ($this->Department_model->create($dept_data)) {
                        $this->session->set_flashdata('success', 'Department created successfully.');
                        redirect('admin/departments');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to create department.');
                    }
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/departments/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Edit department
     */
    public function edit($uid)
    {
        $department = $this->Department_model->get_by_uid($uid);
        if (!$department) {
            $this->session->set_flashdata('error', 'Department not found.');
            redirect('admin/departments');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Department';
        $data['department'] = $department;

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Department Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('code', 'Department Code', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('head_name', 'Head Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $code = $this->input->post('code', TRUE);
                
                // Check if code already exists (excluding current)
                if ($this->Department_model->code_exists($code, $department->id)) {
                    $this->session->set_flashdata('error', 'Department code already exists.');
                } else {
                    $dept_data = [
                        'name' => $this->input->post('name', TRUE),
                        'code' => $code,
                        'head_name' => $this->input->post('head_name', TRUE),
                        'head_email' => $this->input->post('head_email', TRUE),
                        'head_phone' => $this->input->post('head_phone', TRUE),
                        'description' => $this->input->post('description', TRUE),
                        'status' => $this->input->post('status', TRUE) ?: 'active'
                    ];

                    if (!empty($_FILES['image']['name'])) {
                        $image = $this->upload_image('image');
                        if ($image) {
                            if (!empty($department->image) && file_exists($this->upload_path . $department->image)) {
                                @unlink($this->upload_path . $department->image);
                            }
                            $dept_data['image'] = $image;
                        }
                    }

                    if ($this->Department_model->update_by_uid($uid, $dept_data)) {
                        $this->session->set_flashdata('success', 'Department updated successfully.');
                        redirect('admin/departments');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to update department.');
                    }
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/departments/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * View department details
     */
    public function view($uid)
    {
        $department = $this->Department_model->get_by_uid($uid);
        if (!$department) {
            $this->session->set_flashdata('error', 'Department not found.');
            redirect('admin/departments');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Department Details';
        $data['department'] = $department;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/departments/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Delete department
     */
    public function delete($uid)
    {
        $department = $this->Department_model->get_by_uid($uid);
        if (!$department) {
            $this->session->set_flashdata('error', 'Department not found.');
            redirect('admin/departments');
        }

        if ($this->Department_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Department deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete department.');
        }

        redirect('admin/departments');
    }

    /**
     * Toggle department status
     */
    public function toggle_status($uid)
    {
        if (!$this->input->is_ajax_request()) {
            return;
        }

        $department = $this->Department_model->get_by_uid($uid);
        if (!$department) {
            echo json_encode(['status' => 'error', 'message' => 'Department not found']);
            return;
        }

        $new_status = $department->status === 'active' ? 'inactive' : 'active';
        
        if ($this->Department_model->toggle_status_by_uid($uid, $new_status)) {
            echo json_encode(['status' => 'success', 'new_status' => $new_status]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
        }
    }
}
