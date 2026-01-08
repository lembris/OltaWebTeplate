<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {

    private $table = 'departments';

    public function __construct()
    {
        parent::__construct();
    }

    private function generate_uid()
    {
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
     * Get all departments
     */
    public function get_all($limit = NULL, $offset = 0)
    {
        $query = $this->db->order_by('name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get($this->table)->result();
    }

    /**
     * Get total departments count
     */
    public function count_all()
    {
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get department by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get department by code
     */
    public function get_by_code($code)
    {
        return $this->db->where('code', $code)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get department by UID
     */
    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get department by name
     */
    public function get_by_name($name)
    {
        return $this->db->where('name', $name)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Create department
     */
    public function create($data)
    {
        $data['uid'] = $this->generate_uid();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update department
     */
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('id', $id)
                       ->update($this->table, $data);
    }

    /**
     * Update department by UID
     */
    public function update_by_uid($uid, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('uid', $uid)
                       ->update($this->table, $data);
    }

    /**
     * Delete department
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)
                       ->delete($this->table);
    }

    /**
     * Delete department by UID
     */
    public function delete_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->delete($this->table);
    }

    /**
     * Check if code exists
     */
    public function code_exists($code, $exclude_id = null)
    {
        $this->db->where('code', $code);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Get departments with faculty count
     */
    public function get_with_faculty_count()
    {
        return $this->db->select('d.*, COUNT(f.id) as faculty_count')
                       ->from($this->table . ' d')
                       ->join('faculty f', 'f.department_id = d.id', 'left')
                       ->group_by('d.id')
                       ->order_by('d.name', 'ASC')
                       ->get()
                       ->result();
    }

    /**
     * Get active departments
     */
    public function get_active($limit = NULL, $offset = 0)
    {
        $query = $this->db->where('status', 'active')
                         ->order_by('name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get($this->table)->result();
    }

    /**
     * Toggle department status
     */
    public function toggle_status($id, $status)
    {
        return $this->db->where('id', $id)
                       ->update($this->table, ['status' => $status]);
    }

    /**
     * Toggle department status by UID
     */
    public function toggle_status_by_uid($uid, $status)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    /**
     * Search departments
     */
    public function search($keyword, $limit = 20, $offset = 0)
    {
        $this->db->group_start()
                 ->like('name', $keyword)
                 ->or_like('code', $keyword)
                 ->or_like('description', $keyword)
                 ->group_end();
        
        return $this->db->order_by('name', 'ASC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get search count
     */
    public function get_search_count($keyword)
    {
        $this->db->group_start()
                 ->like('name', $keyword)
                 ->or_like('code', $keyword)
                 ->or_like('description', $keyword)
                 ->group_end();
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Count departments by status
     */
    public function count_departments($status = null)
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results($this->table);
    }
}
