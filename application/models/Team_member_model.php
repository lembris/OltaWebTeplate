<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_member_model extends CI_Model {

    private $table = 'team_members';

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
        $query = $this->db->order_by('display_order', 'ASC')
                          ->order_by('id', 'DESC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get($this->table)->result();
    }

    public function count_all($theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start();
        $this->db->where('template', 'all');
        $this->db->or_where('template', $theme);
        $this->db->group_end();
        
        return $this->db->count_all_results($this->table);
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)->get($this->table)->row();
    }

    public function get_by_slug($slug)
    {
        return $this->db->where('slug', $slug)->get($this->table)->row();
    }

    public function get_active($limit = NULL, $offset = 0)
    {
        $query = $this->db->where('status', 'active')
                          ->order_by('display_order', 'ASC')
                          ->order_by('id', 'DESC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get($this->table)->result();
    }

    /**
     * Get all members filtered by theme (admin) - shows content for active theme + 'all'
     */
    public function get_all_by_theme($limit = 100, $offset = 0, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        return $this->db->order_by('display_order', 'ASC')
                       ->order_by('id', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function get_by_template($template, $limit = NULL, $offset = 0)
    {
        $this->db->where('status', 'active')
                 ->group_start()
                    ->where('template', 'all')
                    ->or_where('template', $template)
                 ->group_end()
                 ->order_by('is_featured', 'DESC')
                 ->order_by('display_order', 'ASC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result();
    }

    public function get_featured($limit = 8, $offset = 0)
    {
        $query = $this->db->where('status', 'active')
                          ->where('is_featured', 1)
                          ->order_by('display_order', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get($this->table)->result();
    }

    public function get_by_type($type, $limit = NULL, $offset = 0)
    {
        $query = $this->db->where('member_type', $type)
                          ->where('status', 'active')
                          ->order_by('display_order', 'ASC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get($this->table)->result();
    }

    public function get_types()
    {
        return $this->db->select('DISTINCT(member_type) as type', FALSE)
                       ->where('status', 'active')
                       ->where('member_type IS NOT NULL AND member_type != ""', NULL, FALSE)
                       ->order_by('member_type', 'ASC')
                       ->get($this->table)->result();
    }

    public function search($keyword, $limit = 20, $offset = 0)
    {
        $this->db->group_start()
                 ->like('first_name', $keyword)
                 ->or_like('last_name', $keyword)
                 ->or_like('email', $keyword)
                 ->or_like('title', $keyword)
                 ->or_like('specialization', $keyword)
                 ->group_end()
                 ->where('status', 'active')
                 ->order_by('last_name', 'ASC')
                 ->limit($limit, $offset);
        
        return $this->db->get($this->table)->result();
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

    public function toggle_featured_by_uid($uid, $is_featured)
    {
        return $this->db->where('uid', $uid)->update($this->table, ['is_featured' => $is_featured]);
    }

    public function count_active()
    {
        return $this->db->where('status', 'active')->count_all_results($this->table);
    }

    public function slug_exists($slug, $exclude_uid = null)
    {
        $this->db->where('slug', $slug);
        if ($exclude_uid) {
            $this->db->where('uid !=', $exclude_uid);
        }
        return $this->db->count_all_results($this->table) > 0;
    }
}
