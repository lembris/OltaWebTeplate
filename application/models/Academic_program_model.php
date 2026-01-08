<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Academic_program_model extends CI_Model {

    private $table = 'academic_programs';
    private $courses_table = 'program_courses';

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
        $query = $this->db->select('ap.*, d.name as department_name')
                          ->from($this->table . ' ap')
                          ->join('departments d', 'ap.department_id = d.id', 'left')
                          ->order_by('ap.name', 'ASC');
        
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
        return $this->db->select('ap.*, d.name as department_name, d.id as dept_id')
                        ->from($this->table . ' ap')
                        ->join('departments d', 'ap.department_id = d.id', 'left')
                        ->where('ap.id', $id)
                        ->get()->row();
    }

    public function get_by_uid($uid)
    {
        return $this->db->select('ap.*, d.name as department_name, d.id as dept_id')
                        ->from($this->table . ' ap')
                        ->join('departments d', 'ap.department_id = d.id', 'left')
                        ->where('ap.uid', $uid)
                        ->get()->row();
    }

    public function get_by_code($code)
    {
        return $this->db->select('ap.*, d.name as department_name')
                        ->from($this->table . ' ap')
                        ->join('departments d', 'ap.department_id = d.id', 'left')
                        ->where('ap.code', $code)
                        ->get()->row();
    }

    public function get_by_department($department_id, $limit = NULL, $offset = 0, $theme = null)
    {
        // Note: theme parameter is accepted for API consistency but not used
        // as academic_programs table doesn't have theme column yet
        $query = $this->db->select('ap.*, d.name as department_name')
                          ->from($this->table . ' ap')
                          ->join('departments d', 'ap.department_id = d.id', 'left')
                          ->where('ap.department_id', $department_id)
                          ->where('ap.status', 'active')
                          ->order_by('ap.name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get()->result();
    }

    public function count_by_department($department_id)
    {
        return $this->db->where('department_id', $department_id)->count_all_results($this->table);
    }

    public function get_by_level($level, $limit = NULL, $offset = 0, $theme = null)
    {
        // Note: theme parameter is accepted for API consistency but not used
        // as academic_programs table doesn't have theme column yet
        $query = $this->db->select('ap.*, d.name as department_name')
                          ->from($this->table . ' ap')
                          ->join('departments d', 'ap.department_id = d.id', 'left')
                          ->where('ap.level', $level)
                          ->where('ap.status', 'active')
                          ->order_by('ap.name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get()->result();
    }

    /**
     * Get related programs (same department)
     */
    public function get_related($program_id, $limit = 3)
    {
        return $this->db->select('ap.*, d.name as department_name')
                        ->from($this->table . ' ap')
                        ->join('departments d', 'ap.department_id = d.id', 'left')
                        ->where('ap.id !=', $program_id)
                        ->where('ap.status', 'active')
                        ->order_by('ap.name', 'ASC')
                        ->limit($limit)
                        ->get()
                        ->result();
    }

    public function get_active($limit = NULL, $offset = 0, $theme = null)
    {
        // Note: theme parameter is accepted for API consistency but not used
        // as academic_programs table doesn't have theme column yet
        $query = $this->db->select('ap.*, d.name as department_name')
                          ->from($this->table . ' ap')
                          ->join('departments d', 'ap.department_id = d.id', 'left')
                          ->where('ap.status', 'active')
                          ->order_by('ap.name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get()->result();
    }

    public function get_featured($limit = 10)
    {
        return $this->db->select('ap.*, d.name as department_name')
                        ->from($this->table . ' ap')
                        ->join('departments d', 'ap.department_id = d.id', 'left')
                        ->where('ap.status', 'active')
                        ->limit($limit)
                        ->get()->result();
    }

    public function search($keyword, $limit = 20, $offset = 0, $theme = null)
    {
        // Note: theme parameter is accepted for API consistency but not used
        // as academic_programs table doesn't have theme column yet
        $this->db->select('ap.*, d.name as department_name')
                 ->from($this->table . ' ap')
                 ->join('departments d', 'ap.department_id = d.id', 'left')
                 ->group_start()
                 ->like('ap.name', $keyword)
                 ->or_like('ap.code', $keyword)
                 ->or_like('ap.description', $keyword)
                 ->group_end()
                 ->where('ap.status', 'active')
                 ->order_by('ap.name', 'ASC')
                 ->limit($limit, $offset);
        
        return $this->db->get()->result();
    }

    public function get_search_count($keyword)
    {
        $this->db->group_start()
                 ->like('name', $keyword)
                 ->or_like('code', $keyword)
                 ->or_like('description', $keyword)
                 ->group_end()
                 ->where('status', 'active');
        
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

    public function code_exists($code, $exclude_id = null)
    {
        $this->db->where('code', $code);
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
     * Courses functions
     */
    public function get_program_courses($program_id)
    {
        return $this->db->where('program_id', $program_id)
                        ->order_by('semester', 'ASC')
                        ->order_by('course_name', 'ASC')
                        ->get($this->courses_table)->result();
    }

    public function get_course_by_id($course_id)
    {
        return $this->db->where('id', $course_id)->get($this->courses_table)->row();
    }

    public function get_course_by_uid($uid)
    {
        return $this->db->where('uid', $uid)->get($this->courses_table)->row();
    }

    public function add_course($data)
    {
        $data['uid'] = $this->generate_uid();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert($this->courses_table, $data);
    }

    public function update_course($course_id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $course_id)->update($this->courses_table, $data);
    }

    public function delete_course($course_id)
    {
        return $this->db->where('id', $course_id)->delete($this->courses_table);
    }

    public function delete_course_by_uid($uid)
    {
        return $this->db->where('uid', $uid)->delete($this->courses_table);
    }

    /**
     * Count programs by status
     */
    public function count_programs($status = null)
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results($this->table);
    }
}
