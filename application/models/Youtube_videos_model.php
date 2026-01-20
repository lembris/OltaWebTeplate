<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Youtube_videos_model extends CI_Model {

    private $table = 'youtube_videos';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all YouTube videos
     */
    public function get_all($limit = 50, $offset = 0)
    {
        return $this->db->where('is_active', 1)
                       ->order_by('display_order', 'ASC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get total count of active videos
     */
    public function get_count()
    {
        return $this->db->where('is_active', 1)
                       ->count_all_results($this->table);
    }

    /**
     * Get video by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get video by UID
     */
    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get featured videos for homepage preview
     */
    public function get_featured($limit = 6)
    {
        return $this->db->where('is_active', 1)
                       ->where('is_featured', 1)
                       ->order_by('display_order', 'ASC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get videos by category
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
     * Get all unique categories with video counts
     */
    public function get_categories()
    {
        return $this->db->select('category, COUNT(*) as video_count')
                       ->where('is_active', 1)
                       ->where('category IS NOT NULL AND category != ""', NULL, FALSE)
                       ->group_by('category')
                       ->order_by('category', 'ASC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Create new YouTube video
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

        // Extract video ID from YouTube URL if not provided
        if (!isset($data['youtube_video_id']) && isset($data['youtube_url'])) {
            $data['youtube_video_id'] = $this->extract_video_id($data['youtube_url']);
        }

        // Generate thumbnail URL from video ID
        if (!isset($data['thumbnail_url']) && isset($data['youtube_video_id'])) {
            $data['thumbnail_url'] = 'https://img.youtube.com/vi/' . $data['youtube_video_id'] . '/hqdefault.jpg';
        }

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update YouTube video by UID
     */
    public function update($uid, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        // Extract video ID if URL changed
        if (isset($data['youtube_url']) && !isset($data['youtube_video_id'])) {
            $data['youtube_video_id'] = $this->extract_video_id($data['youtube_url']);
        }

        // Update thumbnail if video ID changed
        if (isset($data['youtube_video_id'])) {
            $data['thumbnail_url'] = 'https://img.youtube.com/vi/' . $data['youtube_video_id'] . '/hqdefault.jpg';
        }

        return $this->db->where('uid', $uid)
                       ->update($this->table, $data);
    }

    /**
     * Delete YouTube video by UID
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
     * Extract YouTube video ID from URL
     */
    public function extract_video_id($url)
    {
        // Handle youtube.com and youtu.be URLs
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.*/|(?:v|e(?:mbed)?)/)([^\"?&\s]{11})|youtu\.be/([^\"?&\s]{11}))%i', $url, $match)) {
            return $match[1] ?: $match[2];
        }
        return null;
    }

    /**
     * Get embed URL for iframe
     */
    public function get_embed_url($video)
    {
        $video_id = is_object($video) ? $video->youtube_video_id : $video['youtube_video_id'];
        return 'https://www.youtube.com/embed/' . $video_id;
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
     * Search videos
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
     * Get all videos for admin (no active filter)
     */
    public function get_all_admin($limit = 50, $offset = 0)
    {
        return $this->db->order_by('display_order', 'ASC')
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get admin count (all records)
     */
    public function get_count_admin()
    {
        return $this->db->count_all($this->table);
    }
}
