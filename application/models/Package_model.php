<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package_model extends CI_Model {

    private $packages_table = 'safari_packages';
    private $pricing_table = 'package_pricing';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Generate a unique UID
     * @return string Unique UID in format xxxx-xxxx-xxxx
     */
    public function generate_uid()
    {
        $uid = $this->create_uid();
        while ($this->db->where('uid', $uid)->count_all_results($this->packages_table) > 0) {
            $uid = $this->create_uid();
        }
        return $uid;
    }

    /**
     * Create a UID string
     * @return string UID in format xxxx-xxxx-xxxx
     */
    private function create_uid()
    {
        return bin2hex(openssl_random_pseudo_bytes(2)) . '-' . 
               bin2hex(openssl_random_pseudo_bytes(2)) . '-' . 
               bin2hex(openssl_random_pseudo_bytes(2));
    }

    /**
     * Get all active packages with pricing
     * @param array $options Options (limit, offset, category, featured_only)
     * @return array Array of packages
     */
    public function get_all_packages($options = [])
    {
        $limit = isset($options['limit']) ? $options['limit'] : null;
        $offset = isset($options['offset']) ? $options['offset'] : 0;
        $category = isset($options['category']) ? $options['category'] : null;
        $featured_only = isset($options['featured_only']) ? $options['featured_only'] : false;

        $this->db->select('p.*, 
            pp.base_price, pp.price_per_person, pp.single_supplement, 
            pp.child_discount_percent, pp.min_travelers, pp.max_travelers')
            ->from("{$this->packages_table} as p")
            ->join("{$this->pricing_table} pp", "pp.package_id = p.id AND pp.season = 'mid' AND pp.is_active = 1", 'left')
            ->where('p.is_active', 1);

        if ($featured_only) {
            $this->db->where('p.is_featured', 1);
        }

        if ($category && $category !== 'all') {
            $this->db->where('p.category', $category);
        }

        $this->db->group_by('p.id')
                 ->order_by('p.is_featured', 'DESC')
                 ->order_by('p.duration_days', 'ASC');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        $packages = $this->db->get()->result();

        foreach ($packages as &$package) {
            $package->destinations_array = $this->parse_destinations($package->destinations);
            $package->highlights = $this->get_package_highlights($package);
            $package->badge = $this->get_package_badge($package);
            $package->old_price = $this->calculate_old_price($package->base_price);
            $package->rating = $this->get_package_rating($package->id);
            $package->review_count = $this->get_review_count($package->id);
            $package->filter_categories = $this->get_filter_categories($package);
        }

        return $packages;
    }

    /**
     * Get packages for homepage display
     * @param int $limit Number of packages to display
     * @return array Array of packages
     */
    public function get_homepage_packages($limit = 9)
    {
        return $this->get_all_packages(['limit' => $limit]);
    }

    /**
     * Get featured packages only
     * @param int $limit Number of packages
     * @return array Array of featured packages
     */
    public function get_featured_packages($limit = 6)
    {
        return $this->get_all_packages(['limit' => $limit, 'featured_only' => true]);
    }

    /**
     * Get single package by ID
     * @param int $id Package ID
     * @return object|null Package object
     */
    public function get_package($id)
    {
        $package = $this->db->select('p.*, 
            pp.base_price, pp.price_per_person, pp.single_supplement, 
            pp.child_discount_percent, pp.min_travelers, pp.max_travelers')
            ->from("{$this->packages_table} as p")
            ->join("{$this->pricing_table} pp", "pp.package_id = p.id AND pp.season = 'mid' AND pp.is_active = 1", 'left')
            ->where('p.id', $id)
            ->where('p.is_active', 1)
            ->get()
            ->row();

        if ($package) {
            $package->destinations_array = $this->parse_destinations($package->destinations);
            $package->highlights = $this->get_package_highlights($package);
            $package->badge = $this->get_package_badge($package);
            $package->old_price = $this->calculate_old_price($package->base_price);
            $package->rating = $this->get_package_rating($package->id);
            $package->review_count = $this->get_review_count($package->id);
        }

        return $package;
    }

    /**
     * Get single package by UID
     * @param string $uid Package UID
     * @return object|null Package object
     */
    public function get_package_by_uid($uid)
    {
        $package = $this->db->select('p.*, 
            pp.base_price, pp.price_per_person, pp.single_supplement, 
            pp.child_discount_percent, pp.min_travelers, pp.max_travelers')
            ->from("{$this->packages_table} as p")
            ->join("{$this->pricing_table} pp", "pp.package_id = p.id AND pp.season = 'mid' AND pp.is_active = 1", 'left')
            ->where('p.uid', $uid)
            ->where('p.is_active', 1)
            ->get()
            ->row();

        if ($package) {
            $package->destinations_array = $this->parse_destinations($package->destinations);
            $package->highlights = $this->get_package_highlights($package);
            $package->badge = $this->get_package_badge($package);
            $package->old_price = $this->calculate_old_price($package->base_price);
            $package->rating = $this->get_package_rating($package->id);
            $package->review_count = $this->get_review_count($package->id);
        }

        return $package;
    }

    /**
     * Get single package by slug
     * @param string $slug Package slug
     * @return object|null Package object
     */
    public function get_package_by_slug($slug)
    {
        $package = $this->db->select('p.*, 
            pp.base_price, pp.price_per_person, pp.single_supplement, 
            pp.child_discount_percent, pp.min_travelers, pp.max_travelers')
            ->from("{$this->packages_table} as p")
            ->join("{$this->pricing_table} pp", "pp.package_id = p.id AND pp.season = 'mid' AND pp.is_active = 1", 'left')
            ->where('p.slug', $slug)
            ->where('p.is_active', 1)
            ->get()
            ->row();

        if ($package) {
            $package->destinations_array = $this->parse_destinations($package->destinations);
            $package->highlights = $this->get_package_highlights($package);
            $package->badge = $this->get_package_badge($package);
            $package->old_price = $this->calculate_old_price($package->base_price);
            $package->rating = $this->get_package_rating($package->id);
            $package->review_count = $this->get_review_count($package->id);
        }

        return $package;
    }

    /**
     * Get packages by category
     * @param string $category Category name
     * @param int $limit Limit
     * @return array Array of packages
     */
    public function get_packages_by_category($category, $limit = null)
    {
        // Special case: "popular" means featured packages
        if ($category === 'popular') {
            return $this->get_all_packages(['featured_only' => true, 'limit' => $limit]);
        }
        
        return $this->get_all_packages(['category' => $category, 'limit' => $limit]);
    }

    /**
     * Parse destinations JSON to array
     * @param string $destinations JSON string
     * @return array Destinations array
     */
    private function parse_destinations($destinations)
    {
        if (empty($destinations)) {
            return [];
        }

        $decoded = json_decode($destinations, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Get package highlights based on category and features
     * @param object $package Package object
     * @return array Highlights
     */
    private function get_package_highlights($package)
    {
        $highlights = [];
        
        $destinations = $this->parse_destinations($package->destinations);
        $has_serengeti = in_array('Serengeti', $destinations);
        $has_ngorongoro = in_array('Ngorongoro', $destinations);
        $has_zanzibar = in_array('Zanzibar', $destinations);
        $has_kilimanjaro = in_array('Kilimanjaro', $destinations);

        switch ($package->category) {
            case 'wildlife':
                if ($has_serengeti) $highlights[] = 'Big Five';
                if ($package->duration_days >= 7) $highlights[] = 'Migration';
                $highlights[] = 'Game Drives';
                if ($has_ngorongoro) $highlights[] = 'Crater Tour';
                break;
            
            case 'beach':
                $highlights[] = 'Wildlife Safari';
                if ($has_zanzibar) {
                    $highlights[] = 'Beach Resort';
                    $highlights[] = 'Stone Town';
                }
                break;
            
            case 'mountain':
                if ($has_kilimanjaro) {
                    $highlights[] = '98% Success';
                    $highlights[] = 'Expert Guides';
                    $highlights[] = 'All Gear';
                }
                break;
            
            case 'cultural':
                $highlights[] = 'Maasai Culture';
                $highlights[] = 'Big Five';
                $highlights[] = 'Walking Safari';
                break;
            
            case 'honeymoon':
                $highlights[] = 'Private Safari';
                $highlights[] = 'Romantic Dinners';
                $highlights[] = 'Luxury Camps';
                break;
            
            case 'luxury':
                $highlights[] = 'Complete Tour';
                $highlights[] = 'Luxury Stays';
                $highlights[] = 'Private Guide';
                break;
            
            case 'budget':
                $highlights[] = 'Camping';
                if ($has_ngorongoro) $highlights[] = 'Crater Tour';
                $highlights[] = 'All Meals';
                break;
            
            default:
                $highlights[] = 'Expert Guide';
                $highlights[] = 'All Inclusive';
                $highlights[] = 'Lodge Stay';
        }

        return array_slice($highlights, 0, 3);
    }

    /**
     * Get package badge info
     * @param object $package Package object
     * @return array Badge info (text, class)
     */
    private function get_package_badge($package)
    {
        if ($package->is_featured) {
            switch ($package->category) {
                case 'luxury':
                    return ['text' => '👑 Premium', 'class' => 'badge-premium'];
                case 'budget':
                    return ['text' => '💰 Budget Deal', 'class' => 'badge-budget'];
                case 'beach':
                    return ['text' => '🏖️ Safari + Beach', 'class' => 'badge-beach'];
                case 'mountain':
                    return ['text' => '🏔️ Adventure', 'class' => 'badge-adventure'];
                case 'cultural':
                    return ['text' => '🎭 Cultural', 'class' => 'badge-culture'];
                case 'honeymoon':
                    return ['text' => '💕 Romantic', 'class' => 'badge-premium'];
                default:
                    return ['text' => '🔥 Best Seller', 'class' => 'badge-featured'];
            }
        }

        switch ($package->category) {
            case 'luxury':
                return ['text' => '💎 Ultimate', 'class' => 'badge-ultimate'];
            case 'budget':
                return ['text' => '💰 Best Value', 'class' => 'badge-budget'];
            case 'beach':
                return ['text' => '🏖️ Beach Escape', 'class' => 'badge-beach'];
            case 'mountain':
                return ['text' => '🏔️ Trekking', 'class' => 'badge-adventure'];
            case 'cultural':
                return ['text' => '🎭 Cultural', 'class' => 'badge-culture'];
            case 'honeymoon':
                return ['text' => '💕 Honeymoon', 'class' => 'badge-premium'];
            default:
                return ['text' => '⭐ Top Rated', 'class' => 'badge-value'];
        }
    }

    /**
     * Calculate old/strikethrough price (markup for display)
     * @param float $base_price Base price
     * @return float Old price (10-15% higher)
     */
    private function calculate_old_price($base_price)
    {
        if (!$base_price) return 0;
        $markup = rand(10, 15) / 100;
        return round($base_price * (1 + $markup), -1);
    }

    /**
     * Get package rating (for now returns simulated rating)
     * @param int $package_id Package ID
     * @return float Rating (4.5-5.0)
     */
    private function get_package_rating($package_id)
    {
        $ratings = [4.5, 4.6, 4.7, 4.8, 4.9, 5.0];
        return $ratings[($package_id - 1) % count($ratings)];
    }

    /**
     * Get review count (simulated for now)
     * @param int $package_id Package ID
     * @return int Review count
     */
    private function get_review_count($package_id)
    {
        return 80 + (($package_id * 17) % 220);
    }

    /**
     * Get filter categories for package (for JS filtering)
     * @param object $package Package object
     * @return string Space-separated categories
     */
    private function get_filter_categories($package)
    {
        $categories = [];

        if ($package->is_featured) {
            $categories[] = 'popular';
        }

        switch ($package->category) {
            case 'budget':
                $categories[] = 'budget';
                break;
            case 'luxury':
            case 'honeymoon':
                $categories[] = 'luxury';
                break;
            case 'mountain':
            case 'cultural':
                $categories[] = 'adventure';
                break;
        }

        if ($package->base_price && $package->base_price < 1500) {
            $categories[] = 'budget';
        }
        if ($package->base_price && $package->base_price > 3000) {
            $categories[] = 'luxury';
        }

        return implode(' ', array_unique($categories));
    }

    /**
     * Count total packages
     * @param string $category Optional category filter
     * @return int Count
     */
    public function count_packages($category = null)
    {
        $this->db->where('is_active', 1);
        
        if ($category && $category !== 'all') {
            $this->db->where('category', $category);
        }
        
        return $this->db->count_all_results($this->packages_table);
    }

    /**
     * Get available categories
     * @return array Categories with counts
     */
    public function get_categories()
    {
        return $this->db->select('category, COUNT(*) as count')
                       ->where('is_active', 1)
                       ->group_by('category')
                       ->order_by('count', 'DESC')
                       ->get($this->packages_table)
                       ->result();
    }

    /**
     * Get filter buttons for display (max 6 including "All")
     * @param int $max_filters Maximum filters to show (default 6)
     * @return array Filter buttons with label, icon, key
     */
    public function get_filter_buttons($max_filters = 6)
    {
        $filter_config = [
            'all'       => ['label' => 'All Packages', 'icon' => '', 'priority' => 0],
            'popular'   => ['label' => 'Popular', 'icon' => '🔥', 'priority' => 1],
            'budget'    => ['label' => 'Budget', 'icon' => '💰', 'priority' => 2],
            'luxury'    => ['label' => 'Luxury', 'icon' => '👑', 'priority' => 3],
            'wildlife'  => ['label' => 'Wildlife', 'icon' => '🦁', 'priority' => 4],
            'beach'     => ['label' => 'Beach', 'icon' => '🏖️', 'priority' => 5],
            'mountain'  => ['label' => 'Adventure', 'icon' => '🏔️', 'priority' => 6],
            'cultural'  => ['label' => 'Cultural', 'icon' => '🎭', 'priority' => 7],
            'honeymoon' => ['label' => 'Honeymoon', 'icon' => '💕', 'priority' => 8],
        ];

        // Get categories that actually have packages
        $db_categories = $this->db->select('category, COUNT(*) as count')
                                  ->where('is_active', 1)
                                  ->group_by('category')
                                  ->having('count >', 0)
                                  ->get($this->packages_table)
                                  ->result();

        $available_categories = [];
        foreach ($db_categories as $cat) {
            $available_categories[$cat->category] = (int)$cat->count;
        }

        // Check if we have featured packages for "popular" filter
        $featured_count = $this->db->where('is_active', 1)
                                   ->where('is_featured', 1)
                                   ->count_all_results($this->packages_table);

        // Build filters array
        $filters = [];
        
        // Always add "All" first
        $filters[] = [
            'key' => 'all',
            'label' => 'All Packages',
            'icon' => '',
            'count' => array_sum($available_categories),
            'priority' => 0
        ];

        // Add "Popular" if we have featured packages
        if ($featured_count > 0) {
            $filters[] = [
                'key' => 'popular',
                'label' => 'Popular',
                'icon' => '🔥',
                'count' => $featured_count,
                'priority' => 1
            ];
        }

        // Add category-based filters
        foreach ($available_categories as $category => $count) {
            if (isset($filter_config[$category])) {
                $config = $filter_config[$category];
                $filters[] = [
                    'key' => $category,
                    'label' => $config['label'],
                    'icon' => $config['icon'],
                    'count' => $count,
                    'priority' => $config['priority']
                ];
            }
        }

        // Sort by priority
        usort($filters, function($a, $b) {
            return $a['priority'] - $b['priority'];
        });

        // Limit to max filters
        return array_slice($filters, 0, $max_filters);
    }

    /**
     * Get filter categories for package (enhanced version)
     * @param object $package Package object
     * @return string Space-separated categories for filtering
     */
    public function get_filter_categories_enhanced($package)
    {
        $categories = [];

        // Add the actual category
        if (!empty($package->category)) {
            $categories[] = $package->category;
        }

        // Featured packages get "popular"
        if ($package->is_featured) {
            $categories[] = 'popular';
        }

        // Price-based categories (as secondary)
        if ($package->base_price) {
            if ($package->base_price <= 1200) {
                $categories[] = 'budget';
            }
            if ($package->base_price >= 3500) {
                $categories[] = 'luxury';
            }
        }

        // Map mountain to adventure for filtering
        if ($package->category === 'mountain') {
            $categories[] = 'adventure';
        }

        return implode(' ', array_unique($categories));
    }

    /**
     * Get related packages (same category, exclude current)
     * @param int $current_id Current package ID to exclude
     * @param string $category Category to match
     * @param int $limit Number of packages to return
     * @return array Related packages
     */
    public function get_related_packages($current_id, $category, $limit = 3)
    {
        $packages = $this->db->select('p.*, 
            pp.base_price, pp.price_per_person, pp.single_supplement, 
            pp.child_discount_percent, pp.min_travelers, pp.max_travelers')
            ->from("{$this->packages_table} as p")
            ->join("{$this->pricing_table} pp", "pp.package_id = p.id AND pp.season = 'mid' AND pp.is_active = 1", 'left')
            ->where('p.is_active', 1)
            ->where('p.id !=', $current_id)
            ->where('p.category', $category)
            ->order_by('p.is_featured', 'DESC')
            ->limit($limit)
            ->get()
            ->result();

        // If not enough in same category, get from other categories
        if (count($packages) < $limit) {
            $remaining = $limit - count($packages);
            $exclude_ids = array_merge([$current_id], array_column($packages, 'id'));
            
            $more = $this->db->select('p.*, 
                pp.base_price, pp.price_per_person, pp.single_supplement, 
                pp.child_discount_percent, pp.min_travelers, pp.max_travelers')
                ->from("{$this->packages_table} as p")
                ->join("{$this->pricing_table} pp", "pp.package_id = p.id AND pp.season = 'mid' AND pp.is_active = 1", 'left')
                ->where('p.is_active', 1)
                ->where_not_in('p.id', $exclude_ids)
                ->order_by('p.is_featured', 'DESC')
                ->limit($remaining)
                ->get()
                ->result();
            
            $packages = array_merge($packages, $more);
        }

        foreach ($packages as &$package) {
            $package->destinations_array = $this->parse_destinations($package->destinations);
            $package->highlights = $this->get_package_highlights($package);
            $package->badge = $this->get_package_badge($package);
            $package->old_price = $this->calculate_old_price($package->base_price);
            $package->rating = $this->get_package_rating($package->id);
            $package->review_count = $this->get_review_count($package->id);
        }

        return $packages;
    }

    /**
     * Get package image URL
     * @param object $package Package object
     * @return string Image URL
     */
    public function get_package_image($package)
    {
        if (!empty($package->image)) {
            return base_url('assets/img/packages/' . $package->image);
        }

        $category_images = [
            'wildlife' => 'destinations/osiram_safari_adventures_package_1-01.jpg',
            'beach' => 'destinations/osiram_safari_adventure_zanzibar-01.jpg',
            'mountain' => 'kilimanjaro.jpg',
            'cultural' => 'destinations/osiram_safari_adventures_maasai_culture-01.jpg',
            'honeymoon' => 'destinations/osiram_safari_adventure_great_migration-01.jpg',
            'luxury' => 'destinations/osiram_safari_adventure_14_days_package-01.jpg',
            'budget' => 'ngorongoro.jpg'
        ];

        $image = isset($category_images[$package->category]) 
            ? $category_images[$package->category] 
            : 'destinations/osiram_safari_adventures_package_1-01.jpg';

        return base_url('assets/img/' . $image);
    }

    /**
     * Generate star rating HTML
     * @param float $rating Rating value
     * @return string HTML stars
     */
    public function get_stars_html($rating)
    {
        $full_stars = floor($rating);
        $half_star = ($rating - $full_stars) >= 0.5;
        $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);

        $html = str_repeat('★', $full_stars);
        if ($half_star) $html .= '★';
        $html .= str_repeat('☆', $empty_stars);

        return $html;
    }

    /**
     * Format price for display
     * @param float $price Price value
     * @return string Formatted price
     */
    public function format_price($price)
    {
        return '$' . number_format($price, 0);
    }

    /**
     * Search packages based on filters (Tour Finder)
     * @param array $filters Search filters (destination, travelers, date)
     * @return array Matching packages
     */
    public function search_packages($filters = [])
    {
        $destination = isset($filters['destination']) ? $filters['destination'] : '';
        $travelers = isset($filters['travelers']) ? $filters['travelers'] : '';
        
        $this->db->select('p.*, 
            pp.base_price, pp.price_per_person, pp.single_supplement, 
            pp.child_discount_percent, pp.min_travelers, pp.max_travelers')
            ->from("{$this->packages_table} as p")
            ->join("{$this->pricing_table} pp", "pp.package_id = p.id AND pp.season = 'mid' AND pp.is_active = 1", 'left')
            ->where('p.is_active', 1);

        // Filter by destination (search in destinations JSON field)
        if (!empty($destination)) {
            $this->db->like('p.destinations', $destination);
        }

        // Filter by travelers (check max_travelers in pricing)
        if (!empty($travelers)) {
            $traveler_count = ($travelers === '6+') ? 6 : (int)$travelers;
            $this->db->where('pp.max_travelers >=', $traveler_count);
        }

        $this->db->group_by('p.id')
                 ->order_by('p.is_featured', 'DESC')
                 ->order_by('p.duration_days', 'ASC');

        $packages = $this->db->get()->result();

        // Enrich packages with additional data
        foreach ($packages as &$package) {
            $package->destinations_array = $this->parse_destinations($package->destinations);
            $package->highlights = $this->get_package_highlights($package);
            $package->badge = $this->get_package_badge($package);
            $package->old_price = $this->calculate_old_price($package->base_price);
            $package->rating = $this->get_package_rating($package->id);
            $package->review_count = $this->get_review_count($package->id);
            $package->filter_categories = $this->get_filter_categories($package);
        }

        return $packages;
    }

    // ============================================
    // ADMIN METHODS
    // ============================================

    /**
     * Get ALL packages for admin (including inactive)
     * @return array All packages
     */
    public function get_all_packages_admin()
    {
        $packages = $this->db->select('p.*, 
            pp.base_price, pp.price_per_person, pp.single_supplement')
            ->from("{$this->packages_table} as p")
            ->join("{$this->pricing_table} pp", "pp.package_id = p.id AND pp.season = 'mid'", 'left')
            ->group_by('p.id')
            ->order_by('p.id', 'DESC')
            ->get()
            ->result();

        return $packages;
    }

    /**
     * Get single package for admin (including inactive)
     * @param int $id Package ID
     * @return object|null Package object
     */
    public function get_package_admin($id)
    {
        return $this->db->where('id', $id)
                        ->get($this->packages_table)
                        ->row();
    }

    /**
     * Get single package for admin by UID (including inactive)
     * @param string $uid Package UID
     * @return object|null Package object
     */
    public function get_package_admin_by_uid($uid)
    {
        return $this->db->where('uid', $uid)
                        ->get($this->packages_table)
                        ->row();
    }

    /**
     * Create a new package
     * @param array $data Package data
     * @return int|bool Insert ID or false
     */
    public function create_package($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        // Generate UID if not provided
        if (!isset($data['uid']) || empty($data['uid'])) {
            $data['uid'] = $this->generate_uid();
        }
        
        if ($this->db->insert($this->packages_table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Update a package
     * @param int $id Package ID
     * @param array $data Package data
     * @return bool Success
     */
    public function update_package($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('id', $id)
                        ->update($this->packages_table, $data);
    }

    /**
     * Soft delete a package (set is_active = 0)
     * @param int $id Package ID
     * @return bool Success
     */
    public function delete_package($id)
    {
        return $this->db->where('id', $id)
                        ->update($this->packages_table, [
                            'is_active' => 0,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    }

    /**
     * Toggle featured status
     * @param int $id Package ID
     * @return array Status info
     */
    public function toggle_featured($id)
    {
        $package = $this->get_package_admin($id);
        if (!$package) {
            return ['success' => false, 'message' => 'Package not found'];
        }

        $new_status = $package->is_featured ? 0 : 1;
        
        $updated = $this->db->where('id', $id)
                            ->update($this->packages_table, [
                                'is_featured' => $new_status,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);

        return [
            'success' => $updated,
            'is_featured' => $new_status,
            'message' => $updated ? 'Featured status updated' : 'Update failed'
        ];
    }

    /**
     * Toggle active status
     * @param int $id Package ID
     * @return array Status info
     */
    public function toggle_active($id)
    {
        $package = $this->get_package_admin($id);
        if (!$package) {
            return ['success' => false, 'message' => 'Package not found'];
        }

        $new_status = $package->is_active ? 0 : 1;
        
        $updated = $this->db->where('id', $id)
                            ->update($this->packages_table, [
                                'is_active' => $new_status,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);

        return [
            'success' => $updated,
            'is_active' => $new_status,
            'message' => $updated ? 'Status updated' : 'Update failed'
        ];
    }

    /**
     * Get pricing for a package
     * @param int $package_id Package ID
     * @return array Pricing records
     */
    public function get_pricing($package_id)
    {
        return $this->db->where('package_id', $package_id)
                        ->order_by('season', 'ASC')
                        ->get($this->pricing_table)
                        ->result();
    }

    /**
     * Get pricing for a package by season
     * @param int $package_id Package ID
     * @param string $season Season (low, mid, high)
     * @return object|null Pricing record
     */
    public function get_pricing_by_season($package_id, $season = 'mid')
    {
        return $this->db->where('package_id', $package_id)
                        ->where('season', $season)
                        ->get($this->pricing_table)
                        ->row();
    }

    /**
     * Save/update pricing for a package
     * @param int $package_id Package ID
     * @param array $pricing_data Pricing data
     * @return bool Success
     */
    public function save_pricing($package_id, $pricing_data)
    {
        $existing = $this->get_pricing_by_season($package_id, 'mid');
        
        $data = [
            'package_id' => $package_id,
            'season' => 'mid',
            'base_price' => isset($pricing_data['base_price']) ? $pricing_data['base_price'] : 0,
            'price_per_person' => isset($pricing_data['price_per_person']) ? $pricing_data['price_per_person'] : 0,
            'single_supplement' => isset($pricing_data['single_supplement']) ? $pricing_data['single_supplement'] : 0,
            'child_discount_percent' => isset($pricing_data['child_discount_percent']) ? $pricing_data['child_discount_percent'] : 0,
            'min_travelers' => isset($pricing_data['min_travelers']) ? $pricing_data['min_travelers'] : 1,
            'max_travelers' => isset($pricing_data['max_travelers']) ? $pricing_data['max_travelers'] : 20,
            'is_active' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($existing) {
            return $this->db->where('id', $existing->id)
                            ->update($this->pricing_table, $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            return $this->db->insert($this->pricing_table, $data);
        }
    }

    /**
     * Check if slug exists (for unique validation)
     * @param string $slug Slug to check
     * @param int $exclude_id ID to exclude (for updates)
     * @return bool Exists
     */
    public function slug_exists($slug, $exclude_id = null)
    {
        $this->db->where('slug', $slug);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->packages_table) > 0;
    }

    /**
     * Generate unique slug from name
     * @param string $name Package name
     * @param int $exclude_id ID to exclude
     * @return string Unique slug
     */
    public function generate_slug($name, $exclude_id = null)
    {
        $slug = url_title($name, 'dash', TRUE);
        $original_slug = $slug;
        $counter = 1;

        while ($this->slug_exists($slug, $exclude_id)) {
            $slug = $original_slug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
