<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admission_model extends CI_Model 
{
    protected $table = 'admissions';
    protected $notes_table = 'admission_notes';
    protected $status_history_table = 'admission_status_history';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Generate unique UID
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
     */
    private function generate_reference_number()
    {
        $prefix = 'ADM';
        $year = date('Y');
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        return $prefix . $year . '-' . $random;
    }

    /**
     * Create a new admission application
     */
    public function create($data)
    {
        $data['uid'] = $this->generate_uid();
        $data['reference_number'] = $this->generate_reference_number();
        $data['created_at'] = date('Y-m-d H:i:s');
        
        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }
        
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();
        
        if ($insert_id) {
            $this->log_status_change($insert_id, null, $data['status'], null, 'Application submitted');
        }
        
        return $insert_id;
    }

    /**
     * Get admission by UID
     */
    public function get_by_uid($uid)
    {
        return $this->db->select('a.*, p.name as program_name, p.code as program_code, p.level as program_level, d.name as department_name')
            ->from($this->table . ' a')
            ->join('academic_programs p', 'p.id = a.program_id', 'left')
            ->join('departments d', 'd.id = p.department_id', 'left')
            ->where('a.uid', $uid)
            ->get()
            ->row();
    }

    /**
     * Get admission by ID
     */
    public function get_by_id($id)
    {
        return $this->db->select('a.*, p.name as program_name, p.code as program_code, d.name as department_name')
            ->from($this->table . ' a')
            ->join('academic_programs p', 'p.id = a.program_id', 'left')
            ->join('departments d', 'd.id = p.department_id', 'left')
            ->where('a.id', $id)
            ->get()
            ->row();
    }

    /**
     * Get all admissions with pagination
     */
    public function get_all($limit = 20, $offset = 0, $status = null, $search = null, $program_id = null)
    {
        $this->db->select('a.*, p.name as program_name, p.code as program_code')
            ->from($this->table . ' a')
            ->join('academic_programs p', 'p.id = a.program_id', 'left');

        if ($status && $status !== 'all') {
            $this->db->where('a.status', $status);
        }

        if ($program_id) {
            $this->db->where('a.program_id', $program_id);
        }

        if ($search) {
            $this->db->group_start()
                ->like('a.full_name', $search)
                ->or_like('a.email', $search)
                ->or_like('a.phone', $search)
                ->or_like('a.reference_number', $search)
                ->group_end();
        }

        return $this->db->order_by('a.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count admissions
     */
    public function count_all($status = null, $search = null, $program_id = null)
    {
        $this->db->from($this->table . ' a');

        if ($status && $status !== 'all') {
            $this->db->where('a.status', $status);
        }

        if ($program_id) {
            $this->db->where('a.program_id', $program_id);
        }

        if ($search) {
            $this->db->group_start()
                ->like('a.full_name', $search)
                ->or_like('a.email', $search)
                ->or_like('a.phone', $search)
                ->or_like('a.reference_number', $search)
                ->group_end();
        }

        return $this->db->count_all_results();
    }

    /**
     * Get statistics for dashboard
     */
    public function get_statistics()
    {
        $stats = [
            'total' => 0,
            'pending' => 0,
            'under_review' => 0,
            'accepted' => 0,
            'rejected' => 0,
            'waitlisted' => 0,
            'enrolled' => 0,
            'withdrawn' => 0,
            'unread' => 0,
            'this_month' => 0,
            'this_week' => 0
        ];

        // Count by status
        $result = $this->db->select('status, COUNT(*) as count')
            ->from($this->table)
            ->group_by('status')
            ->get()
            ->result();

        foreach ($result as $row) {
            $stats[$row->status] = (int)$row->count;
            $stats['total'] += (int)$row->count;
        }

        // Count unread
        $stats['unread'] = $this->db->where('is_read', 0)->count_all_results($this->table);

        // Count this month
        $stats['this_month'] = $this->db->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->count_all_results($this->table);

        // Count this week
        $stats['this_week'] = $this->db->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
            ->count_all_results($this->table);

        return $stats;
    }

    /**
     * Update admission by UID
     */
    public function update_by_uid($uid, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('uid', $uid)->update($this->table, $data);
    }

    /**
     * Update status
     */
    public function update_status($id, $new_status, $admin_id = null, $notes = null)
    {
        $admission = $this->get_by_id($id);
        if (!$admission) {
            return false;
        }

        $old_status = $admission->status;
        
        $update_data = [
            'status' => $new_status,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($new_status !== 'pending' && $admin_id) {
            $update_data['reviewed_by'] = $admin_id;
            $update_data['reviewed_at'] = date('Y-m-d H:i:s');
        }

        $result = $this->db->where('id', $id)->update($this->table, $update_data);

        if ($result) {
            $this->log_status_change($id, $old_status, $new_status, $admin_id, $notes);
        }

        return $result;
    }

    /**
     * Log status change (public method for external use)
     */
    public function log_status_change($admission_id, $old_status, $new_status, $admin_id, $notes = null)
    {
        return $this->db->insert($this->status_history_table, [
            'admission_id' => $admission_id,
            'old_status' => $old_status,
            'new_status' => $new_status,
            'changed_by' => $admin_id,
            'notes' => $notes,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Mark as read
     */
    public function mark_as_read($id)
    {
        return $this->db->where('id', $id)->update($this->table, ['is_read' => 1]);
    }

    /**
     * Delete admission by UID
     */
    public function delete_by_uid($uid)
    {
        $admission = $this->get_by_uid($uid);
        if (!$admission) {
            return false;
        }

        // Delete notes
        $this->db->where('admission_id', $admission->id)->delete($this->notes_table);
        
        // Delete status history
        $this->db->where('admission_id', $admission->id)->delete($this->status_history_table);
        
        // Delete admission
        return $this->db->where('uid', $uid)->delete($this->table);
    }

    /**
     * Get notes for an admission
     */
    public function get_notes($admission_id)
    {
        return $this->db->select('n.*, a.full_name as admin_name')
            ->from($this->notes_table . ' n')
            ->join('admin_users a', 'a.id = n.admin_id', 'left')
            ->where('n.admission_id', $admission_id)
            ->order_by('n.created_at', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Add a note
     */
    public function add_note($admission_id, $note, $admin_id)
    {
        return $this->db->insert($this->notes_table, [
            'admission_id' => $admission_id,
            'admin_id' => $admin_id,
            'note' => $note,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get status history
     */
    public function get_status_history($admission_id)
    {
        return $this->db->select('h.*, a.full_name as admin_name')
            ->from($this->status_history_table . ' h')
            ->join('admin_users a', 'a.id = h.changed_by', 'left')
            ->where('h.admission_id', $admission_id)
            ->order_by('h.created_at', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Get admissions for export
     */
    public function get_for_export($status = null, $program_id = null)
    {
        $this->db->select('a.*, p.name as program_name, p.code as program_code')
            ->from($this->table . ' a')
            ->join('academic_programs p', 'p.id = a.program_id', 'left');

        if ($status && $status !== 'all') {
            $this->db->where('a.status', $status);
        }

        if ($program_id) {
            $this->db->where('a.program_id', $program_id);
        }

        return $this->db->order_by('a.created_at', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Check if tables exist, create if not
     */
    public function setup_tables()
    {
        $results = [];

        // Check if admissions table exists
        if (!$this->db->table_exists($this->table)) {
            $sql = file_get_contents(APPPATH . 'sql/admissions_migration.sql');
            if ($sql) {
                $queries = explode(';', $sql);
                foreach ($queries as $query) {
                    $query = trim($query);
                    if (!empty($query) && strpos($query, 'CREATE TABLE') !== false) {
                        $this->db->query($query);
                    }
                }
                $results[] = 'Created admissions tables';
            }
        } else {
            $results[] = 'Admissions tables already exist';
        }

        return $results;
    }

    /**
     * Count admissions by status
     */
    public function count_admissions($status = null)
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get recent admissions for dashboard
     */
    public function get_recent_admissions($limit = 5)
    {
        return $this->db->select('a.*, p.name as program_name, p.code as program_code')
            ->from($this->table . ' a')
            ->join('academic_programs p', 'p.id = a.program_id', 'left')
            ->order_by('a.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }
}
