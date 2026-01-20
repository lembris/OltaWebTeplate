<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Specialty_model extends CI_Model {

    private $table = 'specialties';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_active($limit = 10, $offset = 0)
    {
        return $this->db->where('status', 'active')
                       ->order_by('display_order', 'ASC')
                       ->order_by('id', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function get_featured($limit = 4)
    {
        return $this->db->where('is_featured', 1)
                       ->where('status', 'active')
                       ->order_by('display_order', 'ASC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    public function get_by_category($category, $limit = 10, $offset = 0)
    {
        return $this->db->where('category', $category)
                       ->where('status', 'active')
                       ->order_by('display_order', 'ASC')
                       ->order_by('id', 'DESC')
                       ->limit($limit, $offset)
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

    public function count_by_category($category)
    {
        return $this->db->where('category', $category)
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

        if (empty($data['slug'])) {
            $data['slug'] = $this->generate_slug($data['name']);
        }

        return $this->db->insert($this->table, $data);
    }

    public function update_by_uid($uid, $data)
    {
        if (!empty($data['name']) && empty($data['slug'])) {
            $data['slug'] = $this->generate_slug($data['name']);
        }

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

    public function get_all($limit = 50, $offset = 0)
    {
        return $this->db->order_by('display_order', 'ASC')
                       ->order_by('category', 'ASC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function count_all()
    {
        return $this->db->count_all_results($this->table);
    }

    public function get_categories()
    {
        return $this->db->select('category, COUNT(*) as count')
                       ->where('status', 'active')
                       ->where('category IS NOT NULL AND category != ""', NULL, FALSE)
                       ->group_by('category')
                       ->order_by('category', 'ASC')
                       ->get($this->table)
                       ->result();
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

    private function generate_slug($name)
    {
        $slug = url_title($name, '-', TRUE);
        $count = $this->db->where('slug', $slug)
                         ->count_all_results($this->table);

        if ($count > 0) {
            $slug = $slug . '-' . time();
        }

        return $slug;
    }

    public function slug_exists($slug, $exclude_uid = null)
    {
        $this->db->where('slug', $slug);
        if ($exclude_uid) {
            $this->db->where('uid !=', $exclude_uid);
        }

        return $this->db->count_all_results($this->table) > 0;
    }

    public function get_default_categories()
    {
        return [
            'health_education' => 'Health Education',
            'medical_outreach' => 'Medical Outreach',
            'corporate_wellness' => 'Corporate Wellness',
            'health_media' => 'Health Media'
        ];
    }

    public function get_statuses()
    {
        return ['active', 'inactive'];
    }
}
