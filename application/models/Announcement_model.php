<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement_model extends CI_Model {

    private $table = 'announcements';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all active announcements with pagination
     */
    public function get_active($limit = 20, $offset = 0)
    {
        $now = date('Y-m-d H:i:s');
        
        return $this->db->where('published', 1)
                       ->group_start()
                           ->where('start_date IS NULL', null, false)
                           ->or_where('start_date <=', $now)
                       ->group_end()
                       ->group_start()
                           ->where('end_date IS NULL', null, false)
                           ->or_where('end_date >=', $now)
                       ->group_end()
                       ->order_by('sort_order', 'ASC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get announcements by display location
     */
    public function get_by_location($location, $limit = 10)
    {
        $now = date('Y-m-d H:i:s');
        
        return $this->db->where('published', 1)
                       ->like('display_location', $location)
                       ->group_start()
                           ->where('start_date IS NULL', null, false)
                           ->or_where('start_date <=', $now)
                       ->group_end()
                       ->group_start()
                           ->where('end_date IS NULL', null, false)
                           ->or_where('end_date >=', $now)
                       ->group_end()
                       ->order_by('sort_order', 'ASC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get homepage announcements
     */
    public function get_homepage_announcements($limit = 5)
    {
        return $this->get_by_location('homepage', $limit);
    }

    /**
     * Get header announcements
     */
    public function get_header_announcements($limit = 3)
    {
        return $this->get_by_location('header', $limit);
    }

    /**
     * Get popup announcements
     */
    public function get_popup_announcements($limit = 1)
    {
        return $this->get_by_location('popup', $limit);
    }

    /**
     * Get single announcement by slug
     */
    public function get_by_slug($slug)
    {
        return $this->db->where('slug', $slug)
                       ->where('published', 1)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Increment announcement views
     */
    public function increment_views($id)
    {
        return $this->db->set('views', 'views+1', FALSE)
                       ->where('id', $id)
                       ->update($this->table);
    }

    /**
     * Increment announcement clicks
     */
    public function increment_clicks($id)
    {
        return $this->db->set('clicks', 'clicks+1', FALSE)
                       ->where('id', $id)
                       ->update($this->table);
    }

    /**
     * ===== ADMIN FUNCTIONS =====
     */

    /**
     * Get all announcements (admin)
     */
    public function get_all($limit = 100, $offset = 0)
    {
        return $this->db->order_by('sort_order', 'ASC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get all announcements count (admin)
     */
    public function get_all_count()
    {
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get announcement by ID (admin)
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get announcement by UID (admin)
     */
    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Create announcement
     */
    public function create($data)
    {
        if (empty($data['uid'])) {
            $data['uid'] = $this->generate_uid();
        }

        if (empty($data['slug'])) {
            $data['slug'] = $this->generate_slug($data['title']);
        }

        return $this->db->insert($this->table, $data);
    }

    /**
     * Update announcement by UID
     */
    public function update_by_uid($uid, $data)
    {
        if (!empty($data['title']) && empty($data['slug'])) {
            $data['slug'] = $this->generate_slug($data['title']);
        }

        return $this->db->where('uid', $uid)
                       ->update($this->table, $data);
    }

    /**
     * Delete announcement by UID
     */
    public function delete_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->delete($this->table);
    }

    /**
     * Toggle publish by UID
     */
    public function toggle_publish_by_uid($uid, $status)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, ['published' => $status]);
    }

    /**
     * Update sort order
     */
    public function update_sort_order($items)
    {
        foreach ($items as $index => $uid) {
            $this->db->where('uid', $uid)
                    ->update($this->table, ['sort_order' => $index]);
        }
        return true;
    }

    /**
     * Generate unique UID
     */
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

    /**
     * Check if UID exists
     */
    public function uid_exists($uid)
    {
        return $this->db->where('uid', $uid)
                       ->count_all_results($this->table) > 0;
    }

    /**
     * Generate URL-friendly slug
     */
    private function generate_slug($title)
    {
        $slug = url_title($title, '-', TRUE);
        
        $count = $this->db->where('slug', $slug)
                         ->count_all_results($this->table);
        
        if ($count > 0) {
            $slug = $slug . '-' . time();
        }
        
        return $slug;
    }

    /**
     * Check if slug exists
     */
    public function slug_exists($slug, $exclude_id = null)
    {
        $this->db->where('slug', $slug);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        
        return $this->db->count_all_results($this->table) > 0;
    }
}
