<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_model extends CI_Model {

    private $table = 'permissions';
    private $role_permission_table = 'role_permissions';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all permissions
     */
    public function get_all($limit = NULL) {
        $this->db->order_by('module', 'ASC');
        $this->db->order_by('action', 'ASC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get($this->table)->result();
    }

    /**
     * Get active permissions only
     */
    public function get_active() {
        $this->db->where('status', 'active');
        $this->db->order_by('module', 'ASC');
        $this->db->order_by('action', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get permissions by module
     */
    public function get_by_module($module) {
        $this->db->where('module', $module);
        $this->db->where('status', 'active');
        $this->db->order_by('action', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get permission by ID
     */
    public function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row();
    }

    /**
     * Get permission by slug
     */
    public function get_by_slug($slug) {
        $this->db->where('slug', $slug);
        return $this->db->get($this->table)->row();
    }

    /**
     * Create new permission
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
     * Update permission
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete permission
     */
    public function delete($id) {
        // First remove all role assignments
        $this->db->where('permission_id', $id);
        $this->db->delete($this->role_permission_table);

        // Then delete the permission
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Check if permission exists
     */
    public function exists($slug, $exclude_id = NULL) {
        $this->db->where('slug', $slug);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Get all modules with their permissions
     */
    public function get_permissions_grouped_by_module() {
        $modules = [];
        $permissions = $this->get_active();

        foreach ($permissions as $permission) {
            if (!isset($modules[$permission->module])) {
                $modules[$permission->module] = [];
            }
            $modules[$permission->module][] = $permission;
        }

        return $modules;
    }

    /**
     * Get statistics
     */
    public function get_statistics() {
        return [
            'total' => $this->db->count_all($this->table),
            'active' => $this->db->where('status', 'active')->count_all_results($this->table),
            'inactive' => $this->db->where('status', 'inactive')->count_all_results($this->table)
        ];
    }

    /**
     * Search permissions
     */
    public function search($keyword, $limit = NULL) {
        $this->db->where('(name LIKE "%' . $this->db->escape_like_str($keyword) . '%" OR slug LIKE "%' . $this->db->escape_like_str($keyword) . '%" OR description LIKE "%' . $this->db->escape_like_str($keyword) . '%")');
        $this->db->order_by('module', 'ASC');
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
