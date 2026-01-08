<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === TRUE) {
                $username = $this->input->post('username', TRUE);
                $password = $this->input->post('password');

                $admin = $this->Admin_model->login($username, $password);

                if ($admin) {
                    $session_data = [
                        'admin_logged_in' => TRUE,
                        'admin_id' => $admin->id,
                        'admin_name' => $admin->full_name,
                        'admin_username' => $admin->username,
                        'admin_role' => $admin->role,
                        'admin_email' => $admin->email,
                        'admin_avatar' => $admin->avatar
                    ];
                    $this->session->set_userdata($session_data);

                    $redirect_url = $this->session->userdata('redirect_after_login');
                    if ($redirect_url) {
                        $this->session->unset_userdata('redirect_after_login');
                        redirect($redirect_url);
                    }
                    redirect('admin/dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Invalid username or password.');
                }
            }
        }

        $data['title'] = 'Admin Login';
        $this->load->view('admin/auth/login', $data);
    }

    public function logout()
    {
        $session_data = [
            'admin_logged_in',
            'admin_id',
            'admin_name',
            'admin_username',
            'admin_role',
            'admin_email',
            'admin_avatar'
        ];
        $this->session->unset_userdata($session_data);
        $this->session->set_flashdata('success', 'You have been logged out successfully.');
        redirect('admin/auth/login');
    }

    public function forgot_password()
    {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email', TRUE);
                $admin = $this->Admin_model->get_admin_by_email($email);

                if ($admin) {
                    $this->session->set_flashdata('success', 'If the email exists, password reset instructions have been sent.');
                } else {
                    $this->session->set_flashdata('success', 'If the email exists, password reset instructions have been sent.');
                }
                redirect('admin/auth/forgot_password');
            }
        }

        $data['title'] = 'Forgot Password';
        $this->load->view('admin/auth/forgot_password', $data);
    }
}
