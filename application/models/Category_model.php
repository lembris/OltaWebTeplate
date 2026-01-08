<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    private $table = 'categories';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all categories
     */
    public function get_all($type = null)
    {
        if ($type) {
            $this->db->group_start()
                     ->where('type', $type)
                     ->or_where('type', 'both')
                     ->group_end();
        }
        
        return $this->db->where('is_active', 1)
                       ->order_by('display_order', 'ASC')
                       ->order_by('name', 'ASC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get all categories including inactive (for admin)
     */
    public function get_all_admin($type = null)
    {
        if ($type) {
            $this->db->group_start()
                     ->where('type', $type)
                     ->or_where('type', 'both')
                     ->group_end();
        }
        
        return $this->db->order_by('type', 'ASC')
                       ->order_by('display_order', 'ASC')
                       ->order_by('name', 'ASC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get category by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get category by slug
     */
    public function get_by_slug($slug)
    {
        return $this->db->where('slug', $slug)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get blog categories
     */
    public function get_blog_categories()
    {
        return $this->get_all('blog');
    }

    /**
     * Get gallery categories
     */
    public function get_gallery_categories()
    {
        return $this->get_all('gallery');
    }

    /**
     * Get categories as key-value array for dropdowns
     */
    public function get_dropdown($type = null)
    {
        $categories = $this->get_all($type);
        $result = [];
        foreach ($categories as $cat) {
            $result[$cat->slug] = $cat->name;
        }
        return $result;
    }

    /**
     * Create new category
     */
    public function create($data)
    {
        $data['uid'] = $this->generate_uid();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        if (empty($data['slug'])) {
            $data['slug'] = $this->generate_slug($data['name']);
        }
        
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Update category
     */
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('id', $id)
                       ->update($this->table, $data);
    }

    /**
     * Delete category
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)
                       ->delete($this->table);
    }

    /**
     * Toggle active status
     */
    public function toggle_status($id)
    {
        $category = $this->get_by_id($id);
        if (!$category) return false;
        
        $new_status = $category->is_active ? 0 : 1;
        return $this->update($id, ['is_active' => $new_status]);
    }

    /**
     * Generate UUID
     */
    private function generate_uid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Generate URL-friendly slug
     */
    private function generate_slug($name, $exclude_id = null)
    {
        $this->load->helper('url');
        $slug = url_title($name, '-', TRUE);
        
        $this->db->where('slug', $slug);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        
        if ($this->db->count_all_results($this->table) > 0) {
            $slug = $slug . '-' . time();
        }
        
        return $slug;
    }

    /**
     * Check if category table exists
     */
    public function table_exists()
    {
        return $this->db->table_exists($this->table);
    }
}
