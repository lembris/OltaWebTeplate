<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial_model extends CI_Model {

    private $table = 'testimonials';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($limit = 50, $offset = 0)
    {
        return $this->db->order_by('display_order', 'ASC')
                       ->order_by('created_at', 'DESC')
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
                 ->where('theme', 'all')
                 ->or_where('theme', $theme)
                 ->group_end();
        
        return $this->db->order_by('display_order', 'ASC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function get_all_count()
    {
        return $this->db->count_all_results($this->table);
    }

    public function get_all_count_by_theme($theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('theme', 'all')
                 ->or_where('theme', $theme)
                 ->group_end();
        
        return $this->db->count_all_results($this->table);
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

    public function get_featured($limit = 4)
    {
        $theme = get_active_template();
        
        $this->db->group_start()
                 ->where('theme', 'all')
                 ->or_where('theme', $theme)
                 ->group_end();
        
        return $this->db->where('is_featured', 1)
                       ->where('status', 'active')
                       ->order_by('display_order', 'ASC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    public function get_active($limit = 10)
    {
        $theme = get_active_template();
        
        $this->db->group_start()
                 ->where('theme', 'all')
                 ->or_where('theme', $theme)
                 ->group_end();
        
        return $this->db->where('status', 'active')
                       ->order_by('display_order', 'ASC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    public function create($data)
    {
        if (empty($data['uid'])) {
            $data['uid'] = $this->generate_uid();
        }

        if (!isset($data['theme'])) {
            $data['theme'] = get_active_template();
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

    public function get_statuses()
    {
        return ['active', 'inactive'];
    }

    public function get_rating_options()
    {
        return [
            5 => '5 Stars',
            4 => '4 Stars',
            3 => '3 Stars',
            2 => '2 Stars',
            1 => '1 Star'
        ];
    }
}
