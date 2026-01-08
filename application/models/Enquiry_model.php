<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry_model extends CI_Model {

    private $table = 'contact_enquiries';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Generate UUID v4
     * @return string UUID
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
     * Save a new enquiry
     * @param array $data Enquiry data
     * @return int|bool Enquiry ID on success, false on failure
     */
    public function save_enquiry($data)
    {
        $data['uid'] = $this->generate_uid();
        $data['reference_number'] = $this->generate_reference();
        $data['status'] = 'new';
        $data['created_at'] = date('Y-m-d H:i:s');

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        
        return false;
    }

    /**
     * Generate unique reference number
     * @return string Reference (e.g., ENQ-2025-12345)
     */
    private function generate_reference()
    {
        $prefix = 'ENQ';
        $year = date('Y');
        
        do {
            $random = str_pad(mt_rand(10000, 99999), 5, '0', STR_PAD_LEFT);
            $ref = "{$prefix}-{$year}-{$random}";
            
            $exists = $this->db->where('reference_number', $ref)
                              ->count_all_results($this->table);
        } while ($exists > 0);
        
        return $ref;
    }

    /**
     * Get single enquiry by ID
     * @param int $id Enquiry ID
     * @return object|null Enquiry object or null
     */
    public function get_enquiry($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get single enquiry by UID
     * @param string $uid Enquiry UID
     * @return object|null Enquiry object or null
     */
    public function get_enquiry_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->where('is_deleted', 0)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get enquiry by reference number
     * @param string $reference Reference number
     * @return object|null Enquiry object or null
     */
    public function get_enquiry_by_ref($reference)
    {
        return $this->db->where('reference_number', $reference)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get all enquiries
     * @param int $limit Limit
     * @param int $offset Offset
     * @param string $status Filter by status
     * @return array Array of enquiries
     */
    public function get_all_enquiries($limit = 20, $offset = 0, $status = null)
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        
        return $this->db->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Count all enquiries
     * @param string $status Filter by status
     * @return int Count
     */
    public function count_enquiries($status = null)
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Update enquiry status
     * @param int $id Enquiry ID
     * @param string $status New status
     * @return bool Success
     */
    public function update_status($id, $status)
    {
        $valid_statuses = ['new', 'read', 'replied', 'closed'];
        
        if (!in_array($status, $valid_statuses)) {
            return false;
        }
        
        return $this->db->where('id', $id)
                       ->update($this->table, [
                            'status' => $status,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    }

    /**
     * Update enquiry by ID
     * @param int $id Enquiry ID
     * @param array $data Data to update
     * @return bool Success
     */
    public function update_enquiry($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('id', $id)
                       ->update($this->table, $data);
    }

    /**
     * Update enquiry by UID
     * @param string $uid Enquiry UID
     * @param array $data Data to update
     * @return bool Success
     */
    public function update_enquiry_by_uid($uid, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('uid', $uid)
                       ->update($this->table, $data);
    }

    /**
     * Mark email as sent
     * @param int $id Enquiry ID
     * @return bool Success
     */
    public function mark_email_sent($id)
    {
        return $this->db->where('id', $id)
                       ->update($this->table, [
                           'email_sent' => 1,
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Get enquiries by email
     * @param string $email Customer email
     * @return array Array of enquiries
     */
    public function get_enquiries_by_email($email)
    {
        return $this->db->where('email', $email)
                       ->order_by('created_at', 'DESC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get recent enquiries
     * @param int $limit Number of enquiries
     * @return array Array of enquiries
     */
    public function get_recent_enquiries($limit = 10)
    {
        return $this->db->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get enquiry statistics
     * @return object Statistics
     */
    public function get_statistics()
    {
        $stats = new stdClass();
        
        $stats->total = $this->count_enquiries();
        $stats->new = $this->count_enquiries('new');
        $stats->contacted = $this->count_enquiries('contacted');
        $stats->quoted = $this->count_enquiries('quoted');
        $stats->converted = $this->count_enquiries('converted');
        $stats->closed = $this->count_enquiries('closed');
        
        // This month's enquiries
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $stats->this_month = $this->db->count_all_results($this->table);
        
        // Conversion rate
        $stats->conversion_rate = $stats->total > 0 
            ? round(($stats->converted / $stats->total) * 100, 1) 
            : 0;
        
        return $stats;
    }

    /**
     * Search enquiries
     * @param string $query Search query
     * @param int $limit Limit
     * @return array Array of enquiries
     */
    public function search_enquiries($query, $limit = 20)
    {
        return $this->db->group_start()
                       ->like('full_name', $query)
                       ->or_like('email', $query)
                       ->or_like('phone', $query)
                       ->or_like('reference_number', $query)
                       ->group_end()
                       ->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Delete enquiry (soft delete)
     * @param int $id Enquiry ID
     * @return bool Success
     */
    public function delete_enquiry($id)
    {
        return $this->db->where('id', $id)
                       ->update($this->table, [
                           'is_deleted' => 1,
                           'deleted_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Delete enquiry by UID (soft delete)
     * @param string $uid Enquiry UID
     * @return bool Success
     */
    public function delete_enquiry_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, [
                           'is_deleted' => 1,
                           'deleted_at' => date('Y-m-d H:i:s'),
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Hard delete enquiry
     * @param int $id Enquiry ID
     * @return bool Success
     */
    public function hard_delete($id)
    {
        return $this->db->where('id', $id)
                       ->delete($this->table);
    }

    /**
     * Get enquiries by date range
     * @param string $start_date Start date
     * @param string $end_date End date
     * @return array Array of enquiries
     */
    public function get_enquiries_by_date_range($start_date, $end_date)
    {
        return $this->db->where('created_at >=', $start_date)
                       ->where('created_at <=', $end_date)
                       ->order_by('created_at', 'DESC')
                       ->get($this->table)
                       ->result();
    }

    // =========================================================================
    // ADMIN METHODS
    // =========================================================================

    /**
     * Get all enquiries for admin with filters
     * @param int $limit Limit
     * @param int $offset Offset
     * @param string $status Filter by status
     * @param string $search Search term
     * @param string $type Filter by type (contact, safari, or null for all)
     * @return array Array of enquiries
     */
    public function get_all_enquiries_admin($limit = 20, $offset = 0, $status = null, $search = null, $type = null)
    {
        $this->db->where('is_deleted', 0);
        
        if ($status && $status !== 'all') {
            $this->db->where('status', $status);
        }
        
        // Filter by type
        if ($type === 'contact') {
            $this->db->where('trip_type', 'Contact Form');
        } elseif ($type === 'safari') {
            $this->db->where('trip_type !=', 'Contact Form');
            $this->db->where('trip_type IS NOT NULL');
        }
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('full_name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('phone', $search);
            $this->db->or_like('reference_number', $search);
            $this->db->or_like('special_requirements', $search);
            $this->db->group_end();
        }
        
        return $this->db->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Count enquiries for admin
     * @param string $status Filter by status
     * @param string $search Search term
     * @param string $type Filter by type (contact, safari, or null for all)
     * @return int Count
     */
    public function count_enquiries_admin($status = null, $search = null, $type = null)
    {
        $this->db->where('is_deleted', 0);
        
        if ($status && $status !== 'all') {
            $this->db->where('status', $status);
        }
        
        // Filter by type
        if ($type === 'contact') {
            $this->db->where('trip_type', 'Contact Form');
        } elseif ($type === 'safari') {
            $this->db->where('trip_type !=', 'Contact Form');
            $this->db->where('trip_type IS NOT NULL');
        }
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('full_name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('phone', $search);
            $this->db->or_like('reference_number', $search);
            $this->db->or_like('special_requirements', $search);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Get statistics for admin (with optional type filter)
     * @param string $type Filter by type (contact, safari, or null for all)
     * @return object Statistics object
     */
    public function get_admin_statistics($type = null)
    {
        $stats = new stdClass();
        
        $stats->total = $this->get_enquiry_count_by_type(null, $type);
        $stats->new = $this->get_enquiry_count_by_type('new', $type);
        $stats->read = $this->get_enquiry_count_by_type('read', $type);
        $stats->replied = $this->get_enquiry_count_by_type('replied', $type);
        $stats->closed = $this->get_enquiry_count_by_type('closed', $type);
        
        // Today's enquiries
        $this->db->where('is_deleted', 0);
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        if ($type === 'contact') {
            $this->db->where('trip_type', 'Contact Form');
        } elseif ($type === 'safari') {
            $this->db->where('trip_type !=', 'Contact Form');
            $this->db->where('trip_type IS NOT NULL');
        }
        $stats->today = $this->db->count_all_results($this->table);
        
        // This week's enquiries
        $this->db->where('is_deleted', 0);
        $this->db->where('created_at >=', date('Y-m-d', strtotime('-7 days')));
        if ($type === 'contact') {
            $this->db->where('trip_type', 'Contact Form');
        } elseif ($type === 'safari') {
            $this->db->where('trip_type !=', 'Contact Form');
            $this->db->where('trip_type IS NOT NULL');
        }
        $stats->this_week = $this->db->count_all_results($this->table);
        
        // This month's enquiries
        $this->db->where('is_deleted', 0);
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        if ($type === 'contact') {
            $this->db->where('trip_type', 'Contact Form');
        } elseif ($type === 'safari') {
            $this->db->where('trip_type !=', 'Contact Form');
            $this->db->where('trip_type IS NOT NULL');
        }
        $stats->this_month = $this->db->count_all_results($this->table);
        
        return $stats;
    }
    
    /**
     * Get enquiry count by status and type
     * @param string $status Status to count
     * @param string $type Filter by type
     * @return int Count
     */
    private function get_enquiry_count_by_type($status = null, $type = null)
    {
        $this->db->where('is_deleted', 0);
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        if ($type === 'contact') {
            $this->db->where('trip_type', 'Contact Form');
        } elseif ($type === 'safari') {
            $this->db->where('trip_type !=', 'Contact Form');
            $this->db->where('trip_type IS NOT NULL');
        }
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get enquiry count by status (for dashboard badges)
     * @param string $status Status to count
     * @return int Count
     */
    public function get_enquiry_count($status = null)
    {
        $this->db->where('is_deleted', 0);
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Update enquiry status (admin)
     * @param int $id Enquiry ID
     * @param string $status New status
     * @return bool Success
     */
    public function update_enquiry_status($id, $status)
    {
        $valid_statuses = ['new', 'read', 'replied', 'closed'];
        
        if (!in_array($status, $valid_statuses)) {
            return false;
        }
        
        return $this->db->where('id', $id)
                       ->update($this->table, [
                           'status' => $status,
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Update enquiry status by UID (admin)
     * @param string $uid Enquiry UID
     * @param string $status New status
     * @return bool Success
     */
    public function update_enquiry_status_by_uid($uid, $status)
    {
        $valid_statuses = ['new', 'read', 'replied', 'closed'];
        
        if (!in_array($status, $valid_statuses)) {
            return false;
        }
        
        return $this->db->where('uid', $uid)
                       ->update($this->table, [
                            'status' => $status,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    }

    /**
     * Update contact form status by ID
     * @param int $id Enquiry ID
     * @param string $status New status
     * @return bool Success
     */
    public function update_contact_status($id, $status)
    {
        $valid_statuses = ['new', 'read', 'replied', 'closed'];
        
        if (!in_array($status, $valid_statuses)) {
            return false;
        }
        
        $enquiry = $this->get_enquiry($id);
        if (!$enquiry || $enquiry->trip_type !== 'Contact Form') {
            return false;
        }
        
        return $this->db->where('id', $id)
                       ->update($this->table, [
                            'status' => $status,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    }

    /**
     * Update contact form status by UID
     * @param string $uid Enquiry UID
     * @param string $status New status
     * @return bool Success
     */
    public function update_contact_status_by_uid($uid, $status)
    {
        $valid_statuses = ['new', 'read', 'replied', 'closed'];
        
        if (!in_array($status, $valid_statuses)) {
            return false;
        }
        
        $enquiry = $this->get_enquiry_by_uid($uid);
        if (!$enquiry || $enquiry->trip_type !== 'Contact Form') {
            return false;
        }
        
        return $this->db->where('uid', $uid)
                       ->update($this->table, [
                            'status' => $status,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    }

    /**
     * Mark enquiry as read
     * @param int $id Enquiry ID
     * @return bool Success
     */
    public function mark_as_read($id)
    {
        $enquiry = $this->get_enquiry($id);
        if ($enquiry && $enquiry->status === 'new') {
            return $this->update_enquiry_status($id, 'read');
        }
        return true;
    }

    /**
     * Mark enquiry as read by UID
     * @param string $uid Enquiry UID
     * @return bool Success
     */
    public function mark_as_read_by_uid($uid)
    {
        $enquiry = $this->get_enquiry_by_uid($uid);
        if ($enquiry && $enquiry->status === 'new') {
            return $this->update_enquiry_status_by_uid($uid, 'read');
        }
        return true;
    }

    /**
     * Add admin note to enquiry
     * @param int $enquiry_id Enquiry ID
     * @param string $note Note content
     * @param int $admin_id Admin user ID
     * @return bool Success
     */
    public function add_note($enquiry_id, $note, $admin_id = null)
    {
        $enquiry = $this->get_enquiry($enquiry_id);
        if (!$enquiry) {
            return false;
        }
        
        $existing_notes = !empty($enquiry->admin_notes) ? json_decode($enquiry->admin_notes, true) : [];
        if (!is_array($existing_notes)) {
            $existing_notes = [];
        }
        
        $existing_notes[] = [
            'note' => $note,
            'admin_id' => $admin_id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->where('id', $enquiry_id)
                       ->update($this->table, [
                           'admin_notes' => json_encode($existing_notes),
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Add admin note to enquiry by UID
     * @param string $uid Enquiry UID
     * @param string $note Note content
     * @param int $admin_id Admin user ID
     * @return bool Success
     */
    public function add_note_by_uid($uid, $note, $admin_id = null)
    {
        $enquiry = $this->get_enquiry_by_uid($uid);
        if (!$enquiry) {
            return false;
        }
        
        return $this->add_note($enquiry->id, $note, $admin_id);
    }

    /**
     * Get notes for enquiry
     * @param int $enquiry_id Enquiry ID
     * @return array Array of notes
     */
    public function get_notes($enquiry_id)
    {
        $enquiry = $this->get_enquiry($enquiry_id);
        if (!$enquiry || empty($enquiry->admin_notes)) {
            return [];
        }
        
        $notes = json_decode($enquiry->admin_notes, true);
        return is_array($notes) ? $notes : [];
    }

    /**
     * Get notes for enquiry by UID
     * @param string $uid Enquiry UID
     * @return array Array of notes
     */
    public function get_notes_by_uid($uid)
    {
        $enquiry = $this->get_enquiry_by_uid($uid);
        if (!$enquiry || empty($enquiry->admin_notes)) {
            return [];
        }
        
        $notes = json_decode($enquiry->admin_notes, true);
        return is_array($notes) ? $notes : [];
    }

    /**
     * Get recent enquiries for dashboard
     * @param int $limit Number of enquiries
     * @return array Array of enquiries
     */
    public function get_recent_enquiries_admin($limit = 5)
    {
        return $this->db->where('is_deleted', 0)
                       ->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get enquiry details for admin view (with full data)
     * @param string $uid Enquiry UID
     * @return object|null Enquiry object or null
     */
    public function get_enquiry_details($uid)
    {
        return $this->db->where('uid', $uid)
                       ->where('is_deleted', 0)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get enquiries for export
     * @param string $status Filter by status
     * @return array Array of enquiries
     */
    public function get_enquiries_for_export($status = null)
    {
        $this->db->where('is_deleted', 0);
        
        if ($status && $status !== 'all') {
            $this->db->where('status', $status);
        }
        
        return $this->db->order_by('created_at', 'DESC')
                       ->get($this->table)
                       ->result();
    }
}
