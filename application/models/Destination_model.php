<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destination_model extends CI_Model {

    private $table = 'safari_destinations';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all destinations
     */
    public function get_all($limit = 50, $offset = 0)
    {
        return $this->db->order_by('name', 'ASC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get all active destinations (alias for frontend)
     */
    public function get_all_destinations()
    {
        return $this->get_active();
    }

    /**
     * Get total count
     */
    public function get_count()
    {
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get destination by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get destination by UID
     */
    public function get_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                       ->get($this->table)
                       ->row();
    }

    /**
     * Get active destinations
     */
    public function get_active($limit = 50, $offset = 0)
    {
        return $this->db->where('is_active', 1)
                       ->order_by('name', 'ASC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Create destination
     */
    public function create($data)
    {
        // Generate UID if not provided
        if (!isset($data['uid'])) {
            $data['uid'] = $this->generate_uid();
        }
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        if (!isset($data['updated_at'])) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update destination by UID
     */
    public function update($uid, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('uid', $uid)
                       ->update($this->table, $data);
    }

    /**
     * Delete destination by UID
     */
    public function delete($uid)
    {
        return $this->db->where('uid', $uid)
                       ->delete($this->table);
    }

    /**
     * Check if name exists
     */
    public function name_exists($name, $exclude_id = null)
    {
        $this->db->where('name', $name);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Search destinations
     */
    public function search($keyword, $limit = 50, $offset = 0)
    {
        return $this->db->group_start()
                       ->like('name', $keyword)
                       ->or_like('description', $keyword)
                       ->or_like('country', $keyword)
                       ->group_end()
                       ->order_by('name', 'ASC')
                       ->limit($limit, $offset)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get search count
     */
    public function get_search_count($keyword)
    {
        return $this->db->group_start()
                       ->like('name', $keyword)
                       ->or_like('description', $keyword)
                       ->or_like('country', $keyword)
                       ->group_end()
                       ->count_all_results($this->table);
    }

    /**
     * Get destinations by country
     */
    public function get_by_country($country, $limit = 50)
    {
        return $this->db->where('country', $country)
                       ->where('is_active', 1)
                       ->order_by('name', 'ASC')
                       ->limit($limit)
                       ->get($this->table)
                       ->result();
    }

    /**
     * Get unique countries
     */
    public function get_countries()
    {
        return $this->db->select('DISTINCT(country) as country')
                       ->where('is_active', 1)
                       ->order_by('country', 'ASC')
                       ->get($this->table)
                       ->result();
    }

    /**
     * Toggle active status by UID
     */
    public function toggle_active($uid, $status)
    {
        return $this->db->where('uid', $uid)
                       ->update($this->table, ['is_active' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    /**
     * Get destinations for navigation menu
     */
    public function get_nav_destinations($limit = 6)
    {
        $has_featured = $this->column_exists('is_featured');
        $has_order = $this->column_exists('display_order');
        
        $this->db->where('is_active', 1);
        
        if ($has_featured) {
            $this->db->order_by('is_featured', 'DESC');
        }
        if ($has_order) {
            $this->db->order_by('display_order', 'ASC');
        }
        
        $destinations = $this->db->order_by('name', 'ASC')
                                 ->limit($limit)
                                 ->get($this->table)
                                 ->result();
        
        // Add navigation-specific properties
        foreach ($destinations as &$dest) {
            $dest->slug = isset($dest->slug) && !empty($dest->slug) 
                ? $dest->slug 
                : url_title($dest->name, 'dash', TRUE);
            $dest->nav_icon = $this->get_nav_icon($dest->name);
            $dest->nav_label = $this->get_nav_label($dest->name);
        }
        
        return $destinations;
    }

    /**
     * Get navigation icon for destination
     */
    private function get_nav_icon($name)
    {
        $icons = [
            'serengeti' => '🦁',
            'ngorongoro' => '🌋',
            'kilimanjaro' => '🏔️',
            'zanzibar' => '🏝️',
            'tarangire' => '🐘',
            'lake manyara' => '🦩',
            'manyara' => '🦩',
            'ruaha' => '🌿',
            'selous' => '🌍',
            'nyerere' => '🌍',
            'lake natron' => '🦩',
            'katavi' => '🦛',
            'mahale' => '🐒'
        ];
        
        $name_lower = strtolower($name);
        foreach ($icons as $key => $icon) {
            if (strpos($name_lower, $key) !== false) {
                return $icon;
            }
        }
        return '🌍';
    }

    /**
     * Get short navigation label for destination
     */
    private function get_nav_label($name)
    {
        $labels = [
            'serengeti' => 'Great Migration',
            'ngorongoro' => 'Crater Highlands',
            'kilimanjaro' => 'Roof of Africa',
            'zanzibar' => 'Beach Paradise',
            'tarangire' => 'Elephant Haven',
            'lake manyara' => 'Tree Climbing Lions',
            'manyara' => 'Tree Climbing Lions',
            'ruaha' => 'Wild Wilderness',
            'selous' => 'Untouched Safari',
            'nyerere' => 'River Safari',
            'lake natron' => 'Flamingo Lake',
            'katavi' => 'Remote Wilderness',
            'mahale' => 'Chimp Trekking'
        ];
        
        $name_lower = strtolower($name);
        foreach ($labels as $key => $label) {
            if (strpos($name_lower, $key) !== false) {
                return $label;
            }
        }
        return 'Safari Destination';
    }

    /**
     * Get featured destinations for homepage (limit 4)
     */
    public function get_featured_destinations($limit = 4)
    {
        // Check if new columns exist
        $has_featured = $this->column_exists('is_featured');
        $has_order = $this->column_exists('display_order');
        
        $this->db->where('is_active', 1);
        
        if ($has_featured) {
            $this->db->order_by('is_featured', 'DESC');
        }
        if ($has_order) {
            $this->db->order_by('display_order', 'ASC');
        }
        
        $destinations = $this->db->order_by('name', 'ASC')
                                 ->limit($limit)
                                 ->get($this->table)
                                 ->result();
        
        // Enrich with computed properties
        foreach ($destinations as &$dest) {
            $dest->slug = isset($dest->slug) && !empty($dest->slug) 
                ? $dest->slug 
                : url_title($dest->name, 'dash', TRUE);
            $dest->rating = isset($dest->rating) ? (float)$dest->rating : 4.8;
            $dest->badge_text = isset($dest->badge_text) ? $dest->badge_text : $this->get_default_badge($dest->name);
            $dest->badge_icon = isset($dest->badge_icon) ? $dest->badge_icon : $this->get_default_badge_icon($dest->name);
            $dest->badge_class = isset($dest->badge_class) ? $dest->badge_class : $this->get_default_badge_class($dest->name);
            $dest->short_description = isset($dest->short_description) && !empty($dest->short_description) 
                ? $dest->short_description 
                : character_limiter($dest->description, 50);
            $dest->location_label = isset($dest->location_label) ? $dest->location_label : $dest->country;
            $dest->duration_label = isset($dest->duration_label) ? $dest->duration_label : '';
        }
        
        return $destinations;
    }

    /**
     * Get destination by slug
     */
    public function get_by_slug($slug)
    {
        // Try slug column first
        if ($this->column_exists('slug')) {
            $result = $this->db->where('slug', $slug)
                               ->where('is_active', 1)
                               ->get($this->table)
                               ->row();
            
            if ($result) {
                return $result;
            }
        }
        
        // Fallback: generate slug from name and match
        $destinations = $this->db->where('is_active', 1)->get($this->table)->result();
        foreach ($destinations as $dest) {
            $generated_slug = url_title($dest->name, 'dash', TRUE);
            if ($generated_slug === $slug) {
                return $dest;
            }
        }
        
        return null;
    }

    /**
     * Enrich destination with computed properties for detail page
     */
    public function enrich_destination($dest)
    {
        // Basic fields
        $dest->slug = isset($dest->slug) && !empty($dest->slug) 
            ? $dest->slug 
            : url_title($dest->name, 'dash', TRUE);
        
        $dest->rating = isset($dest->rating) ? (float)$dest->rating : 4.8;
        
        // Image URL
        $dest->image_url = $this->get_destination_image($dest);
        
        // Badge
        $dest->badge_text = isset($dest->badge_text) ? $dest->badge_text : $this->get_default_badge($dest->name);
        $dest->badge_icon = isset($dest->badge_icon) ? $dest->badge_icon : $this->get_default_badge_icon($dest->name);
        $dest->badge_label = isset($dest->badge_label) ? $dest->badge_label : $this->get_badge_label($dest->name);
        
        // Location
        $dest->location_label = isset($dest->location_label) && !empty($dest->location_label) 
            ? $dest->location_label 
            : $dest->country;
        
        // Duration
        $dest->duration_label = isset($dest->duration_label) ? $dest->duration_label : '';
        
        // Description fields
        $dest->short_description = isset($dest->short_description) && !empty($dest->short_description)
            ? $dest->short_description
            : character_limiter($dest->description, 100);
        
        $dest->intro_text = isset($dest->intro_text) ? $dest->intro_text : null;
        $dest->headline = isset($dest->headline) ? $dest->headline : null;
        $dest->full_description = isset($dest->full_description) ? $dest->full_description : null;
        
        // Info cards content
        $dest->how_to_get_there = isset($dest->how_to_get_there) ? $dest->how_to_get_there : null;
        $dest->wildlife_text = isset($dest->wildlife_text) ? $dest->wildlife_text : null;
        $dest->activities_text = isset($dest->activities_text) ? $dest->activities_text : null;
        $dest->best_time_note = isset($dest->best_time_note) ? $dest->best_time_note : null;
        $dest->area_size = isset($dest->area_size) ? $dest->area_size : null;
        
        // JSON fields - parse if string
        $dest->highlights = $this->parse_json_field($dest, 'highlights');
        $dest->activities = $this->parse_json_field($dest, 'activities');
        $dest->gallery = $this->parse_json_field($dest, 'gallery');
        $dest->stats = $this->parse_json_field($dest, 'stats');
        
        return $dest;
    }

    /**
     * Parse JSON field safely
     */
    private function parse_json_field($dest, $field)
    {
        if (!isset($dest->$field)) {
            return [];
        }
        
        $value = $dest->$field;
        
        if (is_array($value)) {
            return $value;
        }
        
        if (is_string($value) && !empty($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return [];
    }

    /**
     * Get badge label for destination
     */
    private function get_badge_label($name)
    {
        $labels = [
            'serengeti' => 'UNESCO World Heritage',
            'ngorongoro' => 'UNESCO World Heritage',
            'kilimanjaro' => 'Highest Peak in Africa',
            'zanzibar' => 'Tropical Paradise',
            'tarangire' => 'Elephant Country',
            'ruaha' => 'Untouched Wilderness',
            'selous' => 'Africa\'s Largest Reserve',
            'lake manyara' => 'Tree-Climbing Lions'
        ];
        
        $name_lower = strtolower($name);
        foreach ($labels as $key => $label) {
            if (strpos($name_lower, $key) !== false) {
                return $label;
            }
        }
        return 'Safari Destination';
    }

    /**
     * Get related destinations (excluding current)
     */
    public function get_related($exclude_id, $limit = 3)
    {
        $destinations = $this->db->where('is_active', 1)
                                 ->where('id !=', $exclude_id)
                                 ->order_by('RAND()')
                                 ->limit($limit)
                                 ->get($this->table)
                                 ->result();
        
        // Enrich each with slug
        foreach ($destinations as &$dest) {
            $dest->slug = isset($dest->slug) && !empty($dest->slug) 
                ? $dest->slug 
                : url_title($dest->name, 'dash', TRUE);
        }
        
        return $destinations;
    }

    /**
     * Get default badge text based on destination name
     */
    private function get_default_badge($name)
    {
        $badges = [
            'zanzibar' => 'Beach Paradise',
            'serengeti' => 'Most Popular',
            'ngorongoro' => 'Wildlife Haven',
            'kilimanjaro' => 'Adventure',
            'tarangire' => 'Elephant Paradise',
            'lake manyara' => 'Bird Watching',
            'ruaha' => 'Off the Beaten Path',
            'selous' => 'Wilderness',
            'lake natron' => 'Flamingo Haven'
        ];
        
        $name_lower = strtolower($name);
        foreach ($badges as $key => $badge) {
            if (strpos($name_lower, $key) !== false) {
                return $badge;
            }
        }
        return 'Safari Destination';
    }

    /**
     * Get default badge icon based on destination name
     */
    private function get_default_badge_icon($name)
    {
        $icons = [
            'zanzibar' => '🏖️',
            'serengeti' => '🦁',
            'ngorongoro' => '🐆',
            'kilimanjaro' => '🏔️',
            'tarangire' => '🐘',
            'lake manyara' => '🦩',
            'ruaha' => '🌿',
            'selous' => '🌍',
            'lake natron' => '🦩'
        ];
        
        $name_lower = strtolower($name);
        foreach ($icons as $key => $icon) {
            if (strpos($name_lower, $key) !== false) {
                return $icon;
            }
        }
        return '🌍';
    }

    /**
     * Get default badge class based on destination name
     */
    private function get_default_badge_class($name)
    {
        $classes = [
            'zanzibar' => '',
            'serengeti' => 'badge-popular',
            'ngorongoro' => 'badge-wildlife',
            'kilimanjaro' => 'badge-adventure',
            'tarangire' => 'badge-wildlife',
            'ruaha' => 'badge-adventure'
        ];
        
        $name_lower = strtolower($name);
        foreach ($classes as $key => $class) {
            if (strpos($name_lower, $key) !== false) {
                return $class;
            }
        }
        return '';
    }

    /**
     * Get destination image URL
     */
    public function get_destination_image($destination)
    {
        if (!empty($destination->featured_image)) {
            $base_url = function_exists('base_url') ? base_url() : '/';
            
            // If it's already a full URL
            if (strpos($destination->featured_image, 'http') === 0) {
                return $destination->featured_image;
            }
            
            // If it starts with assets/
            if (strpos($destination->featured_image, 'assets/') === 0) {
                return $base_url . $destination->featured_image;
            }
            
            return $base_url . 'assets/img/destinations/' . $destination->featured_image;
        }
        
        // Default image based on destination name
        $defaults = [
            'zanzibar' => 'assets/img/sections/osiram-safari-adventure-zanzibar-dolphin.jpg',
            'serengeti' => 'assets/img/sections/osiram-safari-adventure-serengeti-national-park-migration.jpg',
            'ngorongoro' => 'assets/img/sections/osiram-safari-adventure-ngorongoro-crater.jpg',
            'kilimanjaro' => 'assets/img/sections/osiram-safari-adventure-kilimanjaro-mt.jpg',
            'tarangire' => 'assets/img/sections/osiram-safari-adventure-tarangire-elephant.jpg',
            'lake manyara' => 'assets/img/sections/osiram-safari-adventure-lake-manyara-flamingo.jpg',
            'manyara' => 'assets/img/sections/osiram-safari-adventure-lake-manyara-flamingo.jpg',
            'nyerere' => 'assets/img/sections/osiram-safari-adventure-nyerere-national-park-lion.jpg',
            'selous' => 'assets/img/sections/osiram-safari-adventure-nyerere-national-park-lion.jpg',
            'ruaha' => 'assets/img/destinations/destination-1.jpg',
            'mahale' => 'assets/img/sections/osiram-safari-adventure-mahale-chimpanzee.jpg'
        ];
        
        $base_url = function_exists('base_url') ? base_url() : '/';
        $name_lower = strtolower($destination->name);
        
        foreach ($defaults as $key => $image) {
            if (strpos($name_lower, $key) !== false) {
                return $base_url . $image;
            }
        }
        
        return $base_url . 'assets/img/placeholder-destination.jpg';
    }

    /**
     * Check if a column exists in the table
     */
    private function column_exists($column)
    {
        static $columns = null;
        
        if ($columns === null) {
            $columns = [];
            $result = $this->db->query("SHOW COLUMNS FROM `{$this->table}`");
            if ($result) {
                foreach ($result->result() as $row) {
                    $columns[] = $row->Field;
                }
            }
        }
        
        return in_array($column, $columns);
    }

    /**
     * Generate UUID
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
}
