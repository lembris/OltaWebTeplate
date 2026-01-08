<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {

    private $table = 'roles';
    private $permission_table = 'permissions';
    private $role_permission_table = 'role_permissions';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all roles
     */
    public function get_all($limit = NULL) {
        $this->db->order_by('id', 'ASC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get($this->table)->result();
    }

    /**
     * Get active roles only
     */
    public function get_active() {
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get role by ID
     */
    public function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row();
    }

    /**
     * Get role by UID
     */
    public function get_by_uid($uid) {
        $this->db->where('uid', $uid);
        return $this->db->get($this->table)->row();
    }

    /**
     * Get role by name
     */
    public function get_by_name($name) {
        $this->db->where('name', $name);
        return $this->db->get($this->table)->row();
    }

    /**
     * Create new role
     */
    public function create($data) {
        $data['uid'] = $this->generate_uuid();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    /**
     * Update role
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete role
     */
    public function delete($id) {
        // Don't allow deletion of system roles
        $role = $this->get_by_id($id);
        if ($role && $role->is_system_role) {
            return FALSE;
        }

        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Check if role exists
     */
    public function exists($name, $exclude_id = NULL) {
        $this->db->where('name', $name);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Assign permissions to role
     */
    public function assign_permissions($role_id, $permission_ids) {
        // Delete existing permissions
        $this->db->where('role_id', $role_id);
        $this->db->delete($this->role_permission_table);

        // Insert new permissions
        if (is_array($permission_ids) && !empty($permission_ids)) {
            foreach ($permission_ids as $permission_id) {
                $this->db->insert($this->role_permission_table, [
                    'role_id' => $role_id,
                    'permission_id' => $permission_id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            return TRUE;
        }
        return TRUE;
    }

    /**
     * Get permissions for a role
     */
    public function get_permissions($role_id) {
        $this->db->select('p.*');
        $this->db->from($this->permission_table . ' p');
        $this->db->join($this->role_permission_table . ' rp', 'p.id = rp.permission_id');
        $this->db->where('rp.role_id', $role_id);
        $this->db->order_by('p.module', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get permission IDs for a role
     */
    public function get_permission_ids($role_id) {
        $this->db->select('permission_id');
        $this->db->where('role_id', $role_id);
        $result = $this->db->get($this->role_permission_table)->result();
        return array_map(function($item) { return $item->permission_id; }, $result);
    }

    /**
     * Get statistics
     */
    public function get_statistics() {
        return [
            'total' => $this->db->count_all($this->table),
            'active' => $this->db->where('status', 'active')->count_all_results($this->table),
            'inactive' => $this->db->where('status', 'inactive')->count_all_results($this->table),
            'system_roles' => $this->db->where('is_system_role', 1)->count_all_results($this->table),
            'custom_roles' => $this->db->where('is_system_role', 0)->count_all_results($this->table)
        ];
    }

    /**
     * Search roles
     */
    public function search($keyword, $limit = NULL) {
        $this->db->where('(name LIKE "%' . $this->db->escape_like_str($keyword) . '%" OR description LIKE "%' . $this->db->escape_like_str($keyword) . '%")');
        $this->db->order_by('name', 'ASC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get($this->table)->result();
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
}
