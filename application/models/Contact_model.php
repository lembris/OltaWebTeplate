<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {

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
                              ->where('trip_type', 'Contact Form')
                              ->count_all_results($this->table);
        } while ($exists > 0);
        
        return $ref;
    }

    /**
     * Save a new contact form submission
     * @param array $data Contact data
     * @return int|bool Contact ID on success, false on failure
     */
    public function save_contact($data)
    {
        $data['uid'] = $this->generate_uid();
        $data['reference_number'] = $this->generate_reference();
        $data['status'] = 'new';
        $data['trip_type'] = 'Contact Form';
        $data['created_at'] = date('Y-m-d H:i:s');

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        
        return false;
    }

    /**
     * Get single contact by ID
     * @param int $id Contact ID
     * @return object|null Contact object or null
     */
    public function get_contact($id)
    {
        return $this->db->where('id', $id)
                       ->where('trip_type', 'Contact Form')
                       ->where('is_deleted', 0)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get single contact by UID
     * @param string $uid Contact UID
     * @return object|null Contact object or null
     */
    public function get_contact_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->where('trip_type', 'Contact Form')
                       ->where('is_deleted', 0)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get single contact by reference number
     * @param string $reference Reference number
     * @return object|null Contact object or null
     */
    public function get_contact_by_ref($reference)
    {
        return $this->db->where('reference_number', $reference)
                       ->where('trip_type', 'Contact Form')
                       ->where('is_deleted', 0)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get all contacts with filters
     * @param int $limit Limit
     * @param int $offset Offset
     * @param string $status Filter by status
     * @param string $search Search term
     * @return array Array of contacts
     */
    public function get_all_contacts($limit = 20, $offset = 0, $status = null, $search = null)
    {
        $this->db->where('trip_type', 'Contact Form');
        $this->db->where('is_deleted', 0);
        
        if ($status && $status !== 'all') {
            $this->db->where('status', $status);
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
     * Count contacts with filters
     * @param string $status Filter by status
     * @param string $search Search term
     * @return int Count
     */
    public function count_contacts($status = null, $search = null)
    {
        $this->db->where('trip_type', 'Contact Form');
        $this->db->where('is_deleted', 0);
        
        if ($status && $status !== 'all') {
            $this->db->where('status', $status);
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
     * Get contact statistics
     * @return object Statistics object
     */
    public function get_statistics()
    {
        $stats = new stdClass();
        
        $stats->total = $this->get_contact_count_by_status();
        $stats->new = $this->get_contact_count_by_status('new');
        $stats->read = $this->get_contact_count_by_status('read');
        $stats->replied = $this->get_contact_count_by_status('replied');
        $stats->closed = $this->get_contact_count_by_status('closed');
        
        // Today's contacts
        $this->db->where('trip_type', 'Contact Form');
        $this->db->where('is_deleted', 0);
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        $stats->today = $this->db->count_all_results($this->table);
        
        // This week's contacts
        $this->db->where('trip_type', 'Contact Form');
        $this->db->where('is_deleted', 0);
        $this->db->where('created_at >=', date('Y-m-d', strtotime('-7 days')));
        $stats->this_week = $this->db->count_all_results($this->table);
        
        // This month's contacts
        $this->db->where('trip_type', 'Contact Form');
        $this->db->where('is_deleted', 0);
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $stats->this_month = $this->db->count_all_results($this->table);
        
        return $stats;
    }

    /**
     * Get contact count by status
     * @param string $status Status to count
     * @return int Count
     */
    private function get_contact_count_by_status($status = null)
    {
        $this->db->where('trip_type', 'Contact Form');
        $this->db->where('is_deleted', 0);
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Search contacts
     * @param string $query Search query
     * @param int $limit Limit
     * @return array Array of contacts
     */
    public function search_contacts($query, $limit = 20)
    {
        return $this->db->where('trip_type', 'Contact Form')
                       ->where('is_deleted', 0)
                       ->group_start()
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
     * Get contacts by email
     * @param string $email Customer email
     * @return array Array of contacts
     */
    public function get_contacts_by_email($email)
    {
        return $this->db->where('trip_type', 'Contact Form')
                       ->where('email', $email)
                       ->where('is_deleted', 0)
                       ->order_by('created_at', 'DESC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Update contact status by ID
     * @param int $id Contact ID
     * @param string $status New status
     * @return bool Success
     */
    public function update_status($id, $status)
    {
        $valid_statuses = ['new', 'read', 'replied', 'closed'];
        
        if (!in_array($status, $valid_statuses)) {
            return false;
        }
        
        $contact = $this->get_contact($id);
        if (!$contact) {
            return false;
        }
        
        return $this->db->where('id', $id)
                       ->update($this->table, [
                            'status' => $status,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    }

    /**
     * Update contact status by UID
     * @param string $uid Contact UID
     * @param string $status New status
     * @return bool Success
     */
    public function update_status_by_uid($uid, $status)
    {
        $valid_statuses = ['new', 'read', 'replied', 'closed'];
        
        if (!in_array($status, $valid_statuses)) {
            return false;
        }
        
        $contact = $this->get_contact_by_uid($uid);
        if (!$contact) {
            return false;
        }
        
        return $this->db->where('uid', $uid)
                       ->update($this->table, [
                            'status' => $status,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    }

    /**
     * Mark contact as read by ID
     * @param int $id Contact ID
     * @return bool Success
     */
    public function mark_as_read($id)
    {
        $contact = $this->get_contact($id);
        if ($contact && $contact->status === 'new') {
            return $this->update_status($id, 'read');
        }
        return true;
    }

    /**
     * Mark contact as read by UID
     * @param string $uid Contact UID
     * @return bool Success
     */
    public function mark_as_read_by_uid($uid)
    {
        $contact = $this->get_contact_by_uid($uid);
        if ($contact && $contact->status === 'new') {
            return $this->update_status_by_uid($uid, 'read');
        }
        return true;
    }

    /**
     * Add note to contact by ID
     * @param int $contact_id Contact ID
     * @param string $note Note content
     * @param int $admin_id Admin user ID
     * @return bool Success
     */
    public function add_note($contact_id, $note, $admin_id = null)
    {
        $contact = $this->get_contact($contact_id);
        if (!$contact) {
            return false;
        }
        
        $existing_notes = !empty($contact->admin_notes) ? json_decode($contact->admin_notes, true) : [];
        if (!is_array($existing_notes)) {
            $existing_notes = [];
        }
        
        $existing_notes[] = [
            'note' => $note,
            'admin_id' => $admin_id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->where('id', $contact_id)
                       ->update($this->table, [
                            'admin_notes' => json_encode($existing_notes),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    }

    /**
     * Add note to contact by UID
     * @param string $uid Contact UID
     * @param string $note Note content
     * @param int $admin_id Admin user ID
     * @return bool Success
     */
    public function add_note_by_uid($uid, $note, $admin_id = null)
    {
        $contact = $this->get_contact_by_uid($uid);
        if (!$contact) {
            return false;
        }
        
        return $this->add_note($contact->id, $note, $admin_id);
    }

    /**
     * Get notes for contact
     * @param int $contact_id Contact ID
     * @return array Array of notes
     */
    public function get_notes($contact_id)
    {
        $contact = $this->get_contact($contact_id);
        if (!$contact || empty($contact->admin_notes)) {
            return [];
        }
        
        $notes = json_decode($contact->admin_notes, true);
        return is_array($notes) ? $notes : [];
    }

    /**
     * Get notes for contact by UID
     * @param string $uid Contact UID
     * @return array Array of notes
     */
    public function get_notes_by_uid($uid)
    {
        $contact = $this->get_contact_by_uid($uid);
        if (!$contact || empty($contact->admin_notes)) {
            return [];
        }
        
        $notes = json_decode($contact->admin_notes, true);
        return is_array($notes) ? $notes : [];
    }

    /**
     * Delete contact (soft delete) by ID
     * @param int $id Contact ID
     * @return bool Success
     */
    public function delete_contact($id)
    {
        return $this->db->where('id', $id)
                       ->where('trip_type', 'Contact Form')
                       ->update($this->table, [
                            'is_deleted' => 1,
                            'deleted_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    }

    /**
     * Delete contact (soft delete) by UID
     * @param string $uid Contact UID
     * @return bool Success
     */
    public function delete_contact_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->where('trip_type', 'Contact Form')
                       ->update($this->table, [
                            'is_deleted' => 1,
                            'deleted_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    }

    /**
     * Get contacts by date range
     * @param string $start_date Start date
     * @param string $end_date End date
     * @return array Array of contacts
     */
    public function get_contacts_by_date_range($start_date, $end_date)
    {
        return $this->db->where('trip_type', 'Contact Form')
                       ->where('is_deleted', 0)
                       ->where('created_at >=', $start_date)
                       ->where('created_at <=', $end_date)
                       ->order_by('created_at', 'DESC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get recent contacts for dashboard
     * @param int $limit Number of contacts
     * @return array Array of contacts
     */
    public function get_recent_contacts($limit = 5)
    {
        return $this->db->where('trip_type', 'Contact Form')
                       ->where('is_deleted', 0)
                       ->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get contacts for export
     * @param string $status Filter by status
     * @return array Array of contacts
     */
    public function get_contacts_for_export($status = null)
    {
        $this->db->where('trip_type', 'Contact Form');
        $this->db->where('is_deleted', 0);
        
        if ($status && $status !== 'all') {
            $this->db->where('status', $status);
        }
        
        return $this->db->order_by('created_at', 'DESC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Update contact data
     * @param int $id Contact ID
     * @param array $data Data to update
     * @return bool Success
     */
    public function update_contact($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('id', $id)
                       ->where('trip_type', 'Contact Form')
                       ->update($this->table, $data);
    }

    /**
     * Update contact data by UID
     * @param string $uid Contact UID
     * @param array $data Data to update
     * @return bool Success
     */
    public function update_contact_by_uid($uid, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('uid', $uid)
                       ->where('trip_type', 'Contact Form')
                       ->update($this->table, $data);
    }

    /**
     * Count unread contact messages
     * @return int Count of unread messages
     */
    public function count_unread()
    {
        return $this->db->where('trip_type', 'Contact Form')
                       ->where('is_deleted', 0)
                       ->where('status', 'new')
                       ->count_all_results($this->table);
    }
}
