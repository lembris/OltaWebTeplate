<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admissions extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admission_model');
        $this->load->model('Academic_program_model');
        $this->load->library(['form_validation', 'pagination']);
        $this->load->helper(['form', 'url', 'text']);
    }

    /**
     * List all admissions
     */
    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Admissions';

        $status = $this->input->get('status');
        $search = $this->input->get('search');
        $program_id = $this->input->get('program_id');
        $per_page = 20;
        $page = (int)$this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;

        $data['admissions'] = $this->Admission_model->get_all($per_page, $offset, $status, $search, $program_id);
        $data['total_admissions'] = $this->Admission_model->count_all($status, $search, $program_id);
        $data['stats'] = $this->Admission_model->get_statistics();
        $data['programs'] = $this->Academic_program_model->get_active();
        
        $data['current_status'] = $status;
        $data['search'] = $search;
        $data['current_program'] = $program_id;
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($data['total_admissions'] / $per_page);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/admissions/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * View single admission
     */
    public function view($uid)
    {
        $admission = $this->Admission_model->get_by_uid($uid);
        if (!$admission) {
            $this->session->set_flashdata('error', 'Admission not found.');
            redirect('admin/admissions');
            return;
        }

        $this->Admission_model->mark_as_read($admission->id);

        $data = $this->get_admin_data();
        $data['page_title'] = 'View Admission - ' . $admission->reference_number;
        $data['admission'] = $admission;
        $data['notes'] = $this->Admission_model->get_notes($admission->id);
        $data['status_history'] = $this->Admission_model->get_status_history($admission->id);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/admissions/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Edit admission
     */
    public function edit($uid)
    {
        $admission = $this->Admission_model->get_by_uid($uid);
        if (!$admission) {
            $this->session->set_flashdata('error', 'Admission not found.');
            redirect('admin/admissions');
            return;
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|min_length[2]|max_length[255]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|max_length[50]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[pending,under_review,accepted,rejected,waitlisted,enrolled,withdrawn]');

            if ($this->form_validation->run() === TRUE) {
                $old_status = $admission->status;
                $new_status = $this->input->post('status', TRUE);

                $update_data = [
                    'full_name' => $this->input->post('full_name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'date_of_birth' => $this->input->post('date_of_birth') ?: null,
                    'gender' => $this->input->post('gender', TRUE),
                    'nationality' => $this->input->post('nationality', TRUE),
                    'address' => $this->input->post('address', TRUE),
                    'city' => $this->input->post('city', TRUE),
                    'country' => $this->input->post('country', TRUE),
                    'postal_code' => $this->input->post('postal_code', TRUE),
                    'previous_qualification' => $this->input->post('previous_qualification', TRUE),
                    'institution_name' => $this->input->post('institution_name', TRUE),
                    'graduation_year' => $this->input->post('graduation_year', TRUE),
                    'gpa_score' => $this->input->post('gpa_score', TRUE),
                    'emergency_contact_name' => $this->input->post('emergency_contact_name', TRUE),
                    'emergency_contact_phone' => $this->input->post('emergency_contact_phone', TRUE),
                    'emergency_contact_relation' => $this->input->post('emergency_contact_relation', TRUE),
                    'program_id' => $this->input->post('program_id') ?: null,
                    'intake_term' => $this->input->post('intake_term', TRUE),
                    'intake_year' => $this->input->post('intake_year', TRUE),
                    'admin_notes' => $this->input->post('admin_notes', TRUE),
                    'status' => $new_status
                ];

                if ($this->Admission_model->update_by_uid($uid, $update_data)) {
                    // Log status change if changed (don't call update_status as it would update twice)
                    if ($old_status !== $new_status) {
                        $this->Admission_model->log_status_change(
                            $admission->id,
                            $old_status,
                            $new_status, 
                            $this->session->userdata('admin_id'),
                            'Status updated via edit form'
                        );
                    }
                    $this->session->set_flashdata('success', 'Admission updated successfully.');
                    redirect('admin/admissions/view/' . $uid);
                } else {
                    $this->session->set_flashdata('error', 'Failed to update admission.');
                }
            }
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Admission - ' . $admission->reference_number;
        $data['admission'] = $admission;
        $data['programs'] = $this->Academic_program_model->get_active();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/admissions/edit', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Update status via AJAX or form
     */
    public function update_status($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/admissions');
            return;
        }

        $admission = $this->Admission_model->get_by_uid($uid);
        if (!$admission) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Admission not found.']);
                return;
            }
            $this->session->set_flashdata('error', 'Admission not found.');
            redirect('admin/admissions');
            return;
        }

        $status = $this->input->post('status');
        $notes = $this->input->post('notes', TRUE);
        $valid_statuses = ['pending', 'under_review', 'accepted', 'rejected', 'waitlisted', 'enrolled', 'withdrawn'];
        
        if (!in_array($status, $valid_statuses)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Invalid status.']);
                return;
            }
            $this->session->set_flashdata('error', 'Invalid status.');
            redirect('admin/admissions/view/' . $uid);
            return;
        }

        $admin_id = $this->session->userdata('admin_id');
        
        if ($this->Admission_model->update_status($admission->id, $status, $admin_id, $notes)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => true, 'message' => 'Status updated successfully.', 'status' => $status]);
                return;
            }
            $this->session->set_flashdata('success', 'Status updated successfully.');
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
                return;
            }
            $this->session->set_flashdata('error', 'Failed to update status.');
        }

        redirect('admin/admissions/view/' . $uid);
    }

    /**
     * Add note
     */
    public function add_note($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/admissions');
            return;
        }

        $admission = $this->Admission_model->get_by_uid($uid);
        if (!$admission) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Admission not found.']);
                return;
            }
            $this->session->set_flashdata('error', 'Admission not found.');
            redirect('admin/admissions');
            return;
        }

        $note = $this->input->post('note', TRUE);
        if (empty($note)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Note cannot be empty.']);
                return;
            }
            $this->session->set_flashdata('error', 'Note cannot be empty.');
            redirect('admin/admissions/view/' . $uid);
            return;
        }

        $admin_id = $this->session->userdata('admin_id');
        
        if ($this->Admission_model->add_note($admission->id, $note, $admin_id)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => true, 'message' => 'Note added successfully.']);
                return;
            }
            $this->session->set_flashdata('success', 'Note added successfully.');
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Failed to add note.']);
                return;
            }
            $this->session->set_flashdata('error', 'Failed to add note.');
        }

        redirect('admin/admissions/view/' . $uid);
    }

    /**
     * Delete admission
     */
    public function delete($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/admissions');
            return;
        }

        $admission = $this->Admission_model->get_by_uid($uid);
        if (!$admission) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Admission not found.']);
                return;
            }
            $this->session->set_flashdata('error', 'Admission not found.');
            redirect('admin/admissions');
            return;
        }

        if ($this->Admission_model->delete_by_uid($uid)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => true, 'message' => 'Admission deleted successfully.']);
                return;
            }
            $this->session->set_flashdata('success', 'Admission deleted successfully.');
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Failed to delete admission.']);
                return;
            }
            $this->session->set_flashdata('error', 'Failed to delete admission.');
        }

        redirect('admin/admissions');
    }

    /**
     * Export admissions to CSV
     */
    public function export()
    {
        $status = $this->input->get('status');
        $program_id = $this->input->get('program_id');
        $admissions = $this->Admission_model->get_for_export($status, $program_id);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="admissions_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, [
            'Reference', 'Full Name', 'Email', 'Phone', 'Date of Birth', 'Gender', 
            'Nationality', 'Country', 'Program', 'Previous Qualification', 
            'Institution', 'Graduation Year', 'GPA', 'Status', 'Applied Date'
        ]);

        foreach ($admissions as $adm) {
            fputcsv($output, [
                $adm->reference_number,
                $adm->full_name,
                $adm->email,
                $adm->phone ?? '',
                $adm->date_of_birth ?? '',
                $adm->gender ?? '',
                $adm->nationality ?? '',
                $adm->country ?? '',
                $adm->program_name ?? 'N/A',
                $adm->previous_qualification ?? '',
                $adm->institution_name ?? '',
                $adm->graduation_year ?? '',
                $adm->gpa_score ?? '',
                $adm->status,
                $adm->created_at
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Create new admission (admin-side)
     */
    public function create()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|min_length[2]|max_length[255]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|max_length[50]');

            if ($this->form_validation->run() === TRUE) {
                $insert_data = [
                    'full_name' => $this->input->post('full_name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'date_of_birth' => $this->input->post('date_of_birth') ?: null,
                    'gender' => $this->input->post('gender', TRUE),
                    'nationality' => $this->input->post('nationality', TRUE),
                    'address' => $this->input->post('address', TRUE),
                    'city' => $this->input->post('city', TRUE),
                    'country' => $this->input->post('country', TRUE),
                    'postal_code' => $this->input->post('postal_code', TRUE),
                    'previous_qualification' => $this->input->post('previous_qualification', TRUE),
                    'institution_name' => $this->input->post('institution_name', TRUE),
                    'graduation_year' => $this->input->post('graduation_year', TRUE),
                    'gpa_score' => $this->input->post('gpa_score', TRUE),
                    'emergency_contact_name' => $this->input->post('emergency_contact_name', TRUE),
                    'emergency_contact_phone' => $this->input->post('emergency_contact_phone', TRUE),
                    'emergency_contact_relation' => $this->input->post('emergency_contact_relation', TRUE),
                    'program_id' => $this->input->post('program_id') ?: null,
                    'intake_term' => $this->input->post('intake_term', TRUE),
                    'intake_year' => $this->input->post('intake_year', TRUE),
                    'admin_notes' => $this->input->post('admin_notes', TRUE),
                    'status' => $this->input->post('status', TRUE) ?: 'pending',
                    'is_read' => 1
                ];

                $insert_id = $this->Admission_model->create($insert_data);
                
                if ($insert_id) {
                    $admission = $this->Admission_model->get_by_id($insert_id);
                    $this->session->set_flashdata('success', 'Admission created successfully.');
                    redirect('admin/admissions/view/' . $admission->uid);
                } else {
                    $this->session->set_flashdata('error', 'Failed to create admission.');
                }
            }
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Create New Admission';
        $data['programs'] = $this->Academic_program_model->get_active();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/admissions/create', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Setup database tables
     */
    public function setup()
    {
        $results = $this->Admission_model->setup_tables();
        echo json_encode(['success' => true, 'results' => $results]);
    }
}
