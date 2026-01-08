<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Role_model');
        $this->load->library('form_validation');
        $this->load->helper(['form', 'url']);
    }

    /**
     * Get available roles for user assignment (excludes Super Admin)
     */
    private function get_available_roles()
    {
        $all_roles = $this->Role_model->get_active();
        $roles = [];
        foreach ($all_roles as $role) {
            // Exclude Super Administrator (id = 1)
            if ((int)$role->id !== 1) {
                $roles[$role->id] = $role->name;
            }
        }
        return $roles;
    }

    /**
     * List all users
     */
    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Users';
        
        // Search functionality
        $keyword = $this->input->get('keyword');
        $status_filter = $this->input->get('status');
        $role_filter = $this->input->get('role');
        
        if ($keyword) {
            $data['users'] = $this->User_model->search($keyword, 100);
            $data['keyword'] = $keyword;
        } else {
            $data['users'] = $this->User_model->get_all(100);
            $data['keyword'] = '';
        }

        // Filter by status
        if ($status_filter) {
            $data['users'] = array_filter($data['users'], function($user) use ($status_filter) {
                return $user->status === $status_filter;
            });
            $data['status_filter'] = $status_filter;
        } else {
            $data['status_filter'] = '';
        }

        // Filter by role
        if ($role_filter) {
            $data['users'] = array_filter($data['users'], function($user) use ($role_filter) {
                return (string)$user->role_id === (string)$role_filter;
            });
            $data['role_filter'] = $role_filter;
        } else {
            $data['role_filter'] = '';
        }
        
        $data['users'] = array_values($data['users']);
        $data['statistics'] = $this->User_model->get_statistics();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/users/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Create new user
     */
    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add User';
        $data['user'] = null;

        if ($this->input->post()) {
            $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
            $this->form_validation->set_rules('role', 'Role', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'trim');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email', TRUE);
                $username = $this->input->post('username', TRUE);
                
                // Check if email or username already exists
                if ($this->User_model->check_email_exists($email)) {
                    $this->session->set_flashdata('error', 'Email already exists.');
                } elseif ($this->User_model->check_username_exists($username)) {
                    $this->session->set_flashdata('error', 'Username already exists.');
                } else {
                    $user_data = [
                        'full_name' => $this->input->post('full_name', TRUE),
                        'email' => $email,
                        'username' => $username,
                        'password' => $this->input->post('password', TRUE),
                        'role_id' => $this->input->post('role', TRUE),
                        'phone' => $this->input->post('phone', TRUE),
                        'address' => $this->input->post('address', TRUE),
                        'status' => $this->input->post('status', TRUE) ?: 'active'
                    ];

                    // Handle photo upload
                    if (!empty($_FILES['photo']['name'])) {
                        $photo = $this->upload_photo();
                        if ($photo) {
                            $user_data['photo'] = $photo;
                        }
                    }

                    if ($this->User_model->create_user($user_data)) {
                        $this->session->set_flashdata('success', 'User created successfully.');
                        redirect('admin/users');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to create user.');
                    }
                }
            }
        }

        $data['roles'] = $this->get_available_roles();
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/users/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Upload user photo
     */
    private function upload_photo()
    {
        $config['upload_path'] = './assets/images/users/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;

        // Create directory if not exists
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('photo')) {
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        }
        
        return FALSE;
    }

    /**
     * View user details
     */
    public function view($uid)
    {
        $user = $this->User_model->get_by_uid_with_role($uid);
        if (!$user || (int)$user->role_id === 1) { // Exclude Super Admin (role_id = 1)
            $this->session->set_flashdata('error', 'User not found.');
            redirect('admin/users');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'View User';
        $data['user'] = $user;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/users/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Edit user
     */
    public function edit($uid)
    {
        $user = $this->User_model->get_by_uid($uid);
        if (!$user || (int)$user->role_id === 1) { // Exclude Super Admin (role_id = 1)
            $this->session->set_flashdata('error', 'Cannot edit super administrator account.');
            redirect('admin/users');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit User';
        $data['user'] = $user;

        if ($this->input->post()) {
            $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('role', 'Role', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'trim');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email', TRUE);
                $username = $this->input->post('username', TRUE);
                
                // Check if email already exists (excluding current user)
                if ($this->User_model->check_email_exists($email, $user->id)) {
                    $this->session->set_flashdata('error', 'Email already exists.');
                } elseif ($this->User_model->check_username_exists($username, $user->id)) {
                    $this->session->set_flashdata('error', 'Username already exists.');
                } else {
                    $user_data = [
                        'full_name' => $this->input->post('full_name', TRUE),
                        'email' => $email,
                        'username' => $username,
                        'role_id' => $this->input->post('role', TRUE),
                        'phone' => $this->input->post('phone', TRUE),
                        'address' => $this->input->post('address', TRUE),
                        'status' => $this->input->post('status', TRUE)
                    ];

                    // Only update password if provided
                    $password = $this->input->post('password', TRUE);
                    if (!empty($password)) {
                        $user_data['password'] = $password;
                    }

                    // Handle photo removal
                    if ($this->input->post('remove_photo') && $user->photo) {
                        $photo_path = './assets/images/users/' . $user->photo;
                        if (file_exists($photo_path)) {
                            unlink($photo_path);
                        }
                        $user_data['photo'] = NULL;
                    }
                    // Handle new photo upload
                    elseif (!empty($_FILES['photo']['name'])) {
                        $photo = $this->upload_photo();
                        if ($photo) {
                            // Delete old photo if exists
                            if ($user->photo) {
                                $old_photo_path = './assets/images/users/' . $user->photo;
                                if (file_exists($old_photo_path)) {
                                    unlink($old_photo_path);
                                }
                            }
                            $user_data['photo'] = $photo;
                        }
                    }

                    if ($this->User_model->update_user($user->id, $user_data)) {
                        $this->session->set_flashdata('success', 'User updated successfully.');
                        redirect('admin/users/view/' . $uid);
                    } else {
                        $this->session->set_flashdata('error', 'Failed to update user.');
                    }
                }
            }
        }

        $data['roles'] = $this->get_available_roles();
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/users/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Delete user
     */
    public function delete($uid)
    {
        $user = $this->User_model->get_by_uid($uid);
        if (!$user || (int)$user->role_id === 1) { // Exclude Super Admin (role_id = 1)
            $this->session->set_flashdata('error', 'Cannot delete super administrator account.');
            redirect('admin/users');
        }

        if ($this->User_model->delete_user($user->id)) {
            $this->session->set_flashdata('success', 'User deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user.');
        }

        redirect('admin/users');
    }

    /**
     * Bulk delete users
     */
    public function bulk_delete()
    {
        if (!$this->input->post()) {
            redirect('admin/users');
        }

        $uids = $this->input->post('selected_users');
        if (!$uids || !is_array($uids)) {
            $this->session->set_flashdata('error', 'No users selected.');
            redirect('admin/users');
        }

        $deleted_count = 0;
        foreach ($uids as $uid) {
            $user = $this->User_model->get_by_uid($uid);
            if ($user && (int)$user->role_id !== 1) {
                if ($this->User_model->delete_user($user->id)) {
                    $deleted_count++;
                }
            }
        }

        if ($deleted_count > 0) {
            $this->session->set_flashdata('success', $deleted_count . ' user(s) deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete users.');
        }

        redirect('admin/users');
    }
}
