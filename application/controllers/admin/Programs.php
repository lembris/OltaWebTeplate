<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programs extends Admin_Controller 
{
    private $upload_path = './assets/img/programs/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Academic_program_model');
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
        log_message('error', 'Program image upload failed: ' . $error_msg);
        $this->session->set_flashdata('error', 'Image upload failed: ' . $error_msg);
        return false;
    }

    /**
     * List all academic programs
     */
    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Academic Programs';
        
        // Search functionality
        $keyword = $this->input->get('keyword');
        $dept_filter = $this->input->get('department');
        $level_filter = $this->input->get('level');
        
        if ($keyword) {
            $data['programs'] = $this->Academic_program_model->search($keyword, 100);
            $data['keyword'] = $keyword;
        } elseif ($dept_filter) {
            $data['programs'] = $this->Academic_program_model->get_by_department($dept_filter, 100);
            $data['keyword'] = '';
            $data['dept_filter'] = $dept_filter;
        } elseif ($level_filter) {
            $data['programs'] = $this->Academic_program_model->get_by_level($level_filter, 100);
            $data['keyword'] = '';
            $data['level_filter'] = $level_filter;
        } else {
            $data['programs'] = $this->Academic_program_model->get_all(100);
            $data['keyword'] = '';
        }
        
        $data['departments'] = $this->Department_model->get_all();
        $data['levels'] = ['Certificate', 'Diploma', 'Degree', 'Masters', 'PhD'];
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/programs/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Create new academic program
     */
    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add Academic Program';
        $data['program'] = null;
        $data['departments'] = $this->Department_model->get_all();
        $data['levels'] = ['Certificate', 'Diploma', 'Degree', 'Masters', 'PhD'];

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Program Name', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('code', 'Program Code', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('department_id', 'Department', 'required');
            $this->form_validation->set_rules('level', 'Level', 'required');
            $this->form_validation->set_rules('duration_months', 'Duration (Months)', 'required|numeric');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $code = $this->input->post('code', TRUE);
                
                // Check if code already exists
                if ($this->Academic_program_model->code_exists($code)) {
                    $this->session->set_flashdata('error', 'Program code already exists.');
                } else {
                    $program_data = [
                        'name' => $this->input->post('name', TRUE),
                        'code' => $code,
                        'department_id' => $this->input->post('department_id', TRUE),
                        'level' => $this->input->post('level', TRUE),
                        'duration_months' => $this->input->post('duration_months', TRUE),
                        'description' => $this->input->post('description', TRUE),
                        'status' => $this->input->post('status', TRUE) ?: 'active'
                    ];

                    if (!empty($_FILES['image']['name'])) {
                        $image = $this->upload_image('image');
                        if ($image) {
                            $program_data['image'] = $image;
                        }
                    }

                    if ($this->Academic_program_model->create($program_data)) {
                        $this->session->set_flashdata('success', 'Academic program created successfully.');
                        redirect('admin/programs');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to create program.');
                    }
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/programs/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Edit academic program
     */
    public function edit($uid)
    {
        $program = $this->Academic_program_model->get_by_uid($uid);
        if (!$program) {
            $this->session->set_flashdata('error', 'Program not found.');
            redirect('admin/programs');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Academic Program';
        $data['program'] = $program;
        $data['departments'] = $this->Department_model->get_all();
        $data['levels'] = ['Certificate', 'Diploma', 'Degree', 'Masters', 'PhD'];

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Program Name', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('code', 'Program Code', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('department_id', 'Department', 'required');
            $this->form_validation->set_rules('level', 'Level', 'required');
            $this->form_validation->set_rules('duration_months', 'Duration (Months)', 'required|numeric');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $code = $this->input->post('code', TRUE);
                
                // Check if code already exists (excluding current)
                if ($this->Academic_program_model->code_exists($code, $program->id)) {
                    $this->session->set_flashdata('error', 'Program code already exists.');
                } else {
                    $program_data = [
                        'name' => $this->input->post('name', TRUE),
                        'code' => $code,
                        'department_id' => $this->input->post('department_id', TRUE),
                        'level' => $this->input->post('level', TRUE),
                        'duration_months' => $this->input->post('duration_months', TRUE),
                        'description' => $this->input->post('description', TRUE),
                        'status' => $this->input->post('status', TRUE) ?: 'active'
                    ];

                    if (!empty($_FILES['image']['name'])) {
                        $image = $this->upload_image('image');
                        if ($image) {
                            if (!empty($program->image) && file_exists($this->upload_path . $program->image)) {
                                @unlink($this->upload_path . $program->image);
                            }
                            $program_data['image'] = $image;
                        }
                    }

                    if ($this->Academic_program_model->update_by_uid($uid, $program_data)) {
                        $this->session->set_flashdata('success', 'Program updated successfully.');
                        redirect('admin/programs');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to update program.');
                    }
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/programs/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * View program details
     */
    public function view($uid)
    {
        $program = $this->Academic_program_model->get_by_uid($uid);
        if (!$program) {
            $this->session->set_flashdata('error', 'Program not found.');
            redirect('admin/programs');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Program Details';
        $data['program'] = $program;
        $data['courses'] = $this->Academic_program_model->get_program_courses($program->id);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/programs/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Delete program
     */
    public function delete($uid)
    {
        $program = $this->Academic_program_model->get_by_uid($uid);
        if (!$program) {
            $this->session->set_flashdata('error', 'Program not found.');
            redirect('admin/programs');
        }

        if ($this->Academic_program_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Program deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete program.');
        }

        redirect('admin/programs');
    }

    /**
     * Toggle program status
     */
    public function toggle_status($uid)
    {
        if (!$this->input->is_ajax_request()) {
            return;
        }

        $program = $this->Academic_program_model->get_by_uid($uid);
        if (!$program) {
            echo json_encode(['status' => 'error', 'message' => 'Program not found']);
            return;
        }

        $new_status = $program->status === 'active' ? 'inactive' : 'active';
        
        if ($this->Academic_program_model->toggle_status_by_uid($uid, $new_status)) {
            echo json_encode(['status' => 'success', 'new_status' => $new_status]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
        }
    }

    /**
     * Add course to program
     */
    public function add_course($program_id)
    {
        if (!$this->input->is_ajax_request()) {
            return;
        }

        $program = $this->Academic_program_model->get_by_id($program_id);
        if (!$program) {
            echo json_encode(['status' => 'error', 'message' => 'Program not found']);
            return;
        }

        $this->form_validation->set_rules('course_code', 'Course Code', 'required|trim');
        $this->form_validation->set_rules('course_name', 'Course Name', 'required|trim');
        $this->form_validation->set_rules('semester', 'Semester', 'required|numeric');
        $this->form_validation->set_rules('credits', 'Credits', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $course_data = [
            'program_id' => $program_id,
            'course_code' => $this->input->post('course_code', TRUE),
            'course_name' => $this->input->post('course_name', TRUE),
            'semester' => $this->input->post('semester', TRUE),
            'credits' => $this->input->post('credits', TRUE),
            'description' => $this->input->post('description', TRUE)
        ];

        if ($this->Academic_program_model->add_course($course_data)) {
            echo json_encode(['status' => 'success', 'message' => 'Course added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add course']);
        }
    }

    /**
     * Update course
     */
    public function update_course($course_id)
    {
        if (!$this->input->is_ajax_request()) {
            return;
        }

        $course = $this->Academic_program_model->get_course_by_id($course_id);
        if (!$course) {
            echo json_encode(['status' => 'error', 'message' => 'Course not found']);
            return;
        }

        $this->form_validation->set_rules('course_code', 'Course Code', 'required|trim');
        $this->form_validation->set_rules('course_name', 'Course Name', 'required|trim');
        $this->form_validation->set_rules('semester', 'Semester', 'required|numeric');
        $this->form_validation->set_rules('credits', 'Credits', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $course_data = [
            'course_code' => $this->input->post('course_code', TRUE),
            'course_name' => $this->input->post('course_name', TRUE),
            'semester' => $this->input->post('semester', TRUE),
            'credits' => $this->input->post('credits', TRUE),
            'description' => $this->input->post('description', TRUE)
        ];

        if ($this->Academic_program_model->update_course($course_id, $course_data)) {
            echo json_encode(['status' => 'success', 'message' => 'Course updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update course']);
        }
    }

    /**
     * Delete course
     */
    public function delete_course($course_id)
    {
        header('Content-Type: application/json');
        
        if (!$this->input->is_ajax_request()) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
            return;
        }

        $course = $this->Academic_program_model->get_course_by_id($course_id);
        if (!$course) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Course not found']);
            return;
        }

        try {
            if ($this->Academic_program_model->delete_course($course_id)) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Course deleted successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete course']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
