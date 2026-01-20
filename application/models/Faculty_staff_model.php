<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty_staff_model extends CI_Model {

    private $table = 'faculty_staff';

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

    public function get_all($limit = NULL, $offset = 0)
    {
        $query = $this->db->select('fs.*, d.name as department_name')
                          ->from($this->table . ' fs')
                          ->join('departments d', 'fs.department_id = d.id', 'left')
                          ->order_by('fs.last_name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get()->result();
    }

    public function count_all()
    {
        return $this->db->count_all_results($this->table);
    }

    public function get_by_id($id)
    {
        return $this->db->select('fs.*, d.name as department_name, d.id as dept_id')
                        ->from($this->table . ' fs')
                        ->join('departments d', 'fs.department_id = d.id', 'left')
                        ->where('fs.id', $id)
                        ->get()->row();
    }

    public function get_by_uid($uid)
    {
        return $this->db->select('fs.*, d.name as department_name, d.id as dept_id')
                        ->from($this->table . ' fs')
                        ->join('departments d', 'fs.department_id = d.id', 'left')
                        ->where('fs.uid', $uid)
                        ->get()->row();
    }

    public function get_by_slug($slug)
    {
        return $this->db->select('fs.*, d.name as department_name, d.id as dept_id')
                        ->from($this->table . ' fs')
                        ->join('departments d', 'fs.department_id = d.id', 'left')
                        ->where('fs.slug', $slug)
                        ->get()->row();
    }

    public function get_by_email($email)
    {
        return $this->db->select('fs.*, d.name as department_name')
                        ->from($this->table . ' fs')
                        ->join('departments d', 'fs.department_id = d.id', 'left')
                        ->where('fs.email', $email)
                        ->get()->row();
    }

    public function get_by_department($department_id, $limit = NULL, $offset = 0)
    {
        $query = $this->db->select('fs.*, d.name as department_name')
                          ->from($this->table . ' fs')
                          ->join('departments d', 'fs.department_id = d.id', 'left')
                          ->where('fs.department_id', $department_id)
                          ->order_by('fs.last_name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get()->result();
    }

    public function count_by_department($department_id)
    {
        return $this->db->where('department_id', $department_id)->count_all_results($this->table);
    }

    public function get_active($limit = NULL, $offset = 0)
    {
        $query = $this->db->select('fs.*, d.name as department_name')
                          ->from($this->table . ' fs')
                          ->join('departments d', 'fs.department_id = d.id', 'left')
                          ->where('fs.status', 'active')
                          ->order_by('fs.last_name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get()->result();
    }

    public function get_by_title($title, $limit = NULL, $offset = 0)
    {
        $query = $this->db->select('fs.*, d.name as department_name')
                          ->from($this->table . ' fs')
                          ->join('departments d', 'fs.department_id = d.id', 'left')
                          ->where('fs.title', $title)
                          ->where('fs.status', 'active')
                          ->order_by('fs.last_name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get()->result();
    }

    public function get_titles()
    {
        return $this->db->select('DISTINCT(title) as title', FALSE)
                       ->where('status', 'active')
                       ->order_by('title', 'ASC')
                       ->get($this->table)->result();
    }

    public function search($keyword, $limit = 20, $offset = 0)
    {
        $this->db->select('fs.*, d.name as department_name')
                 ->from($this->table . ' fs')
                 ->join('departments d', 'fs.department_id = d.id', 'left')
                 ->group_start()
                 ->like('fs.first_name', $keyword)
                 ->or_like('fs.last_name', $keyword)
                 ->or_like('fs.email', $keyword)
                 ->or_like('fs.specialization', $keyword)
                 ->group_end()
                 ->where('fs.status', 'active')
                 ->order_by('fs.last_name', 'ASC')
                 ->limit($limit, $offset);
        
        return $this->db->get()->result();
    }

    public function get_search_count($keyword)
    {
        $this->db->where('status', 'active')
                 ->group_start()
                 ->like('first_name', $keyword)
                 ->or_like('last_name', $keyword)
                 ->or_like('email', $keyword)
                 ->or_like('specialization', $keyword)
                 ->group_end();
        
        return $this->db->count_all_results($this->table);
    }

    public function create($data)
    {
        $data['uid'] = $this->generate_uid();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function update_by_uid($uid, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('uid', $uid)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    public function delete_by_uid($uid)
    {
        return $this->db->where('uid', $uid)->delete($this->table);
    }

    public function email_exists($email, $exclude_id = null)
    {
        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }

    public function toggle_status($id, $status)
    {
        return $this->db->where('id', $id)->update($this->table, ['status' => $status]);
    }

    public function toggle_status_by_uid($uid, $status)
    {
        return $this->db->where('uid', $uid)->update($this->table, ['status' => $status]);
    }

    /**
     * Count active faculty/staff
     */
    public function count_active()
    {
        return $this->db->where('status', 'active')->count_all_results($this->table);
    }

    /**
     * Get featured faculty/staff members (status=active AND is_featured=1)
     * Falls back to active members if is_featured column doesn't exist
     */
    public function get_featured($limit = 8, $offset = 0)
    {
        // Check if is_featured column exists
        if (!$this->db->field_exists('is_featured', $this->table)) {
            // Column doesn't exist, return empty array - caller should fallback to get_active()
            return [];
        }
        
        $query = $this->db->select('fs.*, d.name as department_name')
                          ->from($this->table . ' fs')
                          ->join('departments d', 'fs.department_id = d.id', 'left')
                          ->where('fs.status', 'active')
                          ->where('fs.is_featured', 1)
                          ->order_by('fs.last_name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get()->result();
    }
}
