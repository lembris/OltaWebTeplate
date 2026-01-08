<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Package_model');
        $this->load->model('Blog_model');
        $this->load->model('Booking_model');
        $this->load->model('Enquiry_model');
        $this->load->model('Visitor_model');
        $this->load->model('Admission_model');
        $this->load->model('Department_model');
        $this->load->model('Faculty_staff_model');
        $this->load->model('Academic_program_model');
        $this->load->model('Event_calendar_model');
        $this->load->model('Notice_model');
        $this->load->model('Contact_model');
        $this->load->model('User_model');
    }

    /**
     * Default dashboard - redirects to operations
     */
    public function index()
    {
        redirect('admin/dashboard/operations');
    }

    /**
     * Business Operations Dashboard
     * Focus: Admissions, Academic Programs, Departments, Faculty, Events, Notices
     */
    public function operations()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Business Operations';

        // Admission Statistics
        $data['admission_stats'] = $this->Admission_model->get_statistics();
        $data['total_admissions'] = $this->Admission_model->count_admissions();
        $data['pending_admissions'] = $this->Admission_model->count_admissions('pending');
        $data['accepted_admissions'] = $this->Admission_model->count_admissions('accepted');
        $data['enrolled_admissions'] = $this->Admission_model->count_admissions('enrolled');
        $data['recent_admissions'] = $this->Admission_model->get_recent_admissions(5);

        // Academic Programs
        $data['total_programs'] = $this->Academic_program_model->count_programs();
        $data['active_programs'] = $this->Academic_program_model->count_programs('active');

        // Departments
        $data['total_departments'] = $this->Department_model->count_departments();
        $data['active_departments'] = $this->Department_model->count_departments('active');

        // Faculty & Staff
        $data['total_faculty'] = $this->Faculty_staff_model->count_all();
        $data['active_faculty'] = $this->Faculty_staff_model->count_active();

        // Events
        $data['upcoming_events'] = $this->Event_calendar_model->get_upcoming_events(5);
        $data['total_events'] = $this->Event_calendar_model->count_events();

        // Notices
        $data['recent_notices'] = $this->Notice_model->get_recent_notices(5);
        $data['total_notices'] = $this->Notice_model->count_notices();

        // Contact Messages
        $data['unread_messages'] = $this->Contact_model->count_unread();
        $data['recent_contacts'] = $this->Contact_model->get_recent_contacts(5);

        // Enquiries
        $data['total_enquiries'] = $this->Enquiry_model->count_enquiries();
        $data['new_enquiries'] = $this->Enquiry_model->count_enquiries('new');
        $data['recent_enquiries'] = $this->Enquiry_model->get_recent_enquiries(5);

        // Users
        $data['total_users'] = $this->User_model->count_users();
        $data['active_users'] = $this->User_model->count_users('active');

        // Load views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/dashboard/operations', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Analytics Dashboard
     * Focus: Visitor statistics, website analytics, trends
     */
    public function analytics()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Analytics Dashboard';

        // Total counts for quick reference
        $data['total_packages'] = $this->Package_model->count_packages();
        $data['total_blog_posts'] = $this->Blog_model->get_all_count();
        $data['total_bookings'] = $this->Booking_model->count_bookings();
        $data['total_enquiries'] = $this->Enquiry_model->count_enquiries();

        // Recent bookings (last 5)
        $data['recent_bookings'] = $this->Booking_model->get_all_bookings(5, 0);

        // Recent enquiries (last 5)
        $data['recent_enquiries'] = $this->Enquiry_model->get_recent_enquiries(5);

        // Statistics
        $data['booking_stats'] = $this->Booking_model->get_statistics();
        $data['enquiry_stats'] = $this->Enquiry_model->get_statistics();

        // Count new/pending items for badges
        $data['pending_bookings'] = $this->Booking_model->count_bookings('pending');
        $data['new_enquiries'] = $this->Enquiry_model->count_enquiries('new');

        // Visitor Statistics
        $data['visitor_stats'] = $this->Visitor_model->get_total_stats();
        $data['weekly_visitors'] = $this->Visitor_model->get_weekly_stats();
        $data['device_stats'] = $this->Visitor_model->get_device_stats();
        $data['popular_pages'] = $this->Visitor_model->get_popular_pages(5);
        $data['recent_visitors'] = $this->Visitor_model->get_recent_visitors(10);
        $data['browser_stats'] = $this->Visitor_model->get_browser_stats();
        $data['country_stats'] = $this->Visitor_model->get_country_stats(30, 10);

        // Events - Display upcoming events
        $data['upcoming_events'] = $this->Event_calendar_model->get_upcoming_events(5);

        // Load views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
