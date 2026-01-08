<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_model extends CI_Model {

    private $table = 'gallery_images';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all gallery images (theme-aware)
     */
    public function get_all($limit = 50, $offset = 0, $theme = null)
    {
        // Get theme BEFORE building query to avoid query builder condition leakage
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('is_active', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->order_by('display_order', 'ASC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get total count of active images (theme-aware)
     */
    public function get_count($theme = null)
    {
        // Get theme BEFORE building query to avoid query builder condition leakage
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('is_active', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->count_all_results($this->table);
    }

    /**
     * Get image by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get image by UID
     */
    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get featured images for homepage preview (theme-aware)
     */
    public function get_featured($limit = 8, $theme = null)
    {
        // Get theme BEFORE building query to avoid query builder condition leakage
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('is_active', 1)
                       ->where('is_featured', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->order_by('display_order', 'ASC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get images by category
     */
    public function get_by_category($category, $limit = 20)
    {
        return $this->db->where('is_active', 1)
                       ->where('category', $category)
                       ->order_by('display_order', 'ASC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get all unique categories with image counts
     */
    public function get_categories()
    {
        return $this->db->select('category, COUNT(*) as image_count')
                       ->where('is_active', 1)
                       ->where('category IS NOT NULL AND category != ""', NULL, FALSE)
                       ->group_by('category')
                       ->order_by('category', 'ASC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Create new gallery image
     */
    public function create($data)
    {
        if (!isset($data['uid'])) {
            $data['uid'] = $this->generate_uid();
        }
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        if (!isset($data['updated_at'])) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        if (!isset($data['display_order'])) {
            $data['display_order'] = $this->get_next_order();
        }
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update gallery image by UID
     */
    public function update($uid, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('uid', $uid)
                       ->update($this->table, $data);
    }

    /**
     * Delete gallery image by UID
     */
    public function delete($uid)
    {
        return $this->db->where('uid', $uid)
                       ->delete($this->table);
    }

    /**
     * Toggle featured status
     */
    public function toggle_featured($uid, $status)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, [
                           'is_featured' => $status,
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Toggle active status
     */
    public function toggle_active($uid, $status)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, [
                           'is_active' => $status,
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Update display order
     */
    public function update_order($uid, $order)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, [
                           'display_order' => $order,
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Get next display order
     */
    private function get_next_order()
    {
        $result = $this->db->select_max('display_order', 'max_order')
                          ->get($this->table)
                          ->row();
        return ($result && $result->max_order) ? $result->max_order + 1 : 1;
    }

    /**
     * Get image URL with base_url
     */
    public function get_image_url($image)
    {
        $src = is_object($image) ? $image->src : $image['src'];
        
        if (strpos($src, 'http') === 0) {
            return $src;
        }
        
        $base_url = function_exists('base_url') ? base_url() : '/';
        
        if (strpos($src, 'assets/') === 0) {
            return $base_url . $src;
        }
        
        return $base_url . 'assets/img/gallery/' . $src;
    }

    /**
     * Generate UUID
     */
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
     * Search images
     */
    public function search($keyword, $limit = 50)
    {
        return $this->db->where('is_active', 1)
                       ->group_start()
                       ->like('title', $keyword)
                       ->or_like('description', $keyword)
                       ->or_like('category', $keyword)
                       ->group_end()
                       ->order_by('display_order', 'ASC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get all images filtered by theme (admin) - shows content for active theme + 'all'
     */
    public function get_all_by_theme($theme = null)
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
                       ->get($this->table)
                       ->result();
    }
}
