<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library('form_validation');
        $this->load->helper(['form', 'url', 'file']);
    }

    public function index()
    {
        $admin_id = $this->session->userdata('admin_id');
        $data = $this->get_admin_data();
        $data['page_title'] = 'My Profile';
        $data['admin'] = $this->Admin_model->get_admin($admin_id);
        $data['admin_avatar'] = $this->session->userdata('admin_avatar');
        $data['admin_name'] = $this->session->userdata('admin_name');
        $data['admin_role'] = $this->session->userdata('admin_role');
        $data['admin_email'] = $this->session->userdata('admin_email');

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/profile/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit()
    {
        $admin_id = $this->session->userdata('admin_id');

        if ($this->input->post()) {
            $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'full_name' => $this->input->post('full_name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                ];

                // Handle avatar upload
                if (!empty($_FILES['avatar']['name'])) {
                    $avatar_path = $this->handle_avatar_upload($admin_id);
                    if ($avatar_path !== FALSE) {
                        $data['avatar'] = $avatar_path;
                    }
                }

                if ($this->Admin_model->update_admin($admin_id, $data)) {
                    // Update session data
                    $this->session->set_userdata([
                        'admin_name' => $data['full_name'],
                        'admin_email' => $data['email']
                    ]);

                    if (isset($data['avatar'])) {
                        $this->session->set_userdata('admin_avatar', $data['avatar']);
                    }

                    $this->session->set_flashdata('success', 'Profile updated successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update profile.');
                }
                redirect('admin/profile');
            }
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Profile';
        $data['admin'] = $this->Admin_model->get_admin($admin_id);
        $data['admin_avatar'] = $this->session->userdata('admin_avatar');
        $data['admin_name'] = $this->session->userdata('admin_name');
        $data['admin_role'] = $this->session->userdata('admin_role');
        $data['admin_email'] = $this->session->userdata('admin_email');

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/profile/edit', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function change_password()
    {
        $admin_id = $this->session->userdata('admin_id');

        if ($this->input->post()) {
            $this->form_validation->set_rules('current_password', 'Current Password', 'required');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

            if ($this->form_validation->run() === TRUE) {
                $current_password = $this->input->post('current_password');
                $new_password = $this->input->post('new_password');

                // Verify current password
                if ($this->Admin_model->verify_current_password($admin_id, $current_password)) {
                    if ($this->Admin_model->change_password($admin_id, $new_password)) {
                        $this->session->set_flashdata('success', 'Password changed successfully.');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to change password.');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Current password is incorrect.');
                }
                redirect('admin/profile');
            }
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Change Password';
        $data['admin'] = $this->Admin_model->get_admin($admin_id);
        $data['admin_avatar'] = $this->session->userdata('admin_avatar');
        $data['admin_name'] = $this->session->userdata('admin_name');
        $data['admin_role'] = $this->session->userdata('admin_role');
        $data['admin_email'] = $this->session->userdata('admin_email');

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/profile/change_password', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete_avatar()
    {
        if (!$this->input->is_ajax_request()) {
            return;
        }

        $admin_id = $this->session->userdata('admin_id');
        $admin = $this->Admin_model->get_admin($admin_id);

        if ($admin && !empty($admin->avatar)) {
            $file_path = FCPATH . 'assets/images/avatars/' . basename($admin->avatar);
            
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            // Update database
            $this->Admin_model->update_admin($admin_id, ['avatar' => NULL]);

            // Update session
            $this->session->set_userdata('admin_avatar', NULL);

            echo json_encode(['status' => 'success', 'message' => 'Avatar deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No avatar to delete.']);
        }
    }

    private function handle_avatar_upload($admin_id)
    {
        // Use simple relative path like Gallery controller does
        $upload_dir = './assets/images/avatars/';
        
        // Verify directory exists and create if needed
        if (!is_dir($upload_dir)) {
            if (!@mkdir($upload_dir, 0755, TRUE)) {
                $this->session->set_flashdata('error', 'Cannot create upload directory.');
                return FALSE;
            }
        }
        
        // Configure upload settings - use * to bypass CodeIgniter's strict MIME check
        $config = array(
            'upload_path'   => $upload_dir,
            'allowed_types' => '*',  // Use * to bypass strict MIME detection
            'max_size'      => 5120, // 5MB
            'encrypt_name'  => TRUE
        );

        // Load and initialize upload library
        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('avatar')) {
            $upload_data = $this->upload->data();
            
            // Validate that the file is actually an image
            $finfo = @finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo) {
                $mime = finfo_file($finfo, $upload_data['full_path']);
                finfo_close($finfo);
                
                $allowed_mimes = array('image/jpeg', 'image/png', 'image/gif', 'image/webp');
                if (!in_array($mime, $allowed_mimes)) {
                    @unlink($upload_data['full_path']);
                    $this->session->set_flashdata('error', 'Upload failed: Invalid image file.');
                    return FALSE;
                }
            }
            
            // Delete old avatar if exists
            $admin = $this->Admin_model->get_admin($admin_id);
            if ($admin && !empty($admin->avatar)) {
                $old_path = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $admin->avatar);
                if (file_exists($old_path) && is_file($old_path)) {
                    @unlink($old_path);
                }
            }

            // Return relative path
            return 'assets/images/avatars/' . $upload_data['file_name'];
        } else {
            // Get detailed error
            $error_msg = strip_tags($this->upload->display_errors('', ''));
            $this->session->set_flashdata('error', 'Upload failed: ' . $error_msg);
            return FALSE;
        }
    }
}
