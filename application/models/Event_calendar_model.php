<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_calendar_model extends CI_Model {

    private $table = 'events_calendar';
    private $registrations_table = 'event_registrations';

    public function __construct()
    {
        parent::__construct();
    }

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

    public function get_all($limit = NULL, $offset = 0)
    {
        $query = $this->db->select('ec.*, d.name as department_name')
                          ->from($this->table . ' ec')
                          ->join('departments d', 'ec.department_id = d.id', 'left')
                          ->order_by('ec.start_date', 'DESC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get()->result();
    }

    public function count_all()
    {
        return $this->db->count_all_results($this->table);
    }

    public function get_by_id($id)
    {
        return $this->db->select('ec.*, d.name as department_name, d.id as dept_id')
                        ->from($this->table . ' ec')
                        ->join('departments d', 'ec.department_id = d.id', 'left')
                        ->where('ec.id', $id)
                        ->get()->row();
    }

    public function get_by_uid($uid)
    {
        return $this->db->select('ec.*, d.name as department_name, d.id as dept_id')
                        ->from($this->table . ' ec')
                        ->join('departments d', 'ec.department_id = d.id', 'left')
                        ->where('ec.uid', $uid)
                        ->get()->row();
    }

    /**
     * Get upcoming events
     */
    public function get_upcoming($limit = 10, $offset = 0)
    {
        $today = date('Y-m-d');
        
        return $this->db->select('ec.*, d.name as department_name')
                        ->from($this->table . ' ec')
                        ->join('departments d', 'ec.department_id = d.id', 'left')
                        ->where('ec.start_date >=', $today)
                        ->where('ec.status', 'upcoming')
                        ->where('ec.visibility', 'public')
                        ->order_by('ec.start_date', 'ASC')
                        ->limit($limit, $offset)
                        ->get()->result();
    }

    public function count_upcoming()
    {
        $today = date('Y-m-d');
        
        return $this->db->where('start_date >=', $today)
                        ->where('status', 'upcoming')
                        ->where('visibility', 'public')
                        ->count_all_results($this->table);
    }

    /**
     * Get featured events
     */
    public function get_featured($limit = 5)
    {
        return $this->db->select('ec.*, d.name as department_name')
                        ->from($this->table . ' ec')
                        ->join('departments d', 'ec.department_id = d.id', 'left')
                        ->where('ec.is_featured', 1)
                        ->where('ec.visibility', 'public')
                        ->order_by('ec.start_date', 'ASC')
                        ->limit($limit)
                        ->get()->result();
    }

    /**
     * Get by type
     */
    public function get_by_type($event_type, $limit = NULL, $offset = 0)
    {
        $query = $this->db->select('ec.*, d.name as department_name')
                          ->from($this->table . ' ec')
                          ->join('departments d', 'ec.department_id = d.id', 'left')
                          ->where('ec.event_type', $event_type)
                          ->where('ec.visibility', 'public')
                          ->order_by('ec.start_date', 'DESC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get()->result();
    }

    public function count_by_type($event_type)
    {
        return $this->db->where('event_type', $event_type)
                        ->where('visibility', 'public')
                        ->count_all_results($this->table);
    }

    /**
     * Get by department
     */
    public function get_by_department($department_id, $limit = NULL, $offset = 0)
    {
        $query = $this->db->select('ec.*, d.name as department_name')
                          ->from($this->table . ' ec')
                          ->join('departments d', 'ec.department_id = d.id', 'left')
                          ->where('ec.department_id', $department_id)
                          ->order_by('ec.start_date', 'DESC');
        
        if ($limit) {
            $query->limit($limit, $offset);
        }
        
        return $query->get()->result();
    }

    /**
     * Get by date range
     */
    public function get_by_date_range($start_date, $end_date)
    {
        return $this->db->select('ec.*, d.name as department_name')
                        ->from($this->table . ' ec')
                        ->join('departments d', 'ec.department_id = d.id', 'left')
                        ->where('ec.start_date >=', $start_date)
                        ->where('ec.start_date <=', $end_date)
                        ->where('ec.visibility', 'public')
                        ->order_by('ec.start_date', 'ASC')
                        ->get()->result();
    }

    /**
     * Search events
     */
    public function search($keyword, $limit = 20, $offset = 0)
    {
        $this->db->select('ec.*, d.name as department_name')
                 ->from($this->table . ' ec')
                 ->join('departments d', 'ec.department_id = d.id', 'left')
                 ->group_start()
                 ->like('ec.title', $keyword)
                 ->or_like('ec.description', $keyword)
                 ->or_like('ec.location', $keyword)
                 ->group_end()
                 ->where('ec.visibility', 'public')
                 ->order_by('ec.start_date', 'DESC')
                 ->limit($limit, $offset);
        
        return $this->db->get()->result();
    }

    public function get_search_count($keyword)
    {
        $this->db->group_start()
                 ->like('title', $keyword)
                 ->or_like('description', $keyword)
                 ->or_like('location', $keyword)
                 ->group_end()
                 ->where('visibility', 'public');
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Create event
     */
    public function create($data)
    {
        $data['uid'] = $this->generate_uid();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Update event
     */
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function update_by_uid($uid, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('uid', $uid)->update($this->table, $data);
    }

    /**
     * Delete event
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    public function delete_by_uid($uid)
    {
        return $this->db->where('uid', $uid)->delete($this->table);
    }

    /**
     * Toggle status
     */
    public function toggle_status($id, $status)
    {
        return $this->db->where('id', $id)->update($this->table, ['status' => $status]);
    }

    public function toggle_status_by_uid($uid, $status)
    {
        return $this->db->where('uid', $uid)->update($this->table, ['status' => $status]);
    }

    /**
     * Event Registration functions
     */
    public function register_for_event($data)
    {
        $data['uid'] = $this->generate_uid();
        $data['registration_date'] = date('Y-m-d H:i:s');
        
        return $this->db->insert($this->registrations_table, $data);
    }

    public function get_event_registrations($event_id)
    {
        return $this->db->where('event_id', $event_id)
                        ->order_by('registration_date', 'DESC')
                        ->get($this->registrations_table)->result();
    }

    public function count_registrations($event_id)
    {
        return $this->db->where('event_id', $event_id)
                        ->where('attendance_status', 'registered')
                        ->count_all_results($this->registrations_table);
    }

    public function get_registration_by_id($reg_id)
    {
        return $this->db->where('id', $reg_id)->get($this->registrations_table)->row();
    }

    public function get_registration_by_uid($uid)
    {
        return $this->db->where('uid', $uid)->get($this->registrations_table)->row();
    }

    public function update_registration($reg_id, $data)
    {
        return $this->db->where('id', $reg_id)->update($this->registrations_table, $data);
    }

    public function delete_registration($reg_id)
    {
        return $this->db->where('id', $reg_id)->delete($this->registrations_table);
    }

    public function check_email_registered($event_id, $email)
    {
        return $this->db->where('event_id', $event_id)
                        ->where('email', $email)
                        ->where('attendance_status !=', 'cancelled')
                        ->count_all_results($this->registrations_table) > 0;
    }

    /**
     * Get upcoming events for dashboard
     */
    public function get_upcoming_events($limit = 5)
    {
        $today = date('Y-m-d');
        
        return $this->db->select('ec.*, d.name as department_name')
                        ->from($this->table . ' ec')
                        ->join('departments d', 'ec.department_id = d.id', 'left')
                        ->where('ec.start_date >=', $today)
                        ->order_by('ec.start_date', 'ASC')
                        ->limit($limit)
                        ->get()->result();
    }

    /**
     * Count all events
     */
    public function count_events($status = null)
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results($this->table);
    }
}
