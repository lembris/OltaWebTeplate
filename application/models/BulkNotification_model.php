<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BulkNotification_model extends CI_Model {

    private $table = 'bulk_notifications';
    private $recipients_table = 'notification_recipients';
    private $templates_table = 'notification_templates';

    public function __construct()
    {
        parent::__construct();
    }

    // ===== NOTIFICATIONS =====

    /**
     * Get all notifications with pagination
     */
    public function get_all($limit = 50, $offset = 0)
    {
        return $this->db->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get notifications by status
     */
    public function get_by_status($status, $limit = 50, $offset = 0)
    {
        return $this->db->where('status', $status)
                       ->order_by('created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get scheduled notifications that need to be sent
     */
    public function get_pending_scheduled()
    {
        return $this->db->where('status', 'scheduled')
                       ->where('scheduled_at <=', date('Y-m-d H:i:s'))
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get notification by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get notification by UID
     */
    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Create notification
     */
    public function create($data)
    {
        if (empty($data['uid'])) {
            $data['uid'] = $this->generate_uid();
        }
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update notification by UID
     */
    public function update_by_uid($uid, $data)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, $data);
    }

    /**
     * Delete notification by UID
     */
    public function delete_by_uid($uid)
    {
        $notification = $this->get_by_uid($uid);
        if ($notification) {
            // Delete recipients first
            $this->db->where('notification_id', $notification->id)->delete($this->recipients_table);
        }
        return $this->db->where('uid', $uid)->delete($this->table);
    }

    /**
     * Update notification status
     */
    public function update_status($id, $status, $additional_data = [])
    {
        $data = array_merge(['status' => $status], $additional_data);
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Increment sent count
     */
    public function increment_sent($id)
    {
        return $this->db->set('sent_count', 'sent_count + 1', FALSE)
                       ->where('id', $id)
                       ->update($this->table);
    }

    /**
     * Increment failed count
     */
    public function increment_failed($id)
    {
        return $this->db->set('failed_count', 'failed_count + 1', FALSE)
                       ->where('id', $id)
                       ->update($this->table);
    }

    /**
     * Get notification statistics
     */
    public function get_stats()
    {
        $stats = [
            'total' => $this->db->count_all_results($this->table),
            'sent' => $this->db->where('status', 'sent')->count_all_results($this->table),
            'scheduled' => $this->db->where('status', 'scheduled')->count_all_results($this->table),
            'draft' => $this->db->where('status', 'draft')->count_all_results($this->table),
            'failed' => $this->db->where('status', 'failed')->count_all_results($this->table),
        ];
        
        // Total recipients sent
        $this->db->select_sum('sent_count');
        $result = $this->db->get($this->table)->row();
        $stats['total_sent'] = $result->sent_count ?? 0;
        
        return $stats;
    }

    // ===== RECIPIENTS =====

    /**
     * Add recipients to a notification
     */
    public function add_recipients($notification_id, $recipients)
    {
        $data = [];
        foreach ($recipients as $recipient) {
            $data[] = [
                'notification_id' => $notification_id,
                'recipient_type' => $recipient['type'] ?? 'other',
                'recipient_id' => $recipient['id'] ?? null,
                'recipient_name' => $recipient['name'] ?? '',
                'recipient_email' => $recipient['email'] ?? '',
                'recipient_phone' => $recipient['phone'] ?? '',
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        
        if (!empty($data)) {
            $this->db->insert_batch($this->recipients_table, $data);
            
            // Update total recipients count
            $this->db->where('id', $notification_id)
                    ->update($this->table, ['total_recipients' => count($data)]);
        }
        
        return count($data);
    }

    /**
     * Get recipients for a notification
     */
    public function get_recipients($notification_id, $status = null)
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->where('notification_id', $notification_id)
                       ->get($this->recipients_table)
                       ->result();
    }

    /**
     * Update recipient status
     */
    public function update_recipient_status($recipient_id, $status, $additional_data = [])
    {
        $data = array_merge(['status' => $status], $additional_data);
        return $this->db->where('id', $recipient_id)
                       ->update($this->recipients_table, $data);
    }

    /**
     * Get recipient counts by status
     */
    public function get_recipient_stats($notification_id)
    {
        $this->db->select('status, COUNT(*) as count')
                ->where('notification_id', $notification_id)
                ->group_by('status');
        
        $results = $this->db->get($this->recipients_table)->result();
        
        $stats = ['pending' => 0, 'sent' => 0, 'failed' => 0, 'opened' => 0, 'bounced' => 0];
        foreach ($results as $row) {
            $stats[$row->status] = $row->count;
        }
        
        return $stats;
    }

    // ===== TEMPLATES =====

    /**
     * Get all active templates
     */
    public function get_templates()
    {
        return $this->db->where('is_active', 1)
                       ->order_by('category', 'ASC')
                       ->order_by('name', 'ASC')
                       ->get($this->templates_table)
                       ->result();
    }

    /**
     * Get template by ID
     */
    public function get_template_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->templates_table)
                       ->row();
    }

    /**
     * Get template by UID
     */
    public function get_template_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->templates_table)
                       ->row();
    }

    /**
     * Create template
     */
    public function create_template($data)
    {
        if (empty($data['uid'])) {
            $data['uid'] = $this->generate_uid();
        }
        
        $this->db->insert($this->templates_table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update template
     */
    public function update_template($id, $data)
    {
        return $this->db->where('id', $id)
                       ->update($this->templates_table, $data);
    }

    /**
     * Delete template
     */
    public function delete_template($id)
    {
        return $this->db->where('id', $id)
                       ->delete($this->templates_table);
    }

    /**
     * Get templates by category
     */
    public function get_templates_by_category($category)
    {
        return $this->db->where('category', $category)
                       ->where('is_active', 1)
                       ->order_by('name', 'ASC')
                       ->get($this->templates_table)
                       ->result();
    }

    /**
     * Get template categories
     */
    public function get_template_categories()
    {
        return $this->db->select('DISTINCT(category) as category', FALSE)
                       ->where('is_active', 1)
                       ->order_by('category', 'ASC')
                       ->get($this->templates_table)
                       ->result();
    }

    // ===== HELPER FUNCTIONS =====

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
     * Get recipients from contact groups
     */
    public function get_recipients_from_groups($group_ids)
    {
        $this->load->model('ContactGroup_model');
        return $this->ContactGroup_model->get_emails_from_groups($group_ids);
    }

    /**
     * Process template variables
     */
    public function process_template($template, $variables)
    {
        $processed = $template;
        foreach ($variables as $key => $value) {
            $processed = str_replace('{{' . $key . '}}', $value, $processed);
        }
        return $processed;
    }
}
