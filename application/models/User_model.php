<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model 
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
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
     * Get all users with pagination (excludes super_admin - role_id = 1)
     */
    public function get_all($limit = 50, $offset = 0)
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.is_deleted', 0);
        $this->db->where('users.role_id !=', 1); // Exclude Super Admin (role_id = 1)
        $this->db->order_by('users.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Count all active users (excludes super_admin - role_id = 1)
     */
    public function count_users($status = null)
    {
        $this->db->where('is_deleted', 0);
        $this->db->where('role_id !=', 1); // Exclude Super Admin
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results($this->table);
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
        $this->db->where('role', $role);
        $this->db->where('is_deleted', 0);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }

    /**
     * Search users by name, email, or username (excludes super_admin - role_id = 1)
     */
    public function search($keyword, $limit = 50, $offset = 0)
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.is_deleted', 0);
        $this->db->where('users.role_id !=', 1); // Exclude Super Admin
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
     * Get user statistics (excludes super_admin - role_id = 1)
     */
    public function get_statistics()
    {
        $stats = new stdClass();
        $stats->total = $this->db->where('is_deleted', 0)->where('role_id !=', 1)->count_all_results($this->table);
        $stats->active = $this->db->where('status', 'active')->where('is_deleted', 0)->where('role_id !=', 1)->count_all_results($this->table);
        $stats->inactive = $this->db->where('status', 'inactive')->where('is_deleted', 0)->where('role_id !=', 1)->count_all_results($this->table);
        
        // Count by role (with role names)
        $this->db->select('roles.name as role, COUNT(*) as count');
        $this->db->from($this->table);
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->where('users.is_deleted', 0);
        $this->db->where('users.role_id !=', 1); // Exclude Super Admin
        $this->db->group_by('users.role_id');
        $stats->by_role = $this->db->get()->result();
        
        return $stats;
    }
}
