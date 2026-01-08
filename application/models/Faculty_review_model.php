<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty_review_model extends CI_Model {

    private $table = 'reviews';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new review
     */
    public function create($data)
    {
        $insert_data = [
            'faculty_id' => $data['faculty_id'],
            'student_name' => $data['student_name'],
            'email' => isset($data['email']) ? $data['email'] : '',
            'rating' => (int)$data['rating'],
            'review_title' => $data['review_title'],
            'review_text' => $data['review_text'],
            'theme' => isset($data['theme']) ? $data['theme'] : 'college',
            'type' => 'faculty',
            'ip_address' => $this->input->ip_address(),
            'status' => 'pending',
            'user_id' => $this->session->userdata('user_id') ?? NULL,
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $this->db->insert($this->table, $insert_data);
    }

    /**
     * Get all reviews for a faculty member
     */
    public function get_by_faculty($faculty_id, $status = 'approved', $limit = NULL, $offset = 0)
    {
        $query = $this->db->where('faculty_id', $faculty_id);
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $query->order_by('created_at', 'DESC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get($this->table)->result();
    }

    /**
     * Count reviews for a faculty member
     */
    public function count_by_faculty($faculty_id, $status = 'approved')
    {
        $this->db->where('faculty_id', $faculty_id);
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get average rating for a faculty member
     */
    public function get_average_rating($faculty_id)
    {
        $result = $this->db->select_avg('rating')
                          ->where('faculty_id', $faculty_id)
                          ->where('status', 'approved')
                          ->get($this->table)
                          ->row();
        
        return $result->rating ? round($result->rating, 1) : 0;
    }

    /**
     * Get all reviews (for admin)
     */
    public function get_all($limit = NULL, $offset = 0, $filters = [])
    {
        $query = $this->db->select('fr.*, fs.first_name, fs.last_name')
                         ->from($this->table . ' fr')
                         ->join('faculty_staff fs', 'fr.faculty_id = fs.id', 'left');
        
        // Apply theme filter
        if (isset($filters['theme']) && $filters['theme']) {
            $query->where('fr.theme', $filters['theme']);
        }
        
        // Apply type filter
        if (isset($filters['type']) && $filters['type']) {
            $query->where('fr.type', $filters['type']);
        }
        
        // Apply filters
        if (isset($filters['status']) && $filters['status']) {
            $query->where('fr.status', $filters['status']);
        }
        
        if (isset($filters['faculty_id']) && $filters['faculty_id']) {
            $query->where('fr.faculty_id', $filters['faculty_id']);
        }
        
        if (isset($filters['rating']) && $filters['rating']) {
            $query->where('fr.rating', $filters['rating']);
        }
        
        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->group_start()
                  ->like('fr.student_name', $search)
                  ->or_like('fr.review_title', $search)
                  ->or_like('fr.review_text', $search)
                  ->or_like('fs.first_name', $search)
                  ->or_like('fs.last_name', $search)
                  ->group_end();
        }
        
        $query->order_by('fr.created_at', 'DESC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get()->result();
    }

    /**
     * Count all reviews with optional filters
     */
    public function count_all($filters = [])
    {
        $query = $this->db->from($this->table . ' fr')
                         ->join('faculty_staff fs', 'fr.faculty_id = fs.id', 'left');
        
        // Apply theme filter
        if (isset($filters['theme']) && $filters['theme']) {
            $query->where('fr.theme', $filters['theme']);
        }
        
        // Apply type filter
        if (isset($filters['type']) && $filters['type']) {
            $query->where('fr.type', $filters['type']);
        }
        
        if (isset($filters['status']) && $filters['status']) {
            $query->where('fr.status', $filters['status']);
        }
        
        if (isset($filters['faculty_id']) && $filters['faculty_id']) {
            $query->where('fr.faculty_id', $filters['faculty_id']);
        }
        
        if (isset($filters['rating']) && $filters['rating']) {
            $query->where('fr.rating', $filters['rating']);
        }
        
        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->group_start()
                  ->like('fr.student_name', $search)
                  ->or_like('fr.review_title', $search)
                  ->or_like('fr.review_text', $search)
                  ->or_like('fs.first_name', $search)
                  ->or_like('fs.last_name', $search)
                  ->group_end();
        }
        
        return $query->count_all_results();
    }

    /**
     * Get a single review by ID
     */
    public function get_by_id($id)
    {
        return $this->db->select('fr.*, fs.first_name, fs.last_name')
                       ->from($this->table . ' fr')
                       ->join('faculty_staff fs', 'fr.faculty_id = fs.id', 'left')
                       ->where('fr.id', $id)
                       ->get()
                       ->row();
    }

    /**
     * Get a single review by UID
     */
    public function get_by_uid($uid)
    {
        return $this->db->select('fr.*, fs.first_name, fs.last_name')
                       ->from($this->table . ' fr')
                       ->join('faculty_staff fs', 'fr.faculty_id = fs.id', 'left')
                       ->where('fr.uid', $uid)
                       ->get()
                       ->row();
    }

    /**
     * Update review status (approve/reject) by ID
     */
    public function update_status($id, $status)
    {
        if (!in_array($status, ['approved', 'rejected', 'pending'])) {
            return false;
        }
        
        return $this->db->update($this->table, ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')], ['id' => $id]);
    }

    /**
     * Update review status by UID
     */
    public function update_status_by_uid($uid, $status)
    {
        if (!in_array($status, ['approved', 'rejected', 'pending'])) {
            return false;
        }
        
        return $this->db->update($this->table, ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')], ['uid' => $uid]);
    }

    /**
     * Delete a review by ID
     */
    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    /**
     * Delete a review by UID
     */
    public function delete_by_uid($uid)
    {
        return $this->db->delete($this->table, ['uid' => $uid]);
    }

    /**
     * Check if user has already reviewed (prevent duplicates within timeframe)
     */
    public function has_recent_review($faculty_id, $email, $hours = 24)
    {
        if (!$email) {
            return false; // Skip check if no email provided
        }
        
        $time = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));
        
        return $this->db->where('faculty_id', $faculty_id)
                       ->where('email', $email)
                       ->where('created_at >', $time)
                       ->count_all_results($this->table) > 0;
    }

    /**
     * Get statistics for dashboard (optionally filtered by theme)
     */
    public function get_statistics($theme = NULL)
    {
        $query = $this->db;
        
        if ($theme) {
            $query->where('theme', $theme);
        }
        
        $total = $query->count_all_results($this->table);
        
        $pending_query = $this->db->where('status', 'pending');
        if ($theme) {
            $pending_query->where('theme', $theme);
        }
        $pending = $pending_query->count_all_results($this->table);
        
        $approved_query = $this->db->where('status', 'approved');
        if ($theme) {
            $approved_query->where('theme', $theme);
        }
        $approved = $approved_query->count_all_results($this->table);
        
        $rejected_query = $this->db->where('status', 'rejected');
        if ($theme) {
            $rejected_query->where('theme', $theme);
        }
        $rejected = $rejected_query->count_all_results($this->table);
        
        return [
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'average_rating' => $this->get_all_average_rating($theme)
        ];
    }

    /**
     * Get overall average rating across all reviews (optionally filtered by theme)
     */
    public function get_all_average_rating($theme = NULL)
    {
        $query = $this->db->select_avg('rating');
        
        if ($theme) {
            $query->where('theme', $theme);
        }
        
        $result = $query->where('status', 'approved')
                        ->get($this->table)
                        ->row();
        
        return $result->rating ? round($result->rating, 1) : 0;
    }

    /**
     * Get rating distribution
     */
    public function get_rating_distribution($faculty_id = NULL)
    {
        $query = $this->db->select('rating, COUNT(*) as count')
                         ->where('status', 'approved');
        
        if ($faculty_id) {
            $query->where('faculty_id', $faculty_id);
        }
        
        return $query->group_by('rating')
                    ->order_by('rating', 'DESC')
                    ->get($this->table)
                    ->result();
    }

    /**
     * Get distinct review types for a theme
     */
    public function get_types_by_theme($theme = NULL)
    {
        $query = $this->db->distinct()
                         ->select('type')
                         ->order_by('type', 'ASC');
        
        if ($theme) {
            $query->where('theme', $theme);
        }
        
        return $query->get($this->table)->result();
    }

    /**
     * Check if a type uses faculty_id (e.g., 'faculty' type does, but 'testimonial' might not)
     */
    public function type_has_faculty($type)
    {
        // Types that are associated with faculty
        $faculty_types = ['faculty'];
        return in_array($type, $faculty_types);
    }

    /**
     * Check if theme has faculty-related reviews
     */
    public function theme_has_faculty_reviews($theme)
    {
        $types = $this->get_types_by_theme($theme);
        foreach ($types as $type) {
            if ($this->type_has_faculty($type->type)) {
                return true;
            }
        }
        return false;
    }
}
