<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Role_model');
        $this->load->model('Permission_model');
        $this->load->library('form_validation');
        $this->load->helper(['form', 'url']);
    }

    /**
     * List all roles
     */
    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Roles';
        
        // Search functionality
        $keyword = $this->input->get('keyword');
        
        if ($keyword) {
            $data['roles'] = $this->Role_model->search($keyword, 100);
            $data['keyword'] = $keyword;
        } else {
            $data['roles'] = $this->Role_model->get_all(100);
            $data['keyword'] = '';
        }
        
        // Filter out Super Administrator role (id = 1)
        $data['roles'] = array_filter($data['roles'], function($role) {
            return (int)$role->id !== 1;
        });
        $data['roles'] = array_values($data['roles']);
        
        $data['statistics'] = $this->Role_model->get_statistics();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/roles/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Create new role
     */
    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add Role';
        $data['role'] = null;
        $data['permissions'] = $this->Permission_model->get_permissions_grouped_by_module();
        $data['selected_permissions'] = [];

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Role Name', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $name = $this->input->post('name', TRUE);
                
                if ($this->Role_model->exists($name)) {
                    $this->session->set_flashdata('error', 'Role with this name already exists.');
                } else {
                    $role_data = [
                        'name' => $name,
                        'description' => $this->input->post('description', TRUE),
                        'color' => $this->input->post('color', TRUE) ?: '#0d6efd',
                        'is_system_role' => 0,
                        'status' => 'active'
                    ];

                    $role_id = $this->Role_model->create($role_data);

                    if ($role_id) {
                        // Assign permissions
                        $permissions = $this->input->post('permissions');
                        if ($permissions && is_array($permissions)) {
                            $this->Role_model->assign_permissions($role_id, $permissions);
                        }

                        $this->session->set_flashdata('success', 'Role created successfully.');
                        redirect('admin/roles');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to create role.');
                    }
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/roles/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Edit role
     */
    public function edit($uid)
    {
        $role = $this->Role_model->get_by_uid($uid);

        if (!$role || (int)$role->id === 1) { // Prevent editing Super Admin role
            show_404();
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Role';
        $data['role'] = $role;
        $data['permissions'] = $this->Permission_model->get_permissions_grouped_by_module();
        $data['selected_permissions'] = $this->Role_model->get_permission_ids($role->id);

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Role Name', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $name = $this->input->post('name', TRUE);
                
                if ($this->Role_model->exists($name, $role->id)) {
                    $this->session->set_flashdata('error', 'Role with this name already exists.');
                } else {
                    // Don't allow editing system roles
                    if ($role->is_system_role) {
                        $this->session->set_flashdata('error', 'System roles cannot be edited.');
                        redirect('admin/roles/edit/' . $uid);
                        return;
                    }

                    $role_data = [
                        'name' => $name,
                        'description' => $this->input->post('description', TRUE),
                        'color' => $this->input->post('color', TRUE) ?: '#0d6efd',
                    ];

                    if ($this->Role_model->update($role->id, $role_data)) {
                        // Update permissions
                        $permissions = $this->input->post('permissions');
                        if ($permissions && is_array($permissions)) {
                            $this->Role_model->assign_permissions($role->id, $permissions);
                        }

                        $this->session->set_flashdata('success', 'Role updated successfully.');
                        redirect('admin/roles');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to update role.');
                    }
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/roles/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * View role details
     */
    public function view($uid)
    {
        $role = $this->Role_model->get_by_uid($uid);

        if (!$role || (int)$role->id === 1) { // Prevent viewing Super Admin role
            show_404();
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Role Details';
        $data['role'] = $role;
        $data['permissions'] = $this->Role_model->get_permissions($role->id);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/roles/view', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Delete role
     */
    public function delete($uid)
    {
        $role = $this->Role_model->get_by_uid($uid);

        if (!$role || (int)$role->id === 1) { // Prevent deleting Super Admin role
            echo json_encode(['success' => FALSE, 'message' => 'Role not found']);
            return;
        }

        if ($role->is_system_role) {
            echo json_encode(['success' => FALSE, 'message' => 'System roles cannot be deleted']);
            return;
        }

        if ($this->Role_model->delete($role->id)) {
            echo json_encode(['success' => TRUE, 'message' => 'Role deleted successfully']);
        } else {
            echo json_encode(['success' => FALSE, 'message' => 'Failed to delete role']);
        }
    }

    /**
     * Manage permissions
     */
    public function permissions()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Permissions';
        $data['permissions_grouped'] = $this->Permission_model->get_permissions_grouped_by_module();
        $data['statistics'] = $this->Permission_model->get_statistics();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/roles/permissions', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
