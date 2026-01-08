<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Directory_model extends CI_Model {

    private $table = 'directory';

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
        $query = $this->db->order_by('name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get($this->table)->result();
    }

    public function count_all()
    {
        return $this->db->count_all_results($this->table);
    }

    public function count_all_active()
    {
        return $this->db->where('status', 'active')->count_all_results($this->table);
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)->get($this->table)->row();
    }

    public function get_by_type($type, $limit = NULL, $offset = 0)
    {
        $query = $this->db->where('type', $type)
                          ->where('status', 'active')
                          ->order_by('name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get($this->table)->result();
    }

    public function count_by_type($type)
    {
        return $this->db->where('type', $type)->where('status', 'active')->count_all_results($this->table);
    }

    public function get_active($limit = NULL, $offset = 0)
    {
        $query = $this->db->where('status', 'active')->order_by('type', 'ASC')->order_by('name', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get($this->table)->result();
    }

    public function get_types()
    {
        return $this->db->select('DISTINCT(type) as type', FALSE)
                       ->where('status', 'active')
                       ->order_by('type', 'ASC')
                       ->get($this->table)->result();
    }

    public function search($keyword, $limit = 20, $offset = 0, $active_only = false)
    {
        $this->db->group_start()
                 ->like('name', $keyword)
                 ->or_like('email', $keyword)
                 ->or_like('phone', $keyword)
                 ->or_like('location', $keyword)
                 ->or_like('contact_person', $keyword)
                 ->group_end();
        
        if ($active_only) {
            $this->db->where('status', 'active');
        }
        
        $this->db->order_by('name', 'ASC')
                 ->limit($limit, $offset);
        
        return $this->db->get($this->table)->result();
    }

    public function get_search_count($keyword)
    {
        $this->db->group_start()
                 ->like('name', $keyword)
                 ->or_like('email', $keyword)
                 ->or_like('phone', $keyword)
                 ->or_like('location', $keyword)
                 ->or_like('contact_person', $keyword)
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

    public function toggle_status($id, $status)
    {
        return $this->db->where('id', $id)->update($this->table, ['status' => $status]);
    }

    public function toggle_status_by_uid($uid, $status)
    {
        return $this->db->where('uid', $uid)->update($this->table, ['status' => $status]);
    }
}
