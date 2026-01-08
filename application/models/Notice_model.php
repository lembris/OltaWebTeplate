<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice_model extends CI_Model {

    private $table = 'notices';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all published notices with pagination
     */
    public function get_published($limit = 20, $offset = 0)
    {
        $today = date('Y-m-d');
        
        return $this->db->where('published', 1)
                       ->group_start()
                           ->where('start_date IS NULL', null, false)
                           ->or_where('start_date <=', $today)
                       ->group_end()
                       ->group_start()
                           ->where('end_date IS NULL', null, false)
                           ->or_where('end_date >=', $today)
                       ->group_end()
                       ->order_by('pinned', 'DESC')
                       ->order_by('priority', 'DESC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get total published notices count
     */
    public function get_published_count()
    {
        $today = date('Y-m-d');
        
        return $this->db->where('published', 1)
                       ->group_start()
                           ->where('start_date IS NULL', null, false)
                           ->or_where('start_date <=', $today)
                       ->group_end()
                       ->group_start()
                           ->where('end_date IS NULL', null, false)
                           ->or_where('end_date >=', $today)
                       ->group_end()
                       ->count_all_results($this->table);
    }

    /**
     * Get single notice by slug
     */
    public function get_by_slug($slug)
    {
        return $this->db->where('slug', $slug)
                       ->where('published', 1)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get notices by category
     */
    public function get_by_category($category, $limit = 20, $offset = 0)
    {
        $today = date('Y-m-d');
        
        return $this->db->where('category', $category)
                       ->where('published', 1)
                       ->group_start()
                           ->where('start_date IS NULL', null, false)
                           ->or_where('start_date <=', $today)
                       ->group_end()
                       ->group_start()
                           ->where('end_date IS NULL', null, false)
                           ->or_where('end_date >=', $today)
                       ->group_end()
                       ->order_by('pinned', 'DESC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get pinned notices
     */
    public function get_pinned($limit = 5)
    {
        $today = date('Y-m-d');
        
        return $this->db->where('published', 1)
                       ->where('pinned', 1)
                       ->group_start()
                           ->where('start_date IS NULL', null, false)
                           ->or_where('start_date <=', $today)
                       ->group_end()
                       ->group_start()
                           ->where('end_date IS NULL', null, false)
                           ->or_where('end_date >=', $today)
                       ->group_end()
                       ->order_by('priority', 'DESC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get latest notices
     */
    public function get_latest($limit = 5)
    {
        $today = date('Y-m-d');
        
        return $this->db->where('published', 1)
                       ->group_start()
                           ->where('start_date IS NULL', null, false)
                           ->or_where('start_date <=', $today)
                       ->group_end()
                       ->group_start()
                           ->where('end_date IS NULL', null, false)
                           ->or_where('end_date >=', $today)
                       ->group_end()
                       ->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Increment notice views
     */
    public function increment_views($id)
    {
        return $this->db->set('views', 'views+1', FALSE)
                       ->where('id', $id)
                       ->update($this->table);
    }

    /**
     * ===== ADMIN FUNCTIONS =====
     */

    /**
     * Get all notices (admin)
     */
    public function get_all($limit = 100, $offset = 0)
    {
        return $this->db->order_by('pinned', 'DESC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get all notices count (admin)
     */
    public function get_all_count()
    {
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get notice by ID (admin)
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get notice by UID (admin)
     */
    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Create notice
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
     * Update notice by UID
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
     * Delete notice by UID
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
     * Toggle pinned by UID
     */
    public function toggle_pinned_by_uid($uid, $status)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, ['pinned' => $status]);
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

    /**
     * Get all unique categories
     */
    public function get_categories()
    {
        return $this->db->select('DISTINCT(category) as category', FALSE)
                       ->where('published', 1)
                       ->order_by('category', 'ASC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get recent notices for dashboard
     */
    public function get_recent_notices($limit = 5)
    {
        return $this->db->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Count all notices
     */
    public function count_notices($published = null)
    {
        if ($published !== null) {
            $this->db->where('published', $published);
        }
        return $this->db->count_all_results($this->table);
    }
}
