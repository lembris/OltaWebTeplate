<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_auth extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        if ($this->session->userdata('user_logged_in')) {
            redirect('user/dashboard');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === TRUE) {
                $username = $this->input->post('username', TRUE);
                $password = $this->input->post('password');

                $user = $this->User_model->login($username, $password);

                if ($user) {
                    $session_data = [
                        'user_logged_in' => TRUE,
                        'user_id' => $user->id,
                        'user_name' => $user->full_name,
                        'user_username' => $user->username,
                        'user_email' => $user->email,
                        'user_role' => $user->role,
                        'user_photo' => $user->photo
                    ];
                    $this->session->set_userdata($session_data);

                    $redirect_url = $this->session->userdata('redirect_after_login');
                    if ($redirect_url) {
                        $this->session->unset_userdata('redirect_after_login');
                        redirect($redirect_url);
                    }
                    redirect('user/dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Invalid username or password.');
                }
            }
        }

        $data['title'] = 'User Login';
        $data['current_page_name'] = 'Login';
        $data['main_page'] = 'Login';
        $data['page_title'] = 'Login - TNA CARE';
        $data['meta_description'] = 'Login to access your account.';
        
        $data = array_merge($this->get_common_data(), $data);
        
        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        $this->load->view('auth/login', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    public function logout()
    {
        $session_data = [
            'user_logged_in',
            'user_id',
            'user_name',
            'user_username',
            'user_email',
            'user_role',
            'user_photo'
        ];
        $this->session->unset_userdata($session_data);
        $this->session->set_flashdata('success', 'You have been logged out successfully.');
        redirect('auth/login');
    }

    public function forgot_password()
    {
        if ($this->session->userdata('user_logged_in')) {
            redirect('user/dashboard');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email', TRUE);
                $user = $this->User_model->get_user_by_email($email);

                if ($user) {
                    $this->session->set_flashdata('success', 'If the email exists, password reset instructions have been sent.');
                } else {
                    $this->session->set_flashdata('success', 'If the email exists, password reset instructions have been sent.');
                }
                redirect('auth/forgot_password');
            }
        }

        $data['title'] = 'Forgot Password';
        $data['current_page_name'] = 'Forgot Password';
        $data['main_page'] = 'Login';
        $data['page_title'] = 'Forgot Password - TNA CARE';
        $data['meta_description'] = 'Reset your password.';
        
        $data = array_merge($this->get_common_data(), $data);
        
        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        $this->load->view('auth/forgot_password', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    private function get_common_data()
    {
        $this->load->model('Settings_model');
        $this->load->helper('template');
        
        $template = get_active_template();
        
        $data = [];
        $data['site_name'] = $this->Settings_model->get('site_name', $template) ?: 'TNA CARE';
        $data['site_logo'] = $this->Settings_model->get('site_logo', $template) ?: 'assets/templates/' . $template . '/img/logo.png';
        $data['site_email'] = $this->Settings_model->get('site_email', $template) ?: 'info@tnacare.com';
        $data['phone_number'] = $this->Settings_model->get('phone_number', $template) ?: '+255 700 000 000';
        $data['address'] = $this->Settings_model->get('address', $template) ?: 'Dar es Salaam, Tanzania';
        $data['facebook'] = $this->Settings_model->get('facebook_url', $template);
        $data['instagram'] = $this->Settings_model->get('instagram_url', $template);
        $data['youtube'] = $this->Settings_model->get('youtube_url', $template);
        $data['linkedin'] = $this->Settings_model->get('linkedin_url', $template);
        $data['twitter'] = $this->Settings_model->get('twitter_url', $template);
        $data['whatsapp'] = $this->Settings_model->get('whatsapp_number', $template);
        
        return $data;
    }
}
