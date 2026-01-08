<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Event_calendar_model');
        $this->load->model('Department_model');
        $this->load->library('form_validation');
        $this->load->helper(['form', 'url', 'file']);
    }

    /**
     * Handle image upload
     */
    private function upload_image($field_name = 'banner')
    {
        if (empty($_FILES[$field_name]['name'])) {
            return null;
        }

        // Build upload path
        $base_path = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'events' . DIRECTORY_SEPARATOR;
        $upload_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $base_path);
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_path)) {
            if (!@mkdir($upload_path, 0777, true)) {
                // Try alternative method
                if (!file_exists($upload_path)) {
                    $this->session->set_flashdata('error', 'Upload directory does not exist and cannot be created: ' . $upload_path);
                    return false;
                }
            }
        }

        // Ensure directory is writable
        if (!is_writable($upload_path)) {
            if (!@chmod($upload_path, 0777)) {
                $this->session->set_flashdata('error', 'Upload directory is not writable.');
                return false;
            }
        }

        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'max_size'      => 2048,
            'encrypt_name'  => TRUE,
            'overwrite'     => FALSE
        ];

        // Reinitialize upload library with fresh config
        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            return 'assets/img/events/' . $this->upload->data('file_name');
        } else {
            $this->session->set_flashdata('error', 'Image upload failed: ' . $this->upload->display_errors());
            return false;
        }
    }

    /**
     * List all events
     */
    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Events';
        
        // Search functionality
        $keyword = $this->input->get('keyword');
        $dept_filter = $this->input->get('department');
        
        if ($keyword) {
            $data['events'] = $this->Event_calendar_model->search($keyword, 100);
            $data['keyword'] = $keyword;
        } elseif ($dept_filter) {
            $data['events'] = $this->Event_calendar_model->get_by_department($dept_filter, 100);
            $data['keyword'] = '';
            $data['dept_filter'] = $dept_filter;
        } else {
            $data['events'] = $this->Event_calendar_model->get_all(100);
            $data['keyword'] = '';
        }
        
        $data['departments'] = $this->Department_model->get_all();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/events/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Create new event
     */
    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add Event';
        $data['event'] = null;
        $data['departments'] = $this->Department_model->get_all();

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Event Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('end_date', 'End Date', 'required');
            $this->form_validation->set_rules('location', 'Location', 'required|trim');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                // Handle banner upload
                $banner = $this->upload_image('banner');
                if ($banner === false) {
                    // Error already set in session
                    goto show_form;
                }

                // Handle image upload
                $image = $this->upload_image('image');
                if ($image === false) {
                    // Error already set in session
                    goto show_form;
                }

                $event_data = [
                    'title' => $this->input->post('title', TRUE),
                    'start_date' => $this->input->post('start_date', TRUE),
                    'start_time' => $this->input->post('start_time', TRUE) ?: NULL,
                    'end_date' => $this->input->post('end_date', TRUE),
                    'end_time' => $this->input->post('end_time', TRUE) ?: NULL,
                    'location' => $this->input->post('location', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'department_id' => $this->input->post('department_id', TRUE) ?: NULL,
                    'event_type' => $this->input->post('event_type', TRUE) ?: 'academic',
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'registration_required' => $this->input->post('registration_required') ? 1 : 0,
                    'visibility' => $this->input->post('visibility', TRUE) ?: 'public',
                    'status' => $this->input->post('status', TRUE) ?: 'upcoming'
                ];

                if ($banner) {
                    $event_data['banner'] = $banner;
                }
                if ($image) {
                    $event_data['image'] = $image;
                }

                if ($this->Event_calendar_model->create($event_data)) {
                    $this->session->set_flashdata('success', 'Event created successfully.');
                    redirect('admin/events');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create event.');
                }
            }

            show_form:
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/events/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Edit event
     */
    public function edit($uid)
    {
        $event = $this->Event_calendar_model->get_by_uid($uid);
        if (!$event) {
            $this->session->set_flashdata('error', 'Event not found.');
            redirect('admin/events');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Event';
        $data['event'] = $event;
        $data['departments'] = $this->Department_model->get_all();

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Event Title', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('end_date', 'End Date', 'required');
            $this->form_validation->set_rules('location', 'Location', 'required|trim');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                // Handle banner upload
                $banner = $this->upload_image('banner');
                if ($banner === false) {
                    // Error already set in session
                    goto show_edit_form;
                }

                // Handle image upload
                $image = $this->upload_image('image');
                if ($image === false) {
                    // Error already set in session
                    goto show_edit_form;
                }

                $event_data = [
                    'title' => $this->input->post('title', TRUE),
                    'start_date' => $this->input->post('start_date', TRUE),
                    'start_time' => $this->input->post('start_time', TRUE) ?: NULL,
                    'end_date' => $this->input->post('end_date', TRUE),
                    'end_time' => $this->input->post('end_time', TRUE) ?: NULL,
                    'location' => $this->input->post('location', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'department_id' => $this->input->post('department_id', TRUE) ?: NULL,
                    'event_type' => $this->input->post('event_type', TRUE) ?: 'academic',
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'registration_required' => $this->input->post('registration_required') ? 1 : 0,
                    'visibility' => $this->input->post('visibility', TRUE) ?: 'public',
                    'status' => $this->input->post('status', TRUE) ?: 'upcoming'
                ];

                if ($banner) {
                    $event_data['banner'] = $banner;
                }
                if ($image) {
                    $event_data['image'] = $image;
                }

                if ($this->Event_calendar_model->update_by_uid($uid, $event_data)) {
                    $this->session->set_flashdata('success', 'Event updated successfully.');
                    redirect('admin/events');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update event.');
                }
            }

            show_edit_form:
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/events/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * View event details
     */
    public function view($uid)
    {
        $event = $this->Event_calendar_model->get_by_uid($uid);
        if (!$event) {
            $this->session->set_flashdata('error', 'Event not found.');
            redirect('admin/events');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Event Details';
        $data['event'] = $event;
        $data['registrations'] = $this->Event_calendar_model->get_event_registrations($event->id);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/events/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Delete event
     */
    public function delete($uid)
    {
        $event = $this->Event_calendar_model->get_by_uid($uid);
        if (!$event) {
            $this->session->set_flashdata('error', 'Event not found.');
            redirect('admin/events');
        }

        if ($this->Event_calendar_model->delete_by_uid($uid)) {
            $this->session->set_flashdata('success', 'Event deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete event.');
        }

        redirect('admin/events');
    }

    /**
     * Toggle event status
     */
    public function toggle_status($uid)
    {
        if (!$this->input->is_ajax_request()) {
            return;
        }

        $event = $this->Event_calendar_model->get_by_uid($uid);
        if (!$event) {
            echo json_encode(['status' => 'error', 'message' => 'Event not found']);
            return;
        }

        $new_status = $event->status === 'upcoming' ? 'cancelled' : 'upcoming';
        
        if ($this->Event_calendar_model->toggle_status_by_uid($uid, $new_status)) {
            echo json_encode(['status' => 'success', 'new_status' => $new_status]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
        }
    }
}
