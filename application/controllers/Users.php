<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller 
{
    protected $restricted_methods = ['users', 'settings', 'admin_users', 'roles', 'permissions'];
    protected $public_methods = ['auth', 'login', 'logout', 'forgot_password'];
    protected $restricted_urls = ['users', 'settings'];
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form', 'template']);
    }

    public function _remap($method, $params = [])
    {
        // Allow public methods without login
        if (in_array($method, $this->public_methods) || 
            ($method === 'auth' && isset($params[0]) && in_array($params[0], ['login', 'logout', 'forgot_password']))) {
            if ($method === 'auth') {
                $action = isset($params[0]) ? $params[0] : 'login';
                if ($action === 'login') {
                    $this->login();
                } elseif ($action === 'forgot_password') {
                    $this->forgot_password();
                } elseif ($action === 'logout') {
                    $this->logout();
                }
            } else {
                $this->$method();
            }
            return;
        }
        
        // Check if user is logged in for other methods
        if (!$this->session->userdata('user_logged_in')) {
            redirect('users/auth/login');
            return;
        }
        
        // Block access to restricted URLs
        if (in_array($method, $this->restricted_urls)) {
            show_error('You do not have permission to access this page.', 403);
            return;
        }
        
        // Block access to restricted methods
        if (in_array($method, $this->restricted_methods)) {
            show_error('You do not have permission to access this page.', 403);
            return;
        }
        
        // Redirect all other methods to admin
        $admin_path = 'admin/' . $method;
        if (!empty($params)) {
            $admin_path .= '/' . implode('/', $params);
        }
        redirect($admin_path);
    }

    public function login()
    {
        if ($this->session->userdata('user_logged_in')) {
            redirect('admin/dashboard');
            return;
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

                    redirect('admin/dashboard');
                    return;
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
        
        $this->load->model('Settings_model');
        $template = get_active_template();
        
        $data['site_name'] = $this->Settings_model->get('site_name', $template) ?: 'TNA CARE';
        $data['site_logo'] = $this->Settings_model->get('site_logo', $template) ?: 'assets/templates/' . $template . '/img/logo.png';
        $data['site_email'] = $this->Settings_model->get('site_email', $template) ?: 'info@tnacare.com';
        $data['phone_number'] = $this->Settings_model->get('phone_number', $template) ?: '+255 700 000 000';
        $data['facebook'] = $this->Settings_model->get('facebook_url', $template);
        $data['instagram'] = $this->Settings_model->get('instagram_url', $template);
        $data['youtube'] = $this->Settings_model->get('youtube_url', $template);
        $data['linkedin'] = $this->Settings_model->get('linkedin_url', $template);
        
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        $this->load->view('auth/user_login', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    private function logout()
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
        redirect('users/auth/login');
    }

    private function forgot_password()
    {
        if ($this->session->userdata('user_logged_in')) {
            redirect('admin/dashboard');
            return;
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
                redirect('users/auth/forgot_password');
                return;
            }
        }

        $data['title'] = 'Forgot Password';
        $data['current_page_name'] = 'Forgot Password';
        $data['main_page'] = 'Login';
        $data['page_title'] = 'Forgot Password - TNA CARE';
        $data['meta_description'] = 'Reset your password.';
        
        $this->load->model('Settings_model');
        $template = get_active_template();
        
        $data['site_name'] = $this->Settings_model->get('site_name', $template) ?: 'TNA CARE';
        $data['site_logo'] = $this->Settings_model->get('site_logo', $template) ?: 'assets/templates/' . $template . '/img/logo.png';
        
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        $this->load->view('auth/user_forgot_password', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }
}
