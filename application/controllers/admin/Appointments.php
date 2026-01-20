<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointments extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Appointment_model');
        $this->load->library('pagination');
        $this->load->helper('security');
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Appointments';
        $data['active_template'] = get_active_template();
        
        $status = $this->input->get('status') ?? 'all';
        $search = $this->input->get('search') ?? '';
        $date_from = $this->input->get('date_from') ?? '';
        $date_to = $this->input->get('date_to') ?? '';
        $per_page = 20;
        $page = $this->input->get('page') ?? 1;
        $offset = ($page - 1) * $per_page;
        
        $data['appointments'] = $this->Appointment_model->get_all_admin(
            $per_page, 
            $offset, 
            $status, 
            $search,
            $date_from,
            $date_to,
            $data['active_template']
        );
        
        $total = $this->Appointment_model->count_admin($status, $search, $date_from, $date_to, $data['active_template']);
        
        $data['pagination'] = [
            'total' => $total,
            'per_page' => $per_page,
            'current_page' => $page,
            'total_pages' => ceil($total / $per_page)
        ];

        $data['filters'] = [
            'status' => $status,
            'search' => $search,
            'date_from' => $date_from,
            'date_to' => $date_to
        ];

        $data['stats'] = $this->Appointment_model->get_stats($data['active_template']);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/appointments/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function view($uid)
    {
        $data = $this->get_admin_data();
        
        $appointment = $this->Appointment_model->get_details($uid);
        
        if (!$appointment) {
            $this->session->set_flashdata('error', 'Appointment not found.');
            redirect('admin/appointments');
        }

        $data['page_title'] = 'Appointment: ' . $appointment->uid;
        $data['appointment'] = $appointment;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/appointments/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function update_status($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/appointments');
            return;
        }

        $appointment = $this->Appointment_model->get_details($uid);
        
        if (!$appointment) {
            $this->session->set_flashdata('error', 'Appointment not found.');
            redirect('admin/appointments');
            return;
        }

        $new_status = $this->input->post('status');
        $notes = $this->input->post('notes') ?? '';
        $assigned_to = $this->input->post('assigned_to') ?? null;

        $valid_statuses = ['pending', 'confirmed', 'completed', 'cancelled', 'no_show'];
        
        if (!in_array($new_status, $valid_statuses)) {
            $this->session->set_flashdata('error', 'Invalid status.');
            redirect('admin/appointments/view/' . $uid);
            return;
        }

        $update_data = [
            'status' => $new_status,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($assigned_to !== null) {
            $update_data['assigned_to'] = $assigned_to;
        }

        if (!empty($notes)) {
            $existing_notes = $appointment->admin_notes ?? '';
            $update_data['admin_notes'] = $existing_notes . "\n" . date('Y-m-d H:i') . ": " . $notes;
        }

        if ($this->Appointment_model->update($appointment->id, $update_data)) {
            $this->session->set_flashdata('success', 'Appointment status updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update appointment status.');
        }

        redirect('admin/appointments/view/' . $uid);
    }

    public function delete($uid)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method.');
            redirect('admin/appointments');
            return;
        }

        $appointment = $this->Appointment_model->get_details($uid);
        
        if (!$appointment) {
            $this->session->set_flashdata('error', 'Appointment not found.');
            redirect('admin/appointments');
            return;
        }

        if ($this->Appointment_model->delete($appointment->id)) {
            $this->session->set_flashdata('success', 'Appointment deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete appointment.');
        }

        redirect('admin/appointments');
    }

    public function export()
    {
        $status = $this->input->get('status') ?? 'all';
        $date_from = $this->input->get('date_from') ?? '';
        $date_to = $this->input->get('date_to') ?? '';

        $appointments = $this->Appointment_model->get_for_export($status, $date_from, $date_to);

        $filename = 'appointments_export_' . date('Y-m-d_His') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        fputcsv($output, [
            'Reference',
            'Patient Name',
            'Email',
            'Phone',
            'Country',
            'Specialty',
            'Preferred Date',
            'Preferred Time',
            'Timeline',
            'Status',
            'Notes',
            'Booked On'
        ]);
        
        foreach ($appointments as $apt) {
            fputcsv($output, [
                $apt->uid,
                $apt->patient_name,
                $apt->patient_email,
                $apt->patient_phone,
                $apt->country ?? '',
                $apt->medical_specialty ?? '',
                $apt->preferred_date,
                $apt->preferred_time,
                $apt->treatment_timeline ?? '',
                ucfirst($apt->status),
                $apt->additional_notes ?? '',
                $apt->created_at
            ]);
        }
        
        fclose($output);
        exit;
    }
}
