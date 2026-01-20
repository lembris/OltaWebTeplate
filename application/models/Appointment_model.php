<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_model extends CI_Model {

    private $table = 'appointments';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all appointments filtered by theme (admin) - shows content for active theme + 'all'
     */
    public function get_all_by_theme($limit = 50, $offset = 0, $theme = null)
    {
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        return $this->db->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function get_all($limit = 50, $offset = 0)
    {
        return $this->db->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function get_all_admin($limit = 20, $offset = 0, $status = 'all', $search = '', $date_from = '', $date_to = '', $theme = null)
    {
        // Theme filter
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        if ($status !== 'all') {
            $this->db->where('status', $status);
        }
        
        if (!empty($search)) {
            $this->db->group_start()
                     ->like('patient_name', $search)
                     ->or_like('patient_email', $search)
                     ->or_like('patient_phone', $search)
                     ->or_like('uid', $search)
                     ->group_end();
        }
        
        if (!empty($date_from)) {
            $this->db->where('created_at >=', $date_from . ' 00:00:00');
        }
        
        if (!empty($date_to)) {
            $this->db->where('created_at <=', $date_to . ' 23:59:59');
        }
        
        return $this->db->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function count_admin($status = 'all', $search = '', $date_from = '', $date_to = '', $theme = null)
    {
        // Theme filter
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        if ($status !== 'all') {
            $this->db->where('status', $status);
        }
        
        if (!empty($search)) {
            $this->db->group_start()
                     ->like('patient_name', $search)
                     ->or_like('patient_email', $search)
                     ->or_like('patient_phone', $search)
                     ->or_like('uid', $search)
                     ->group_end();
        }
        
        if (!empty($date_from)) {
            $this->db->where('created_at >=', $date_from . ' 00:00:00');
        }
        
        if (!empty($date_to)) {
            $this->db->where('created_at <=', $date_to . ' 23:59:59');
        }
        
        return $this->db->count_all_results($this->table);
    }

    public function get_count($status = null, $theme = null)
    {
        // Theme filter
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        if ($status !== null) {
            return $this->db->where('status', $status)
                           ->count_all_results($this->table);
        }
        return $this->count_all($theme);
    }

    public function get_details($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)
                       ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)
                       ->delete($this->table);
    }

    public function get_for_export($status = 'all', $date_from = '', $date_to = '', $theme = null)
    {
        // Theme filter
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        if ($status !== 'all') {
            $this->db->where('status', $status);
        }
        
        if (!empty($date_from)) {
            $this->db->where('created_at >=', $date_from . ' 00:00:00');
        }
        
        if (!empty($date_to)) {
            $this->db->where('created_at <=', $date_to . ' 23:59:59');
        }
        
        return $this->db->order_by('created_at', 'DESC')
                       ->get($this->table)
                       ->result();
    }

    public function get_pending($limit = 20, $offset = 0, $theme = null)
    {
        // Theme filter
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        return $this->db->where('status', 'pending')
                       ->order_by('created_at', 'ASC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    public function get_by_status($status, $limit = 50, $offset = 0, $theme = null)
    {
        // Theme filter
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        return $this->db->where('status', $status)
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
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

    public function count_all($theme = null)
    {
        // Theme filter
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        return $this->db->count_all_results($this->table);
    }

    public function count_by_status($status, $theme = null)
    {
        // Theme filter
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        return $this->db->where('status', $status)
                       ->count_all_results($this->table);
    }

    public function create($data)
    {
        if (empty($data['uid'])) {
            $data['uid'] = $this->generate_uid();
        }
        
        if (empty($data['booking_ref'])) {
            $data['booking_ref'] = $this->generate_booking_ref();
        }

        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }

        // Set template from active theme if not provided
        if (!isset($data['template'])) {
            $data['template'] = get_active_template();
        }

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function update_by_uid($uid, $data)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, $data);
    }

    public function update_status($uid, $status)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, ['status' => $status]);
    }

    public function assign_to($uid, $assigned_to)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, ['assigned_to' => $assigned_to]);
    }

    public function add_admin_notes($uid, $notes)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, ['admin_notes' => $notes]);
    }

    public function delete_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->delete($this->table);
    }

    public function get_recent($days = 7, $limit = 10, $theme = null)
    {
        // Theme filter
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        $date = date('Y-m-d', strtotime("-{$days} days"));
        return $this->db->where('created_at >=', $date)
                       ->order_by('created_at', 'DESC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    public function get_stats($theme = null)
    {
        // Theme filter
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        return [
            'total' => $this->count_all($theme),
            'pending' => $this->count_by_status('pending', $theme),
            'confirmed' => $this->count_by_status('confirmed', $theme),
            'completed' => $this->count_by_status('completed', $theme),
            'cancelled' => $this->count_by_status('cancelled', $theme)
        ];
    }

    public function search($keyword, $limit = 20, $offset = 0, $theme = null)
    {
        // Theme filter
        if ($theme === null) {
            $theme = get_active_template();
        }
        
        $this->db->group_start()
                 ->where('template', 'all')
                 ->or_where('template', $theme)
                 ->group_end();
        
        $this->db->group_start()
                 ->like('patient_name', $keyword)
                 ->or_like('patient_email', $keyword)
                 ->or_like('patient_phone', $keyword)
                 ->or_like('medical_specialty', $keyword)
                 ->group_end();

        return $this->db->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
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

    private function generate_booking_ref()
    {
        do {
            $number = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $ref = 'CNSLT-' . $number;
        } while ($this->booking_ref_exists($ref));

        return $ref;
    }

    public function booking_ref_exists($ref)
    {
        return $this->db->where('booking_ref', $ref)
                       ->count_all_results($this->table) > 0;
    }

    public function get_statuses()
    {
        return ['pending', 'confirmed', 'completed', 'cancelled', 'no_show'];
    }

    public function get_timelines()
    {
        return ['Emergency', 'Within 1 week', 'Within 1 month', 'Within 3 months', 'Not urgent'];
    }

    public function get_specialties_list()
    {
        return [
            'Not sure' => 'Not sure',
            'Cardiology' => 'Cardiology',
            'Orthopaedic Surgery' => 'Orthopaedic Surgery',
            'Neurology' => 'Neurology',
            'Oncology' => 'Oncology',
            'Pediatrics' => 'Pediatrics',
            'Gynecology' => 'Gynecology',
            'General Surgery' => 'General Surgery',
            'Internal Medicine' => 'Internal Medicine',
            'Psychiatry' => 'Psychiatry',
            'Dermatology' => 'Dermatology',
            'Ophthalmology' => 'Ophthalmology',
            'ENT' => 'ENT (Ear, Nose, Throat)',
            'Urology' => 'Urology',
            'Other' => 'Other specialty'
        ];
    }
}
