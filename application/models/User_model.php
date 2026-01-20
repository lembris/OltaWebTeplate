<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model 
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    /**
     * Generate UUID
     */
    private function generate_uuid() {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Get active template for filtering
     */
    private function get_active_template() {
        if (function_exists('get_active_template')) {
            return get_active_template();
        }
        // Fallback for when not in frontend context
        $template = 'all';
        try {
            $this->load->helper('template');
            $template = get_active_template();
        } catch (Exception $e) {
            // Use 'all' as default
        }
        return $template;
    }

    /**
     * Get all users with pagination and theme filtering
     */
    public function get_all($limit = 50, $offset = 0)
    {
        $theme = $this->get_active_template();
        
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.is_deleted', 0);
        $this->db->where('users.role_id !=', 1); // Exclude Super Admin
        
        // Theme filtering
        $this->db->group_start();
        $this->db->where('users.template', 'all');
        $this->db->or_where('users.template', $theme);
        $this->db->group_end();
        
        $this->db->order_by('users.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Count all active users with theme filtering
     */
    public function count_users($status = null)
    {
        $theme = $this->get_active_template();
        
        $this->db->where('is_deleted', 0);
        $this->db->where('role_id !=', 1); // Exclude Super Admin
        
        // Theme filtering
        $this->db->group_start();
        $this->db->where('template', 'all');
        $this->db->or_where('template', $theme);
        $this->db->group_end();
        
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results($this->table);
    }

    /**
     * Search users with theme filtering
     */
    public function search($keyword, $limit = 50, $offset = 0)
    {
        $theme = $this->get_active_template();
        
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.is_deleted', 0);
        $this->db->where('users.role_id !=', 1); // Exclude Super Admin
        
        // Theme filtering
        $this->db->group_start();
        $this->db->where('users.template', 'all');
        $this->db->or_where('users.template', $theme);
        $this->db->group_end();
        
        $this->db->group_start();
        $this->db->like('users.full_name', $keyword);
        $this->db->or_like('users.email', $keyword);
        $this->db->or_like('users.username', $keyword);
        $this->db->group_end();
        
        $this->db->order_by('users.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Get user statistics with theme filtering
     */
    public function get_statistics()
    {
        $theme = $this->get_active_template();
        
        $stats = new stdClass();
        
        // Total with theme filter
        $this->db->where('is_deleted', 0);
        $this->db->where('role_id !=', 1);
        $this->db->group_start();
        $this->db->where('template', 'all');
        $this->db->or_where('template', $theme);
        $this->db->group_end();
        $stats->total = $this->db->count_all_results($this->table);
        
        // Active with theme filter
        $this->db->where('status', 'active');
        $this->db->where('is_deleted', 0);
        $this->db->where('role_id !=', 1);
        $this->db->group_start();
        $this->db->where('template', 'all');
        $this->db->or_where('template', $theme);
        $this->db->group_end();
        $stats->active = $this->db->count_all_results($this->table);
        
        // Inactive with theme filter
        $this->db->where('status', 'inactive');
        $this->db->where('is_deleted', 0);
        $this->db->where('role_id !=', 1);
        $this->db->group_start();
        $this->db->where('template', 'all');
        $this->db->or_where('template', $theme);
        $this->db->group_end();
        $stats->inactive = $this->db->count_all_results($this->table);
        
        // Count by role (with role names) and theme filter
        $this->db->select('roles.name as role, COUNT(*) as count');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.is_deleted', 0);
        $this->db->where('users.role_id !=', 1);
        $this->db->group_start();
        $this->db->where('users.template', 'all');
        $this->db->or_where('users.template', $theme);
        $this->db->group_end();
        $this->db->group_by('users.role_id');
        $stats->by_role = $this->db->get()->result();
        
        return $stats;
    }

    /**
     * Get user by UID
     */
    public function get_by_uid($uid)
    {
        $this->db->where('uid', $uid);
        $this->db->where('is_deleted', 0);
        return $this->db->get($this->table)->row();
    }

    /**
     * Get user by UID with role name
     */
    public function get_by_uid_with_role($uid)
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.uid', $uid);
        $this->db->where('users.is_deleted', 0);
        return $this->db->get()->row();
    }

    /**
     * Get user by ID
     */
    public function get_user($id)
    {
        $this->db->where('id', $id);
        $this->db->where('is_deleted', 0);
        return $this->db->get($this->table)->row();
    }

    /**
     * Get user by ID with role name
     */
    public function get_user_with_role($id)
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.id', $id);
        $this->db->where('users.is_deleted', 0);
        return $this->db->get()->row();
    }

    /**
     * Get user by email
     */
    public function get_user_by_email($email)
    {
        $this->db->where('email', $email);
        $this->db->where('is_deleted', 0);
        return $this->db->get($this->table)->row();
    }

    /**
     * Get user by username
     */
    public function get_user_by_username($username)
    {
        $this->db->where('username', $username);
        $this->db->where('is_deleted', 0);
        return $this->db->get($this->table)->row();
    }

    /**
     * Get users by role
     */
    public function get_users_by_role($role, $limit = 50, $offset = 0)
    {
        $theme = $this->get_active_template();
        
        $this->db->where('role', $role);
        $this->db->where('is_deleted', 0);
        $this->db->group_start();
        $this->db->where('template', 'all');
        $this->db->or_where('template', $theme);
        $this->db->group_end();
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }

    /**
     * Create new user
     */
    public function create_user($data)
    {
        $data['uid'] = $this->generate_uuid();
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    /**
     * Update user
     */
    public function update_user($id, $data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete user (soft delete)
     */
    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'is_deleted' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Restore user
     */
    public function restore_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'is_deleted' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Check if username exists
     */
    public function check_username_exists($username, $exclude_id = NULL)
    {
        $this->db->where('username', $username);
        $this->db->where('is_deleted', 0);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Check if email exists
     */
    public function check_email_exists($email, $exclude_id = NULL)
    {
        $this->db->where('email', $email);
        $this->db->where('is_deleted', 0);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Change user password
     */
    public function change_password($id, $new_password)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'password' => password_hash($new_password, PASSWORD_BCRYPT),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Update last login
     */
    public function update_last_login($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'last_login' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * User login authentication
     */
    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('status', 'active');
        $this->db->where('is_deleted', 0);
        $this->db->where('role !=', 'super_admin'); // Exclude super_admin
        $query = $this->db->get($this->table);

        if ($query->num_rows() === 1) {
            $user = $query->row();
            if (password_verify($password, $user->password)) {
                $this->update_last_login($user->id);
                return $user;
            }
        }
        return FALSE;
    }

    /**
     * Check if user is logged in
     */
    public function is_logged_in()
    {
        return $this->session->userdata('user_logged_in') === TRUE;
    }
}
