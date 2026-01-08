<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model {

    private $table = 'pages';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all pages
     */
    public function get_all()
    {
        return $this->db->order_by('sort_order', 'ASC')
                       ->order_by('title', 'ASC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get single page by UID
     */
    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get single page by slug
     */
    public function get_by_slug($slug)
    {
        return $this->db->where('slug', $slug)
                       ->where('status', 'published')
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get all published pages (theme-aware)
     */
    public function get_published($theme = null)
    {
        // Get theme BEFORE building query to avoid query builder condition leakage
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('status', 'published')
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->order_by('sort_order', 'ASC')
                       ->order_by('title', 'ASC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get pages for footer (theme-aware)
     */
    public function get_footer_pages($theme = null)
    {
        // Get theme BEFORE building query to avoid query builder condition leakage
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('status', 'published')
                       ->where('show_in_footer', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->order_by('sort_order', 'ASC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get pages for header (theme-aware)
     */
    public function get_header_pages($theme = null)
    {
        // Get theme BEFORE building query to avoid query builder condition leakage
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('status', 'published')
                       ->where('show_in_header', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->order_by('sort_order', 'ASC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Create new page with auto-generated UID
     */
    public function create($data)
    {
        $data['uid'] = $this->generate_uid();
        
        if (empty($data['slug'])) {
            $data['slug'] = $this->generate_slug($data['title']);
        }
        
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        if ($this->db->insert($this->table, $data)) {
            return $data['uid'];
        }
        return false;
    }

    /**
     * Update page by UID
     */
    public function update_by_uid($uid, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('uid', $uid)
                       ->update($this->table, $data);
    }

    /**
     * Delete page by UID
     */
    public function delete_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->delete($this->table);
    }

    /**
     * Toggle page status by UID
     */
    public function toggle_status($uid)
    {
        $page = $this->get_by_uid($uid);
        if (!$page) {
            return false;
        }
        
        $new_status = ($page->status === 'published') ? 'draft' : 'published';
        
        return $this->db->where('uid', $uid)
                       ->update($this->table, [
                           'status' => $new_status,
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Generate UUID v4
     */
    public function generate_uid()
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
    public function generate_slug($title, $exclude_uid = null)
    {
        $slug = url_title($title, '-', TRUE);
        
        if ($this->slug_exists($slug, $exclude_uid)) {
            $slug = $slug . '-' . time();
        }
        
        return $slug;
    }

    /**
     * Check if slug exists
     */
    public function slug_exists($slug, $exclude_uid = null)
    {
        $this->db->where('slug', $slug);
        
        if ($exclude_uid) {
            $this->db->where('uid !=', $exclude_uid);
        }
        
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Get page count
     */
    public function get_count()
    {
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get published page count
     */
    public function get_published_count()
    {
        return $this->db->where('status', 'published')
                       ->count_all_results($this->table);
    }

    /**
     * Update sort order for a page
     */
    public function update_sort_order($uid, $sort_order)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, [
                           'sort_order' => $sort_order,
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Get available templates
     */
    public function get_templates()
    {
        return [
            'default' => 'Default Template',
            'full-width' => 'Full Width',
            'sidebar' => 'With Sidebar',
            'landing' => 'Landing Page'
        ];
    }

    /**
     * Get all pages filtered by theme (admin) - shows content for active theme + 'all'
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
        
        return $this->db->order_by('sort_order', 'ASC')
                       ->order_by('title', 'ASC')
                       ->get($this->table)
                       ->result();
    }
}
