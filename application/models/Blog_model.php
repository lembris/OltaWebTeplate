<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {

    private $table = 'blog_posts';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all published blog posts with pagination (theme-aware)
     */
    public function get_published_posts($limit = 12, $offset = 0, $theme = null)
    {
        // Get theme BEFORE building query to avoid query builder condition leakage
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('published', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get total published posts count (theme-aware)
     */
    public function get_published_count($theme = null)
    {
        // Get theme BEFORE building query to avoid query builder condition leakage
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('published', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->count_all_results($this->table);
    }

    /**
     * Get single post by slug (theme-aware)
     */
    public function get_by_slug($slug, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('slug', $slug)
                       ->where('published', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get posts by category (theme-aware)
     */
    public function get_by_category($category, $limit = 12, $offset = 0, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('category', $category)
                       ->where('published', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get category count (theme-aware)
     */
    public function get_category_count($category, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('category', $category)
                       ->where('published', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->count_all_results($this->table);
    }

    /**
     * Get related posts (same category, theme-aware)
     */
    public function get_related_posts($slug, $category, $limit = 3, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('category', $category)
                       ->where('slug !=', $slug)
                       ->where('published', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get latest posts (theme-aware)
     */
    public function get_latest_posts($limit = 5, $theme = null)
    {
        // Get theme BEFORE building query to avoid query builder condition leakage
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->where('published', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Search posts (theme-aware)
     */
    public function search($keyword, $limit = 12, $offset = 0, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->where('published', 1);
        $this->db->group_start()
                 ->like('title', $keyword)
                 ->or_like('content', $keyword)
                 ->or_like('excerpt', $keyword)
                 ->group_end();
        $this->db->group_start()
                 ->where('theme', 'all')
                 ->or_where('theme', $theme)
                 ->group_end();
        
        return $this->db->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get search count (theme-aware)
     */
    public function get_search_count($keyword, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->where('published', 1);
        $this->db->group_start()
                 ->like('title', $keyword)
                 ->or_like('content', $keyword)
                 ->or_like('excerpt', $keyword)
                 ->group_end();
        $this->db->group_start()
                 ->where('theme', 'all')
                 ->or_where('theme', $theme)
                 ->group_end();
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Increment post views
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
     * Get all posts (admin)
     */
    public function get_all_posts($limit = 20, $offset = 0)
    {
        return $this->db->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get all posts filtered by theme (admin) - shows content for active theme + 'all'
     */
    public function get_all_posts_by_theme($limit = 100, $offset = 0, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('theme', 'all')
                 ->or_where('theme', $theme)
                 ->group_end();
        
        return $this->db->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get all posts count (admin)
     */
    public function get_all_count()
    {
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get post by ID (admin)
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get post by UID (admin)
     */
    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Update post by UID
     */
    public function update_post_by_uid($uid, $data)
    {
        if (!empty($data['title']) && empty($data['slug'])) {
            $data['slug'] = $this->generate_slug($data['title']);
        }

        return $this->db->where('uid', $uid)
                       ->update($this->table, $data);
    }

    /**
     * Delete post by UID
     */
    public function delete_post_by_uid($uid)
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
     * Create post
     */
    public function create_post($data)
    {
        // Generate UID if not provided
        if (empty($data['uid'])) {
            $data['uid'] = $this->generate_uid();
        }

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = $this->generate_slug($data['title']);
        }

        return $this->db->insert($this->table, $data);
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
     * Update post
     */
    public function update_post($id, $data)
    {
        // Update slug if title changed
        if (!empty($data['title']) && empty($data['slug'])) {
            $data['slug'] = $this->generate_slug($data['title']);
        }

        return $this->db->where('id', $id)
                       ->update($this->table, $data);
    }

    /**
     * Delete post
     */
    public function delete_post($id)
    {
        return $this->db->where('id', $id)
                       ->delete($this->table);
    }

    /**
     * Publish/unpublish post
     */
    public function toggle_publish($id, $status)
    {
        return $this->db->where('id', $id)
                       ->update($this->table, ['published' => $status]);
    }

    /**
     * Generate URL-friendly slug
     */
    private function generate_slug($title)
    {
        $slug = url_title($title, '-', TRUE);
        
        // Check if slug exists
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
     * Get all unique categories (theme-aware)
     */
    public function get_categories($theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        return $this->db->select('category, COUNT(*) as post_count')
                       ->where('published', 1)
                       ->where('category IS NOT NULL AND category != ""', NULL, FALSE)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->group_by('category')
                       ->order_by('category', 'ASC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get most viewed posts (theme-aware)
     */
    public function get_most_viewed($limit = 5, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }

        return $this->db->where('published', 1)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->order_by('views', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get popular tags based on post count
     */
    public function get_popular_tags($limit = 8, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }

        // Since tags might be stored as comma-separated in posts, we'll generate from categories
        // or use a tags table if available. This method creates tag-like data from categories.
        return $this->db->select('LOWER(category) as slug, category as name, COUNT(*) as count')
                       ->where('published', 1)
                       ->where('category IS NOT NULL AND category != ""', NULL, FALSE)
                       ->group_start()
                           ->where('theme', 'all')
                           ->or_where('theme', $theme)
                       ->group_end()
                       ->group_by('LOWER(category)')
                       ->order_by('count', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }
}
