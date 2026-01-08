<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itinerary_model extends CI_Model {

    private $itinerary_table = 'package_itinerary';
    private $packages_table = 'safari_packages';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Generate a unique UID
     */
    public function generate_uid()
    {
        $uid = $this->create_uid();
        while ($this->db->where('uid', $uid)->count_all_results($this->itinerary_table) > 0) {
            $uid = $this->create_uid();
        }
        return $uid;
    }

    private function create_uid()
    {
        return bin2hex(openssl_random_pseudo_bytes(2)) . '-' . 
               bin2hex(openssl_random_pseudo_bytes(2)) . '-' . 
               bin2hex(openssl_random_pseudo_bytes(2));
    }

    /**
     * Get itinerary days by package ID (public)
     */
    public function get_by_package($package_id)
    {
        return $this->db->where('package_id', $package_id)
                       ->order_by('day_number', 'ASC')
                       ->get($this->itinerary_table)
                       ->result();
    }

    /**
     * Get single itinerary day by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->itinerary_table)
                       ->row();
    }

    /**
     * Get itinerary day by UID
     */
    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->itinerary_table)
                       ->row();
    }

    /**
     * Get all itinerary days for a package
     */
    public function get_days($package_id)
    {
        return $this->db->where('package_id', $package_id)
                       ->order_by('day_number', 'ASC')
                       ->get($this->itinerary_table)
                       ->result();
    }

    /**
     * Get single day by ID
     */
    public function get_day($day_id)
    {
        return $this->db->where('id', $day_id)
                       ->get($this->itinerary_table)
                       ->row();
    }

    /**
     * Get all itinerary entries
     */
    public function get_all()
    {
        return $this->db->order_by('package_id', 'ASC')
                       ->order_by('day_number', 'ASC')
                       ->get($this->itinerary_table)
                       ->result();
    }

    /**
     * Get total count
     */
    public function get_count()
    {
        return $this->db->count_all_results($this->itinerary_table);
    }

    /**
     * ===== ADMIN FUNCTIONS =====
     */

    /**
     * Get all itineraries grouped by package for admin
     */
    public function get_all_itineraries_admin()
    {
        $this->db->select('p.id as package_id, p.uid, p.name as package_name, p.slug, p.duration_days, p.is_active,
                          (SELECT COUNT(*) FROM ' . $this->itinerary_table . ' i WHERE i.package_id = p.id) as day_count');
        $this->db->from($this->packages_table . ' as p');
        $this->db->order_by('p.name', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get all days for a package (admin)
     */
    public function get_package_itinerary($package_id)
    {
        return $this->db->where('package_id', $package_id)
                       ->order_by('day_number', 'ASC')
                       ->get($this->itinerary_table)
                       ->result();
    }

    /**
     * Get single itinerary day by ID
     */
    public function get_itinerary($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->itinerary_table)
                       ->row();
    }

    /**
     * Create itinerary day
     */
    public function create_itinerary_day($data)
    {
        if (!isset($data['uid'])) {
            $data['uid'] = $this->generate_uid();
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->itinerary_table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update itinerary day
     */
    public function update_itinerary_day($id, $data)
    {
        return $this->db->where('id', $id)
                       ->update($this->itinerary_table, $data);
    }

    /**
     * Delete itinerary day
     */
    public function delete_itinerary_day($id)
    {
        return $this->db->where('id', $id)->delete($this->itinerary_table);
    }

    /**
     * Get next day number for package
     */
    public function get_next_day_number($package_id)
    {
        $result = $this->db->select_max('day_number')
                          ->where('package_id', $package_id)
                          ->get($this->itinerary_table)
                          ->row();
        
        return ($result && $result->day_number !== null) ? $result->day_number + 1 : 0;
    }

    /**
     * Get day with package info
     */
    public function get_day_with_itinerary($day_id)
    {
        $this->db->select('i.*, i.package_id');
        $this->db->from($this->itinerary_table . ' i');
        $this->db->where('i.id', $day_id);
        return $this->db->get()->row();
    }

    /**
     * Reorder itinerary days (using UIDs)
     */
    public function reorder_itinerary($package_id, $order_data)
    {
        $this->db->trans_start();
        
        foreach ($order_data as $position => $day_uid) {
            $this->db->where('uid', $day_uid)
                    ->where('package_id', $package_id)
                    ->update($this->itinerary_table, ['day_number' => $position]);
        }
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    /**
     * Search itineraries
     */
    public function search($keyword)
    {
        return $this->db->group_start()
                       ->like('title', $keyword)
                       ->or_like('description', $keyword)
                       ->group_end()
                       ->order_by('package_id', 'ASC')
                       ->order_by('day_number', 'ASC')
                       ->get($this->itinerary_table)
                       ->result();
    }

    /**
     * Get or create - returns package_id for compatibility
     */
    public function get_or_create_itinerary($package_id)
    {
        return (object)['id' => $package_id, 'package_id' => $package_id];
    }
}
