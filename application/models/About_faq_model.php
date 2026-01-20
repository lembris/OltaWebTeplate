<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_faq_model extends CI_Model {

    private $table = 'about_faq';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($limit = 50, $offset = 0)
    {
        return $this->db->order_by('display_order', 'ASC')
                       ->order_by('category', 'ASC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function get_all_by_theme($limit = 50, $offset = 0, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('theme', 'all')
                 ->or_where('theme', $theme)
                 ->group_end();
        
        return $this->db->order_by('display_order', 'ASC')
                       ->order_by('category', 'ASC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function get_active($limit = 50, $offset = 0, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('theme', 'all')
                 ->or_where('theme', $theme)
                 ->group_end();
        
        return $this->db->where('status', 'active')
                       ->order_by('display_order', 'ASC')
                       ->order_by('category', 'ASC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function get_grouped_by_category($theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('theme', 'all')
                 ->or_where('theme', $theme)
                 ->group_end();
        
        $this->db->where('status', 'active');
        $faqs = $this->db->order_by('display_order', 'ASC')
                        ->order_by('category', 'ASC')
                        ->get($this->table)
                        ->result();
        
        // Group by category
        $grouped = [];
        foreach ($faqs as $faq) {
            $category = !empty($faq->category) ? $faq->category : 'General';
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][] = $faq;
        }
        
        return $grouped;
    }

    public function get_featured($limit = 5, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('theme', 'all')
                 ->or_where('theme', $theme)
                 ->group_end();
        
        return $this->db->where('status', 'active')
                       ->where('featured', 1)
                       ->order_by('display_order', 'ASC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    public function create($data)
    {
        if (empty($data['uid'])) {
            $data['uid'] = $this->generate_uid();
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

    public function get_theme_options()
    {
        return [
            'all' => 'All Templates',
            'college' => 'College Template',
            'medical' => 'Medical Template',
            'tourism' => 'Tourism Template'
        ];
    }

    public function get_categories()
    {
        $this->db->select('category');
        $this->db->where('category !=', '');
        $this->db->group_by('category');
        $results = $this->db->get($this->table)->result();
        
        $categories = [];
        foreach ($results as $row) {
            if (!empty($row->category)) {
                $categories[$row->category] = $row->category;
            }
        }
        
        return $categories;
    }
}
