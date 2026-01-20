<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Faculty_staff_model');
        $this->load->model('Department_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->helper(['form', 'url']);
    }

    /**
     * List all faculty members
     */
    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Faculty & Staff';
        
        // Search functionality
        $keyword = $this->input->get('keyword');
        if ($keyword) {
            $data['faculty'] = $this->Faculty_staff_model->search($keyword, 100);
            $data['keyword'] = $keyword;
        } else {
            $data['faculty'] = $this->Faculty_staff_model->get_all(100);
            $data['keyword'] = '';
        }
        
        // Load departments for filtering
        $data['departments'] = $this->Department_model->get_all();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/faculty/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Create new faculty member
     */
    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add Faculty Member';
        $data['faculty'] = null;
        $data['departments'] = $this->Department_model->get_active();

        if ($this->input->post()) {
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('department_id', 'Department', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'trim');
            $this->form_validation->set_rules('office_location', 'Office Location', 'trim');
            $this->form_validation->set_rules('office_hours', 'Office Hours', 'trim');
            $this->form_validation->set_rules('bio', 'Bio', 'trim');
            $this->form_validation->set_rules('specialization', 'Specialization', 'trim');
            $this->form_validation->set_rules('qualifications', 'Qualifications', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email', TRUE);
                $first_name = $this->input->post('first_name', TRUE);
                $last_name = $this->input->post('last_name', TRUE);
                
                // Generate slug from first and last name
                $slug = strtolower(trim($first_name . ' ' . $last_name));
                $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $slug);
                $slug = preg_replace('/^-|-$/', '', $slug);
                
                // Check if slug exists and make unique if needed
                $original_slug = $slug;
                $counter = 1;
                while ($this->Faculty_staff_model->get_by_slug($slug)) {
                    $slug = $original_slug . '-' . $counter++;
                }
                
                // Check if email already exists
                if ($this->Faculty_staff_model->email_exists($email)) {
                    $this->session->set_flashdata('error', 'This email address is already registered.');
                } else {
                    $faculty_data = [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'slug' => $slug,
                        'title' => $this->input->post('title', TRUE),
                        'email' => $email,
                        'department_id' => $this->input->post('department_id', TRUE),
                        'phone' => $this->input->post('phone', TRUE),
                        'office_location' => $this->input->post('office_location', TRUE),
                        'office_hours' => $this->input->post('office_hours', TRUE),
                        'bio' => $this->input->post('bio', TRUE),
                        'specialization' => $this->input->post('specialization', TRUE),
                        'qualifications' => $this->input->post('qualifications', TRUE),
                        'status' => $this->input->post('status', TRUE) ?: 'active',
                        'is_featured' => $this->input->post('is_featured') ? 1 : 0
                    ];

                    // Handle photo upload
                    if (!empty($_FILES['photo']['name'])) {
                        $photo = $this->upload_photo();
                        if ($photo) {
                            $faculty_data['photo'] = $photo;
                        }
                    }

                    if ($this->Faculty_staff_model->create($faculty_data)) {
                        $this->session->set_flashdata('success', 'Faculty member created successfully.');
                        redirect('admin/faculty');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to create faculty member.');
                    }
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/faculty/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Edit faculty member
     */
    public function edit($uid)
    {
        $faculty = $this->Faculty_staff_model->get_by_uid($uid);
        if (!$faculty) {
            $this->session->set_flashdata('error', 'Faculty member not found.');
            redirect('admin/faculty');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Faculty Member';
        $data['faculty'] = $faculty;
        $data['departments'] = $this->Department_model->get_active();

        if ($this->input->post()) {
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('department_id', 'Department', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'trim');
            $this->form_validation->set_rules('office_location', 'Office Location', 'trim');
            $this->form_validation->set_rules('office_hours', 'Office Hours', 'trim');
            $this->form_validation->set_rules('bio', 'Bio', 'trim');
            $this->form_validation->set_rules('specialization', 'Specialization', 'trim');
            $this->form_validation->set_rules('qualifications', 'Qualifications', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email', TRUE);
                $first_name = $this->input->post('first_name', TRUE);
                $last_name = $this->input->post('last_name', TRUE);
                
                // Generate slug from first and last name
                $slug = strtolower(trim($first_name . ' ' . $last_name));
                $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $slug);
                $slug = preg_replace('/^-|-$/', '', $slug);
                
                // Check if slug exists and make unique if needed (excluding current)
                $original_slug = $slug;
                $counter = 1;
                $existing = $this->Faculty_staff_model->get_by_slug($slug);
                while ($existing && $existing->id != $faculty->id) {
                    $slug = $original_slug . '-' . $counter++;
                    $existing = $this->Faculty_staff_model->get_by_slug($slug);
                }
                
                // Check if email already exists (excluding current)
                if ($this->Faculty_staff_model->email_exists($email, $faculty->id)) {
                    $this->session->set_flashdata('error', 'This email address is already registered.');
                } else {
                    $faculty_data = [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'slug' => $slug,
                        'title' => $this->input->post('title', TRUE),
                        'email' => $email,
                        'department_id' => $this->input->post('department_id', TRUE),
                        'phone' => $this->input->post('phone', TRUE),
                        'office_location' => $this->input->post('office_location', TRUE),
                        'office_hours' => $this->input->post('office_hours', TRUE),
                        'bio' => $this->input->post('bio', TRUE),
                        'specialization' => $this->input->post('specialization', TRUE),
                        'qualifications' => $this->input->post('qualifications', TRUE),
                        'status' => $this->input->post('status', TRUE) ?: 'active',
                        'is_featured' => $this->input->post('is_featured') ? 1 : 0
                    ];

                    // Handle photo upload
                    if (!empty($_FILES['photo']['name'])) {
                        $photo = $this->upload_photo();
                        if ($photo) {
                            // Delete old photo if exists
                            if ($faculty->photo && file_exists('assets/images/faculty/' . $faculty->photo)) {
                                unlink('assets/images/faculty/' . $faculty->photo);
                            }
                            $faculty_data['photo'] = $photo;
                        }
                    }

                    if ($this->Faculty_staff_model->update_by_uid($uid, $faculty_data)) {
                        $this->session->set_flashdata('success', 'Faculty member updated successfully.');
                        redirect('admin/faculty');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to update faculty member.');
                    }
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/faculty/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * View faculty member details
     */
    public function view($uid)
    {
        $faculty = $this->Faculty_staff_model->get_by_uid($uid);
        if (!$faculty) {
            $this->session->set_flashdata('error', 'Faculty member not found.');
            redirect('admin/faculty');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Faculty Member Details';
        $data['faculty'] = $faculty;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/faculty/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Delete faculty member
     */
    public function delete($uid)
    {
        $faculty = $this->Faculty_staff_model->get_by_uid($uid);
        if (!$faculty) {
            $this->session->set_flashdata('error', 'Faculty member not found.');
            redirect('admin/faculty');
        }

        // Delete photo if exists
        if ($faculty->photo && file_exists('assets/images/faculty/' . $faculty->photo)) {
            unlink('assets/images/faculty/' . $faculty->photo);
        }

        if ($this->Faculty_staff_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Faculty member deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete faculty member.');
        }

        redirect('admin/faculty');
    }

    /**
     * Toggle faculty member status
     */
    public function toggle_status($uid)
    {
        if (!$this->input->is_ajax_request()) {
            return;
        }

        $faculty = $this->Faculty_staff_model->get_by_uid($uid);
        if (!$faculty) {
            echo json_encode(['status' => 'error', 'message' => 'Faculty member not found']);
            return;
        }

        $statuses = ['active', 'inactive', 'on_leave'];
        $current_index = array_search($faculty->status, $statuses);
        $new_status = $statuses[($current_index + 1) % count($statuses)];
        
        if ($this->Faculty_staff_model->toggle_status_by_uid($uid, $new_status)) {
            echo json_encode(['status' => 'success', 'new_status' => $new_status]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
        }
    }

    /**
     * Upload faculty photo
     */
    private function upload_photo()
    {
        $config['upload_path']   = './assets/images/faculty/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size']      = 5120; // 5MB
        $config['file_name']     = 'faculty_' . time() . '_' . substr(md5(uniqid()), 0, 8);

        // Create directory if doesn't exist
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('photo')) {
            log_message('error', 'Faculty photo upload failed: ' . $this->upload->display_errors());
            return false;
        }

        $upload_data = $this->upload->data();
        return $upload_data['file_name'];
    }
}
