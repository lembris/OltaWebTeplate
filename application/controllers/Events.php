<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Event_calendar_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('theme');
        $this->load->helper('template');
        $this->active_theme = get_active_template();
    }

    /**
     * List upcoming events
     */
    public function index()
    {
        $data = $this->get_common_data();
        $data['main_page'] = 'Events';
        $data['current_page_name'] = 'Events';
        $data['page_title'] = 'Events';
        
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $data['events'] = $this->Event_calendar_model->get_upcoming($limit, $offset);
        $data['featured'] = $this->Event_calendar_model->get_featured(5);
        $data['total'] = $this->Event_calendar_model->count_upcoming();
        
        // Add dynamic event type colors from active theme
        $data['event_colors'] = get_event_type_colors();
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('events', $data);
        load_template_view('footer', $data);
    }

    /**
     * View single event by UID
     */
    public function view($uid = null)
    {
        if (!$uid) {
            show_404();
        }

        $data = $this->get_common_data();
        $data['event'] = $this->Event_calendar_model->get_by_uid($uid);
        
        if (!$data['event']) {
            show_404();
        }

        $data['registrations_count'] = $this->Event_calendar_model->count_registrations($data['event']->id);
        $data['page_title'] = $data['event']->title;
        $data['current_page_name'] = $data['event']->title;
        $data['main_page'] = 'Events';
        
        // Add dynamic event type colors from active theme
        $data['event_colors'] = get_event_type_colors();
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('event-detail', $data);
        load_template_view('footer', $data);
    }

    /**
     * Filter by type
     */
    public function by_type($type = null)
    {
        if (!$type) {
            show_404();
        }

        $data = $this->get_common_data();
        $data['main_page'] = 'Events';
        $data['event_type'] = $type;
        $data['page_title'] = 'Events - ' . ucfirst($type);
        $data['current_page_name'] = 'Events - ' . ucfirst($type);
        
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $data['events'] = $this->Event_calendar_model->get_by_type($type, $limit, $offset);
        $data['total'] = $this->Event_calendar_model->count_by_type($type);
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('events', $data);
        load_template_view('footer', $data);
    }

    /**
     * Search events
     */
    public function search()
    {
        $data = $this->get_common_data();
        
        $keyword = $this->input->get('q');
        
        if (!$keyword || strlen($keyword) < 2) {
            redirect('events');
        }

        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $data['results'] = $this->Event_calendar_model->search($keyword, $limit, $offset);
        $data['keyword'] = $keyword;
        $data['main_page'] = 'Events';
        $data['current_page_name'] = 'Search Results';
        $data['page_title'] = 'Event Search: ' . $keyword;
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('events-search', $data);
        load_template_view('footer', $data);
    }

    /**
     * Register for event by UID
     */
    public function register($uid = null)
    {
        if (!$uid) {
            show_404();
        }

        $event = $this->Event_calendar_model->get_by_uid($uid);
        if (!$event || !$event->registration_required) {
            show_404();
        }

        $data = $this->get_common_data();
        $data['main_page'] = 'Events';
        $data['page_title'] = 'Register for ' . $event->title;
        $data['current_page_name'] = 'Event Registration';
        $data['event'] = $event;
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
            $this->form_validation->set_rules('phone', 'Phone', 'trim');
            $this->form_validation->set_rules('affiliation', 'Affiliation', 'trim');

            if ($this->form_validation->run() === FALSE) {
                $data['errors'] = validation_errors();
                load_template_view('header', $data);
                load_template_view('navigation', $data);
                load_template_page('event-register', $data);
                load_template_view('footer', $data);
                return;
            }

            // Check if email already registered
            if ($this->Event_calendar_model->check_email_registered($event->id, $this->input->post('email'))) {
                $data['message'] = 'This email is already registered for this event.';
                load_template_view('header', $data);
                load_template_view('navigation', $data);
                load_template_page('event-register', $data);
                load_template_view('footer', $data);
                return;
            }

            // Register
            $registration = array(
                'event_id' => $event->id,
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'affiliation' => $this->input->post('affiliation')
            );

            if ($this->Event_calendar_model->register_for_event($registration)) {
                $this->session->set_flashdata('success', 'Successfully registered for the event!');
                redirect('events/view/' . $uid);
            } else {
                $data['error'] = 'Registration failed. Please try again.';
                load_template_view('header', $data);
                load_template_view('navigation', $data);
                load_template_page('event-register', $data);
                load_template_view('footer', $data);
            }
        } else {
            load_template_view('header', $data);
            load_template_view('navigation', $data);
            load_template_page('event-register', $data);
            load_template_view('footer', $data);
        }
    }

    /**
     * Calendar view
     */
    public function calendar()
    {
        $data = $this->get_common_data();
        $data['main_page'] = 'Events';
        $data['page_title'] = 'Events Calendar';
        $data['current_page_name'] = 'Events Calendar';
        
        $year = $this->input->get('year') ?: date('Y');
        $month = $this->input->get('month') ?: date('m');

        $start = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
        $end = date('Y-m-t', strtotime($start));

        $data['events'] = $this->Event_calendar_model->get_by_date_range($start, $end);
        $data['year'] = $year;
        $data['month'] = $month;
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('events-calendar', $data);
        load_template_view('footer', $data);
    }
}
