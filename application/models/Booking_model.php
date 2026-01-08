<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

    private $bookings_table = 'bookings';
    private $packages_table = 'safari_packages';
    private $pricing_table = 'package_pricing';
    private $availability_table = 'package_availability';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new booking
     * @param array $data Booking data
     * @return int|bool Booking ID on success, false on failure
     */
    public function create_booking($data)
    {
        $data['booking_ref'] = $this->generate_booking_ref();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        // Check if table exists
        if (!$this->db->table_exists($this->bookings_table)) {
            log_message('error', 'Bookings table does not exist');
            return false;
        }

        $this->db->insert($this->bookings_table, $data);
        
        if ($this->db->affected_rows() > 0) {
            $booking_id = $this->db->insert_id();
            
            $this->update_availability(
                $data['package_id'],
                $data['travel_date'],
                $data['travelers_adults'] + $data['travelers_children']
            );
            
            return $booking_id;
        }
        
        log_message('error', 'Failed to insert booking: ' . $this->db->error()['message']);
        return false;
    }

    /**
     * Generate unique booking reference
     * @return string Booking reference (e.g., OSA-2025-12345)
     */
    private function generate_booking_ref()
    {
        $prefix = 'OSA';
        $year = date('Y');
        
        do {
            $random = str_pad(mt_rand(10000, 99999), 5, '0', STR_PAD_LEFT);
            $ref = "{$prefix}-{$year}-{$random}";
            
            $exists = $this->db->where('booking_ref', $ref)
                              ->count_all_results($this->bookings_table);
        } while ($exists > 0);
        
        return $ref;
    }

    /**
     * Get single booking by ID
     * @param int $id Booking ID
     * @return object|null Booking object or null
     */
    public function get_booking($id)
    {
        return $this->db->select('b.*, p.name as package_name, p.slug as package_slug, p.duration_days, p.category, p.image as package_image')
                       ->from("{$this->bookings_table} b")
                       ->join("{$this->packages_table} p", 'p.id = b.package_id', 'left')
                       ->where('b.id', $id)
                       ->get()
                       ->row();
    }

    /**
     * Get booking by reference number
     * @param string $booking_ref Booking reference
     * @return object|null Booking object or null
     */
    public function get_booking_by_ref($booking_ref)
    {
        return $this->db->select('b.*, p.name as package_name, p.slug as package_slug, p.duration_days, p.category, p.image as package_image')
                       ->from("{$this->bookings_table} b")
                       ->join("{$this->packages_table} p", 'p.id = b.package_id', 'left')
                       ->where('b.booking_ref', $booking_ref)
                       ->get()
                       ->row();
    }

    /**
     * Get all bookings by customer email
     * @param string $email Customer email
     * @return array Array of booking objects
     */
    public function get_bookings_by_email($email)
    {
        return $this->db->select('b.*, p.name as package_name, p.slug as package_slug, p.duration_days')
                       ->from("{$this->bookings_table} b")
                       ->join("{$this->packages_table} p", 'p.id = b.package_id', 'left')
                       ->where('b.customer_email', $email)
                       ->order_by('b.created_at', 'DESC')
                       ->get()
                       ->result();
    }

    /**
     * Get available dates for a package in a given month
     * @param int $package_id Package ID
     * @param int $month Month (1-12)
     * @param int $year Year (e.g., 2025)
     * @return array Array of availability data
     */
    public function get_available_dates($package_id, $month, $year)
    {
        $start_date = sprintf('%04d-%02d-01', $year, $month);
        $end_date = date('Y-m-t', strtotime($start_date));
        
        $today = date('Y-m-d');
        if ($start_date < $today) {
            $start_date = $today;
        }

        return $this->db->select('date, spots_available, spots_booked, price_modifier, is_blocked')
                       ->where('package_id', $package_id)
                       ->where('date >=', $start_date)
                       ->where('date <=', $end_date)
                       ->where('is_blocked', 0)
                       ->get($this->availability_table)
                       ->result();
    }

    /**
     * Check if a specific date is available
     * @param int $package_id Package ID
     * @param string $date Date (Y-m-d format)
     * @param int $travelers Number of travelers
     * @return bool|object Availability data or false
     */
    public function check_date_availability($package_id, $date, $travelers = 1)
    {
        $availability = $this->db->where('package_id', $package_id)
                                 ->where('date', $date)
                                 ->where('is_blocked', 0)
                                 ->get($this->availability_table)
                                 ->row();
        
        if (!$availability) {
            return (object)[
                'available' => true,
                'spots_available' => 10,
                'price_modifier' => 1.00
            ];
        }
        
        $spots_remaining = $availability->spots_available - $availability->spots_booked;
        
        if ($spots_remaining >= $travelers) {
            return (object)[
                'available' => true,
                'spots_available' => $spots_remaining,
                'price_modifier' => $availability->price_modifier
            ];
        }
        
        return false;
    }

    /**
     * Update booking status
     * @param int $id Booking ID
     * @param string $status New status
     * @return bool Success
     */
    public function update_booking_status($id, $status)
    {
        $valid_statuses = ['pending', 'confirmed', 'deposit_paid', 'paid', 'cancelled', 'completed'];
        
        if (!in_array($status, $valid_statuses)) {
            return false;
        }
        
        return $this->db->where('id', $id)
                       ->update($this->bookings_table, [
                           'status' => $status,
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Calculate package pricing
     * @param int $package_id Package ID
     * @param string $date Travel date
     * @param int $adults Number of adults
     * @param int $children Number of children
     * @param string $accommodation Accommodation preference
     * @return object|null Pricing breakdown
     */
    public function get_package_pricing($package_id, $date, $adults = 1, $children = 0, $accommodation = 'mid-range')
    {
        $season = $this->get_season_for_date($date);
        
        $pricing = $this->db->where('package_id', $package_id)
                           ->where('season', $season)
                           ->where('is_active', 1)
                           ->get($this->pricing_table)
                           ->row();
        
        if (!$pricing) {
            $pricing = $this->db->where('package_id', $package_id)
                               ->where('season', 'mid')
                               ->where('is_active', 1)
                               ->get($this->pricing_table)
                               ->row();
        }
        
        // If still no pricing, try any available season
        if (!$pricing) {
            $pricing = $this->db->where('package_id', $package_id)
                               ->where('is_active', 1)
                               ->get($this->pricing_table)
                               ->row();
        }
        
        // Fallback: create pricing from package base_price or default values
        if (!$pricing) {
            $package = $this->get_package($package_id);
            if (!$package) {
                return null;
            }
            
            // Use package base_price if available, otherwise use default based on duration
            $base_price = !empty($package->base_price) ? $package->base_price : ($package->duration_days * 400);
            $price_per_person = !empty($package->price_per_person) ? $package->price_per_person : ($base_price * 0.25);
            $single_supplement = !empty($package->single_supplement) ? $package->single_supplement : ($base_price * 0.15);
            $child_discount = !empty($package->child_discount_percent) ? $package->child_discount_percent : 25;
            
            // Create a default pricing object
            $pricing = (object)[
                'base_price' => $base_price,
                'price_per_person' => $price_per_person,
                'single_supplement' => $single_supplement,
                'child_discount_percent' => $child_discount,
                'min_travelers' => 1,
                'max_travelers' => 12
            ];
        }

        $availability = $this->check_date_availability($package_id, $date, $adults + $children);
        $price_modifier = is_object($availability) ? $availability->price_modifier : 1.00;

        $accommodation_modifier = 1.00;
        switch ($accommodation) {
            case 'budget':
                $accommodation_modifier = 0.75;
                break;
            case 'luxury':
                $accommodation_modifier = 1.40;
                break;
        }

        $base = $pricing->base_price * $price_modifier * $accommodation_modifier;
        $per_person = $pricing->price_per_person * $price_modifier * $accommodation_modifier;
        
        $adult_total = $base + ($per_person * ($adults - 1));
        
        $child_discount = $pricing->child_discount_percent / 100;
        $child_price = $per_person * (1 - $child_discount);
        $children_total = $child_price * $children;
        
        $single_supplement = 0;
        if ($adults == 1 && $children == 0) {
            $single_supplement = $pricing->single_supplement * $accommodation_modifier;
        }
        
        $subtotal = $adult_total + $children_total + $single_supplement;
        $total = round($subtotal, 2);

        return (object)[
            'base_price' => round($base, 2),
            'price_per_person' => round($per_person, 2),
            'adult_total' => round($adult_total, 2),
            'child_price' => round($child_price, 2),
            'children_total' => round($children_total, 2),
            'child_discount_percent' => $pricing->child_discount_percent,
            'single_supplement' => round($single_supplement, 2),
            'price_modifier' => $price_modifier,
            'accommodation_modifier' => $accommodation_modifier,
            'season' => $season,
            'total' => $total,
            'min_travelers' => $pricing->min_travelers,
            'max_travelers' => $pricing->max_travelers,
            'currency' => 'USD'
        ];
    }

    /**
     * Determine season for a given date
     * @param string $date Date string
     * @return string Season (low, mid, high, peak)
     */
    private function get_season_for_date($date)
    {
        $month = (int) date('n', strtotime($date));
        
        if (in_array($month, [7, 8, 9, 10])) {
            return 'peak';
        }
        if (in_array($month, [1, 2, 6, 12])) {
            return 'high';
        }
        if (in_array($month, [3, 11])) {
            return 'mid';
        }
        
        return 'low';
    }

    /**
     * Update availability after booking
     * @param int $package_id Package ID
     * @param string $date Travel date
     * @param int $spots Number of spots to book
     * @return bool Success
     */
    private function update_availability($package_id, $date, $spots)
    {
        $existing = $this->db->where('package_id', $package_id)
                             ->where('date', $date)
                             ->get($this->availability_table)
                             ->row();
        
        if ($existing) {
            return $this->db->where('id', $existing->id)
                           ->update($this->availability_table, [
                               'spots_booked' => $existing->spots_booked + $spots,
                               'updated_at' => date('Y-m-d H:i:s')
                           ]);
        }
        
        return $this->db->insert($this->availability_table, [
            'package_id' => $package_id,
            'date' => $date,
            'spots_available' => 10,
            'spots_booked' => $spots,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get all active packages with base pricing
     * @param bool $featured_only Only featured packages
     * @return array Array of packages
     */
    public function get_packages($featured_only = false)
    {
        $this->db->select('sp.*, pp.base_price')
                 ->from("{$this->packages_table} as sp")
                 ->join("{$this->pricing_table} pp", "pp.package_id = sp.id AND pp.season = 'mid' AND pp.is_active = 1", 'left')
                 ->where('sp.is_active', 1);
        
        if ($featured_only) {
            $this->db->where('sp.is_featured', 1);
        }
        
        return $this->db->group_by('sp.id')
                       ->order_by('sp.duration_days', 'ASC')
                       ->get()
                       ->result();
    }

    /**
     * Get single package by ID with base pricing
     * @param int $id Package ID
     * @return object|null Package object
     */
    public function get_package($id)
    {
        $package = $this->db->select('sp.*, pp.base_price, pp.price_per_person, pp.single_supplement, pp.child_discount_percent')
                           ->from("{$this->packages_table} as sp")
                           ->join("{$this->pricing_table} pp", "pp.package_id = sp.id AND pp.season = 'mid' AND pp.is_active = 1", 'left')
                           ->where('sp.id', $id)
                           ->where('sp.is_active', 1)
                           ->get()
                           ->row();
        
        return $package;
    }

    /**
     * Get package by slug
     * @param string $slug Package slug
     * @return object|null Package object
     */
    public function get_package_by_slug($slug)
    {
        return $this->db->where('slug', $slug)
                       ->where('is_active', 1)
                       ->get($this->packages_table)
                       ->row();
    }

    /**
     * Get all bookings (admin)
     * @param int $limit Limit
     * @param int $offset Offset
     * @param string $status Filter by status
     * @return array Array of bookings
     */
    public function get_all_bookings($limit = 20, $offset = 0, $status = null)
    {
        $this->db->select('b.*, p.name as package_name')
                 ->from("{$this->bookings_table} b")
                 ->join("{$this->packages_table} p", 'p.id = b.package_id', 'left');
        
        if ($status) {
            $this->db->where('b.status', $status);
        }
        
        return $this->db->order_by('b.created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get()
                       ->result();
    }

    /**
     * Count all bookings
     * @param string $status Filter by status
     * @return int Count
     */
    public function count_bookings($status = null)
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        
        return $this->db->count_all_results($this->bookings_table);
    }

    /**
     * Mark email as sent
     * @param int $booking_id Booking ID
     * @return bool Success
     */
    public function mark_email_sent($booking_id)
    {
        return $this->db->where('id', $booking_id)
                       ->update($this->bookings_table, [
                           'email_sent' => 1,
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Update booking
     * @param int $id Booking ID
     * @param array $data Data to update
     * @return bool Success
     */
    public function update_booking($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('id', $id)
                       ->update($this->bookings_table, $data);
    }

    /**
     * Get booking statistics
     * @return object Statistics
     */
    public function get_statistics()
    {
        $stats = new stdClass();
        
        $stats->total = $this->count_bookings();
        $stats->pending = $this->count_bookings('pending');
        $stats->confirmed = $this->count_bookings('confirmed');
        $stats->completed = $this->count_bookings('completed');
        $stats->cancelled = $this->count_bookings('cancelled');
        
        $revenue = $this->db->select_sum('total_price')
                           ->where_in('status', ['confirmed', 'deposit_paid', 'paid', 'completed'])
                           ->get($this->bookings_table)
                           ->row();
        $stats->total_revenue = $revenue->total_price ?? 0;
        
        return $stats;
    }

    /**
     * Get all bookings for admin with filters
     * @param int $limit Limit
     * @param int $offset Offset
     * @param string $status Filter by status
     * @param string $search Search term
     * @param string $date_from Date from filter
     * @param string $date_to Date to filter
     * @return array Array of bookings
     */
    public function get_all_bookings_admin($limit = 20, $offset = 0, $status = null, $search = null, $date_from = null, $date_to = null)
    {
        $this->db->select('b.*, p.name as package_name, p.slug as package_slug, p.duration_days, p.category')
                 ->from("{$this->bookings_table} b")
                 ->join("{$this->packages_table} p", 'p.id = b.package_id', 'left')
                 ->where('b.deleted_at IS NULL');
        
        if ($status && $status !== 'all') {
            $this->db->where('b.status', $status);
        }
        
        if ($search) {
            $this->db->group_start()
                     ->like('b.booking_ref', $search)
                     ->or_like('b.customer_name', $search)
                     ->or_like('b.customer_email', $search)
                     ->or_like('b.customer_phone', $search)
                     ->or_like('p.name', $search)
                     ->group_end();
        }
        
        if ($date_from) {
            $this->db->where('b.travel_date >=', $date_from);
        }
        
        if ($date_to) {
            $this->db->where('b.travel_date <=', $date_to);
        }
        
        return $this->db->order_by('b.created_at', 'DESC')
                       ->limit($limit, $offset)
                       ->get()
                       ->result();
    }

    /**
     * Count bookings for admin with filters
     * @param string $status Filter by status
     * @param string $search Search term
     * @param string $date_from Date from filter
     * @param string $date_to Date to filter
     * @return int Count
     */
    public function count_bookings_admin($status = null, $search = null, $date_from = null, $date_to = null)
    {
        $this->db->from($this->bookings_table . ' b')
                 ->join("{$this->packages_table} p", 'p.id = b.package_id', 'left')
                 ->where('b.deleted_at IS NULL');
        
        if ($status && $status !== 'all') {
            $this->db->where('b.status', $status);
        }
        
        if ($search) {
            $this->db->group_start()
                     ->like('b.booking_ref', $search)
                     ->or_like('b.customer_name', $search)
                     ->or_like('b.customer_email', $search)
                     ->or_like('b.customer_phone', $search)
                     ->or_like('p.name', $search)
                     ->group_end();
        }
        
        if ($date_from) {
            $this->db->where('b.travel_date >=', $date_from);
        }
        
        if ($date_to) {
            $this->db->where('b.travel_date <=', $date_to);
        }
        
        return $this->db->count_all_results();
    }

    /**
     * Get recent bookings for dashboard
     * @param int $limit Number of bookings to return
     * @return array Array of bookings
     */
    public function get_recent_bookings($limit = 5)
    {
        return $this->db->select('b.*, p.name as package_name')
                       ->from("{$this->bookings_table} b")
                       ->join("{$this->packages_table} p", 'p.id = b.package_id', 'left')
                       ->where('b.deleted_at IS NULL')
                       ->order_by('b.created_at', 'DESC')
                       ->limit($limit)
                       ->get()
                       ->result();
    }

    /**
     * Get booking count by status (excludes soft deleted)
     * @param string $status Status to count
     * @return int Count
     */
    public function get_booking_count($status = null)
    {
        $this->db->where('deleted_at IS NULL');
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        return $this->db->count_all_results($this->bookings_table);
    }

    /**
     * Soft delete a booking
     * @param int $id Booking ID
     * @return bool Success
     */
    public function delete_booking($id)
    {
        return $this->db->where('id', $id)
                       ->update($this->bookings_table, [
                           'deleted_at' => date('Y-m-d H:i:s'),
                           'updated_at' => date('Y-m-d H:i:s')
                       ]);
    }

    /**
     * Get booking with full details for admin view
     * @param string $uid Booking UID
     * @return object|null Booking object with all details
     */
    public function get_booking_details($uid)
    {
        return $this->db->select('b.*, 
                                  p.name as package_name, 
                                  p.slug as package_slug, 
                                  p.duration_days, 
                                  p.category,
                                  p.image as package_image,
                                  p.destinations,
                                  p.highlights')
                       ->from("{$this->bookings_table} b")
                       ->join("{$this->packages_table} p", 'p.id = b.package_id', 'left')
                       ->where('b.uid', $uid)
                       ->get()
                       ->row();
    }

    /**
     * Get all bookings for export
     * @param string $status Filter by status
     * @param string $date_from Date from filter
     * @param string $date_to Date to filter
     * @return array Array of bookings
     */
    public function get_bookings_for_export($status = null, $date_from = null, $date_to = null)
    {
        $this->db->select('b.booking_ref, b.customer_name, b.customer_email, b.customer_phone, 
                          b.customer_country, p.name as package_name, b.travel_date, 
                          b.travelers_adults, b.travelers_children, b.accommodation_preference,
                          b.total_price, b.status, b.special_requests, b.created_at')
                 ->from("{$this->bookings_table} b")
                 ->join("{$this->packages_table} p", 'p.id = b.package_id', 'left')
                 ->where('b.deleted_at IS NULL');
        
        if ($status && $status !== 'all') {
            $this->db->where('b.status', $status);
        }
        
        if ($date_from) {
            $this->db->where('b.travel_date >=', $date_from);
        }
        
        if ($date_to) {
            $this->db->where('b.travel_date <=', $date_to);
        }
        
        return $this->db->order_by('b.created_at', 'DESC')
                       ->get()
                       ->result();
    }

    /**
     * Add a status history entry (if tracking status changes)
     * @param int $booking_id Booking ID
     * @param string $old_status Previous status
     * @param string $new_status New status
     * @param int $admin_id Admin who made the change
     * @param string $notes Optional notes
     * @return bool Success
     */
    public function add_status_history($booking_id, $old_status, $new_status, $admin_id, $notes = '')
    {
        if ($this->db->table_exists('booking_status_history')) {
            return $this->db->insert('booking_status_history', [
                'booking_id' => $booking_id,
                'old_status' => $old_status,
                'new_status' => $new_status,
                'changed_by' => $admin_id,
                'notes' => $notes,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        return true;
    }

    /**
     * Get status history for a booking
     * @param int $booking_id Booking ID
     * @return array Status history entries
     */
    public function get_status_history($booking_id)
    {
        if (!$this->db->table_exists('booking_status_history')) {
            return [];
        }
        
        // Use COALESCE to handle missing admins gracefully
        return $this->db->select('bsh.*, COALESCE(a.name, "System") as admin_name')
                       ->from('booking_status_history bsh')
                       ->join('admins a', 'a.id = bsh.changed_by', 'left')
                       ->where('bsh.booking_id', $booking_id)
                       ->order_by('bsh.created_at', 'DESC')
                       ->get()
                       ->result();
    }
}
