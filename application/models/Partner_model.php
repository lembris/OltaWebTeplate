<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partner_model extends CI_Model {

    private $table = 'partners';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_active($limit = 10, $offset = 0)
    {
        $theme = get_active_template();
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        return $this->db->where('status', 'active')
                       ->order_by('display_order', 'ASC')
                       ->order_by('id', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

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
                       ->order_by('type', 'ASC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function get_all_count_by_theme($theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        return $this->db->count_all_results($this->table);
    }

    public function get_by_type($type, $limit = 10, $offset = 0)
    {
        return $this->db->where('type', $type)
                       ->where('status', 'active')
                       ->order_by('display_order', 'ASC')
                       ->order_by('id', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function get_all_by_type($type, $order_by = 'display_order', $order = 'ASC')
    {
        return $this->db->where('type', $type)
                       ->where('status', 'active')
                       ->order_by($order_by, $order)
                       ->get($this->table)
                       ->result();
    }

    public function get_all_active($order_by = 'display_order', $order = 'ASC')
    {
        return $this->db->where('status', 'active')
                       ->order_by($order_by, $order)
                       ->get($this->table)
                       ->result();
    }

    public function get_by_slug($slug)
    {
        return $this->db->where('slug', $slug)
                       ->where('status', 'active')
                       ->get($this->table)
                       ->row();
    }

    public function get_featured($limit = 4)
    {
        $theme = get_active_template();
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        return $this->db->where('is_featured', 1)
                       ->where('status', 'active')
                       ->order_by('display_order', 'ASC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    public function get_featured_by_type($type, $limit = 4)
    {
        $theme = get_active_template();
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        return $this->db->where('type', $type)
                       ->where('is_featured', 1)
                       ->where('status', 'active')
                       ->order_by('display_order', 'ASC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->table)
                       ->row();
    }

    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    public function count_by_type($type)
    {
        return $this->db->where('type', $type)
                       ->where('status', 'active')
                       ->count_all_results($this->table);
    }

    public function count_active()
    {
        return $this->db->where('status', 'active')
                       ->count_all_results($this->table);
    }

    public function create($data)
    {
        if (empty($data['uid'])) {
            $data['uid'] = $this->generate_uid();
        }

        if (!isset($data['template'])) {
            $data['template'] = get_active_template();
        }

        return $this->db->insert($this->table, $data);
    }

    public function update_by_uid($uid, $data)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, $data);
    }

    public function delete_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->delete($this->table);
    }

    public function toggle_status_by_uid($uid, $status)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, ['status' => $status]);
    }

    public function toggle_featured_by_uid($uid, $is_featured)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, ['is_featured' => $is_featured]);
    }

    public function get_all($limit = 50, $offset = 0, $theme = null)
    {
        if ($theme !== null) {
            $this->db->group_start()
                     ->where('template', 'all')
                     ->or_where('template', $theme)
                     ->group_end();
        }
        
        return $this->db->order_by('display_order', 'ASC')
                       ->order_by('type', 'ASC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function count_all()
    {
        return $this->db->count_all_results($this->table);
    }

    private function generate_uid()
    {
        do {
            $uid = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        } while ($this->uid_exists($uid));

        return $uid;
    }

    public function uid_exists($uid)
    {
        return $this->db->where('uid', $uid)
                       ->count_all_results($this->table) > 0;
    }

    public function get_types()
    {
        return ['tanzania', 'international'];
    }

    public function get_statuses()
    {
        return ['active', 'inactive'];
    }
}
