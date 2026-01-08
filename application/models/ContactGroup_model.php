<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactGroup_model extends CI_Model {

    private $table = 'contact_groups';
    private $members_table = 'contact_group_members';

    public function __construct()
    {
        parent::__construct();
    }

    // ===== GROUPS =====

    /**
     * Get all groups
     */
    public function get_all($active_only = false)
    {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        return $this->db->order_by('sort_order', 'ASC')
                       ->order_by('name', 'ASC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get all active groups with member counts
     */
    public function get_all_with_counts()
    {
        $this->db->select('contact_groups.*, COUNT(contact_group_members.id) as member_count');
        $this->db->join($this->members_table, 'contact_group_members.group_id = contact_groups.id AND contact_group_members.is_active = 1', 'left');
        $this->db->group_by('contact_groups.id');
        $this->db->order_by('contact_groups.sort_order', 'ASC');
        
        return $this->db->get($this->table)->result();
    }

    /**
     * Get group by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get group by UID
     */
    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Create group
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
     * Update group
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)
                       ->update($this->table, $data);
    }

    /**
     * Update group by UID
     */
    public function update_by_uid($uid, $data)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, $data);
    }

    /**
     * Delete group
     */
    public function delete($id)
    {
        // Members will be deleted via CASCADE
        return $this->db->where('id', $id)
                       ->delete($this->table);
    }

    /**
     * Delete group by UID
     */
    public function delete_by_uid($uid)
    {
        $group = $this->get_by_uid($uid);
        if ($group) {
            return $this->delete($group->id);
        }
        return false;
    }

    /**
     * Toggle group status
     */
    public function toggle_status($id)
    {
        $group = $this->get_by_id($id);
        if ($group) {
            $new_status = $group->is_active ? 0 : 1;
            return $this->update($id, ['is_active' => $new_status]);
        }
        return false;
    }

    /**
     * Update sort order
     */
    public function update_sort_order($items)
    {
        foreach ($items as $index => $id) {
            $this->db->where('id', $id)
                    ->update($this->table, ['sort_order' => $index]);
        }
        return true;
    }

    // ===== MEMBERS =====

    /**
     * Get members of a group
     */
    public function get_members($group_id, $active_only = true)
    {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        return $this->db->where('group_id', $group_id)
                       ->order_by('name', 'ASC')
                       ->get($this->members_table)
                       ->result();
    }

    /**
     * Get member by ID
     */
    public function get_member_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->members_table)
                       ->row();
    }

    /**
     * Get member by UID
     */
    public function get_member_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->members_table)
                       ->row();
    }

    /**
     * Add member to group
     */
    public function add_member($group_id, $data)
    {
        $data['group_id'] = $group_id;
        $data['uid'] = $this->generate_member_uid();
        $data['created_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert($this->members_table, $data);
        return $this->db->insert_id();
    }

    /**
     * Add multiple members to group
     */
    public function add_members_batch($group_id, $members)
    {
        $data = [];
        foreach ($members as $member) {
            $data[] = [
                'group_id' => $group_id,
                'uid' => $this->generate_member_uid(),
                'name' => $member['name'],
                'email' => $member['email'] ?? null,
                'phone' => $member['phone'] ?? null,
                'designation' => $member['designation'] ?? null,
                'department' => $member['department'] ?? null,
                'notes' => $member['notes'] ?? null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        
        if (!empty($data)) {
            return $this->db->insert_batch($this->members_table, $data);
        }
        return 0;
    }

    /**
     * Update member
     */
    public function update_member($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)
                       ->update($this->members_table, $data);
    }

    /**
     * Update member by UID
     */
    public function update_member_by_uid($uid, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('uid', $uid)
                       ->update($this->members_table, $data);
    }

    /**
     * Delete member
     */
    public function delete_member($id)
    {
        return $this->db->where('id', $id)
                       ->delete($this->members_table);
    }

    /**
     * Delete member by UID
     */
    public function delete_member_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->delete($this->members_table);
    }

    /**
     * Toggle member status
     */
    public function toggle_member_status($id)
    {
        $member = $this->get_member_by_id($id);
        if ($member) {
            $new_status = $member->is_active ? 0 : 1;
            return $this->update_member($id, ['is_active' => $new_status]);
        }
        return false;
    }

    /**
     * Toggle member status by UID
     */
    public function toggle_member_status_by_uid($uid)
    {
        $member = $this->get_member_by_uid($uid);
        if ($member) {
            $new_status = $member->is_active ? 0 : 1;
            return $this->update_member_by_uid($uid, ['is_active' => $new_status]);
        }
        return false;
    }

    /**
     * Get member count for a group
     */
    public function get_member_count($group_id, $active_only = true)
    {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        return $this->db->where('group_id', $group_id)
                       ->count_all_results($this->members_table);
    }

    /**
     * Search members across all groups
     */
    public function search_members($keyword)
    {
        return $this->db->select('contact_group_members.*, contact_groups.name as group_name')
                       ->join($this->table, 'contact_groups.id = contact_group_members.group_id')
                       ->group_start()
                           ->like('contact_group_members.name', $keyword)
                           ->or_like('contact_group_members.email', $keyword)
                           ->or_like('contact_group_members.phone', $keyword)
                       ->group_end()
                       ->where('contact_group_members.is_active', 1)
                       ->get($this->members_table)
                       ->result();
    }

    /**
     * Get all emails from selected groups
     */
    public function get_emails_from_groups($group_ids)
    {
        if (empty($group_ids)) {
            return [];
        }
        
        $ids = is_array($group_ids) ? $group_ids : json_decode($group_ids, true);
        
        return $this->db->select('name, email, phone')
                       ->where_in('group_id', $ids)
                       ->where('is_active', 1)
                       ->where('email IS NOT NULL', null, false)
                       ->where('email !=', '')
                       ->get($this->members_table)
                       ->result();
    }

    /**
     * Import members from CSV data
     */
    public function import_members($group_id, $csv_data)
    {
        $imported = 0;
        $skipped = 0;
        
        foreach ($csv_data as $row) {
            if (empty($row['name']) || (empty($row['email']) && empty($row['phone']))) {
                $skipped++;
                continue;
            }
            
            $this->add_member($group_id, [
                'name' => $row['name'],
                'email' => $row['email'] ?? null,
                'phone' => $row['phone'] ?? null,
                'designation' => $row['designation'] ?? null,
                'department' => $row['department'] ?? null,
                'notes' => $row['notes'] ?? null
            ]);
            $imported++;
        }
        
        return ['imported' => $imported, 'skipped' => $skipped];
    }

    // ===== HELPER FUNCTIONS =====

    /**
     * Generate unique UID for groups
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
     * Generate unique UID for members
     */
    private function generate_member_uid()
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
        } while ($this->member_uid_exists($uid));
        
        return $uid;
    }

    /**
     * Check if UID exists in groups table
     */
    public function uid_exists($uid)
    {
        return $this->db->where('uid', $uid)
                       ->count_all_results($this->table) > 0;
    }

    /**
     * Check if UID exists in members table
     */
    public function member_uid_exists($uid)
    {
        return $this->db->where('uid', $uid)
                       ->count_all_results($this->members_table) > 0;
    }
}
