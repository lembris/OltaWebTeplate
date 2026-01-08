<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitor_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Log a visitor
     */
    public function log_visit($data)
    {
        // Check if tables exist
        if (!$this->db->table_exists('visitors')) {
            return false;
        }

        $this->db->insert('visitors', $data);
        
        // Update popular pages
        $this->update_popular_page($data['page_url'], $data['page_title'] ?? '');
        
        return $this->db->insert_id();
    }

    /**
     * Update popular pages count
     */
    private function update_popular_page($url, $title)
    {
        if (!$this->db->table_exists('popular_pages')) {
            return;
        }

        $existing = $this->db->where('page_url', $url)->get('popular_pages')->row();
        
        if ($existing) {
            $this->db->where('id', $existing->id)
                     ->set('view_count', 'view_count + 1', FALSE)
                     ->set('last_viewed', date('Y-m-d H:i:s'))
                     ->update('popular_pages');
        } else {
            $this->db->insert('popular_pages', [
                'page_url' => $url,
                'page_title' => $title,
                'view_count' => 1,
                'last_viewed' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Get today's stats
     */
    public function get_today_stats()
    {
        if (!$this->db->table_exists('visitors')) {
            return ['total_visits' => 0, 'unique_visitors' => 0, 'page_views' => 0];
        }

        $today = date('Y-m-d');
        
        $stats = $this->db->select('COUNT(*) as page_views, COUNT(DISTINCT ip_address) as unique_visitors')
                          ->where('DATE(visited_at)', $today)
                          ->where('is_bot', 0)
                          ->get('visitors')
                          ->row();
        
        return [
            'page_views' => $stats->page_views ?? 0,
            'unique_visitors' => $stats->unique_visitors ?? 0,
            'total_visits' => $stats->page_views ?? 0
        ];
    }

    /**
     * Get stats for a date range
     */
    public function get_stats_range($start_date, $end_date)
    {
        if (!$this->db->table_exists('visitors')) {
            return [];
        }

        return $this->db->select('DATE(visited_at) as date, COUNT(*) as page_views, COUNT(DISTINCT ip_address) as unique_visitors')
                        ->where('visited_at >=', $start_date)
                        ->where('visited_at <=', $end_date . ' 23:59:59')
                        ->where('is_bot', 0)
                        ->group_by('DATE(visited_at)')
                        ->order_by('date', 'ASC')
                        ->get('visitors')
                        ->result();
    }

    /**
     * Get last 7 days stats
     */
    public function get_weekly_stats()
    {
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-6 days'));
        return $this->get_stats_range($start_date, $end_date);
    }

    /**
     * Get last 30 days stats
     */
    public function get_monthly_stats()
    {
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-29 days'));
        return $this->get_stats_range($start_date, $end_date);
    }

    /**
     * Get popular pages
     */
    public function get_popular_pages($limit = 10)
    {
        if (!$this->db->table_exists('popular_pages')) {
            return [];
        }

        return $this->db->order_by('view_count', 'DESC')
                        ->limit($limit)
                        ->get('popular_pages')
                        ->result();
    }

    /**
     * Get recent visitors
     */
    public function get_recent_visitors($limit = 20)
    {
        if (!$this->db->table_exists('visitors')) {
            return [];
        }

        return $this->db->where('is_bot', 0)
                        ->order_by('visited_at', 'DESC')
                        ->limit($limit)
                        ->get('visitors')
                        ->result();
    }

    /**
     * Get device breakdown
     */
    public function get_device_stats($days = 30)
    {
        if (!$this->db->table_exists('visitors')) {
            return ['desktop' => 0, 'mobile' => 0, 'tablet' => 0];
        }

        $start_date = date('Y-m-d', strtotime("-{$days} days"));
        
        $stats = $this->db->select('device_type, COUNT(*) as count')
                          ->where('visited_at >=', $start_date)
                          ->where('is_bot', 0)
                          ->group_by('device_type')
                          ->get('visitors')
                          ->result();
        
        $result = ['desktop' => 0, 'mobile' => 0, 'tablet' => 0];
        foreach ($stats as $stat) {
            $result[$stat->device_type] = (int)$stat->count;
        }
        
        return $result;
    }

    /**
     * Get browser stats
     */
    public function get_browser_stats($days = 30)
    {
        if (!$this->db->table_exists('visitors')) {
            return [];
        }

        $start_date = date('Y-m-d', strtotime("-{$days} days"));
        
        return $this->db->select('browser, COUNT(*) as count')
                        ->where('visited_at >=', $start_date)
                        ->where('is_bot', 0)
                        ->where('browser IS NOT NULL')
                        ->group_by('browser')
                        ->order_by('count', 'DESC')
                        ->limit(5)
                        ->get('visitors')
                        ->result();
    }

    /**
     * Get total stats summary
     */
    public function get_total_stats()
    {
        if (!$this->db->table_exists('visitors')) {
            return [
                'total_page_views' => 0,
                'total_unique_visitors' => 0,
                'today_views' => 0,
                'today_unique' => 0,
                'yesterday_views' => 0,
                'this_week_views' => 0,
                'this_month_views' => 0
            ];
        }

        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $week_start = date('Y-m-d', strtotime('-7 days'));
        $month_start = date('Y-m-d', strtotime('-30 days'));

        // Today
        $today_stats = $this->db->select('COUNT(*) as views, COUNT(DISTINCT ip_address) as unique_v')
                                ->where('DATE(visited_at)', $today)
                                ->where('is_bot', 0)
                                ->get('visitors')->row();

        // Yesterday
        $yesterday_stats = $this->db->select('COUNT(*) as views')
                                    ->where('DATE(visited_at)', $yesterday)
                                    ->where('is_bot', 0)
                                    ->get('visitors')->row();

        // This week
        $week_stats = $this->db->select('COUNT(*) as views')
                               ->where('visited_at >=', $week_start)
                               ->where('is_bot', 0)
                               ->get('visitors')->row();

        // This month
        $month_stats = $this->db->select('COUNT(*) as views')
                                ->where('visited_at >=', $month_start)
                                ->where('is_bot', 0)
                                ->get('visitors')->row();

        // All time
        $total_stats = $this->db->select('COUNT(*) as views, COUNT(DISTINCT ip_address) as unique_v')
                                ->where('is_bot', 0)
                                ->get('visitors')->row();

        return [
            'total_page_views' => $total_stats->views ?? 0,
            'total_unique_visitors' => $total_stats->unique_v ?? 0,
            'today_views' => $today_stats->views ?? 0,
            'today_unique' => $today_stats->unique_v ?? 0,
            'yesterday_views' => $yesterday_stats->views ?? 0,
            'this_week_views' => $week_stats->views ?? 0,
            'this_month_views' => $month_stats->views ?? 0
        ];
    }

    /**
     * Clean old visitor logs (keep last X days)
     */
    public function cleanup_old_logs($days = 90)
    {
        if (!$this->db->table_exists('visitors')) {
            return 0;
        }

        $cutoff_date = date('Y-m-d', strtotime("-{$days} days"));
        $this->db->where('visited_at <', $cutoff_date)->delete('visitors');
        return $this->db->affected_rows();
    }

    /**
     * Get country stats
     */
    public function get_country_stats($days = 30, $limit = 10)
    {
        if (!$this->db->table_exists('visitors')) {
            return [];
        }

        $start_date = date('Y-m-d', strtotime("-{$days} days"));
        
        return $this->db->select('country, COUNT(*) as count')
                        ->where('visited_at >=', $start_date)
                        ->where('is_bot', 0)
                        ->where('country IS NOT NULL')
                        ->where('country !=', '')
                        ->group_by('country')
                        ->order_by('count', 'DESC')
                        ->limit($limit)
                        ->get('visitors')
                        ->result();
    }

    /**
     * Get geolocation from IP address using free API
     */
    public static function get_geolocation($ip)
    {
        $result = [
            'country' => null,
            'city' => null
        ];

        // Skip local/private IPs
        if ($ip == '127.0.0.1' || $ip == '::1' || strpos($ip, '192.168.') === 0 || strpos($ip, '10.') === 0) {
            $result['country'] = 'Local';
            return $result;
        }

        try {
            // Using ip-api.com (free, 45 requests/minute limit)
            $url = "http://ip-api.com/json/{$ip}?fields=status,country,city";
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 2, // 2 second timeout
                    'ignore_errors' => true
                ]
            ]);
            
            $response = @file_get_contents($url, false, $context);
            
            if ($response) {
                $data = json_decode($response, true);
                if (isset($data['status']) && $data['status'] === 'success') {
                    $result['country'] = $data['country'] ?? null;
                    $result['city'] = $data['city'] ?? null;
                }
            }
        } catch (Exception $e) {
            log_message('error', 'Geolocation failed: ' . $e->getMessage());
        }

        return $result;
    }

    /**
     * Parse user agent to get browser, OS, device
     */
    public static function parse_user_agent($ua)
    {
        $result = [
            'browser' => 'Unknown',
            'os' => 'Unknown',
            'device_type' => 'desktop',
            'is_bot' => 0
        ];

        if (empty($ua)) return $result;

        // Check for bots
        $bots = ['bot', 'crawl', 'spider', 'slurp', 'search', 'fetch', 'facebook', 'twitter'];
        foreach ($bots as $bot) {
            if (stripos($ua, $bot) !== false) {
                $result['is_bot'] = 1;
                $result['browser'] = 'Bot';
                return $result;
            }
        }

        // Detect device type
        if (preg_match('/Mobile|Android.*Mobile|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i', $ua)) {
            $result['device_type'] = 'mobile';
        } elseif (preg_match('/iPad|Android(?!.*Mobile)|Tablet/i', $ua)) {
            $result['device_type'] = 'tablet';
        }

        // Detect browser
        if (preg_match('/Edg/i', $ua)) $result['browser'] = 'Edge';
        elseif (preg_match('/OPR|Opera/i', $ua)) $result['browser'] = 'Opera';
        elseif (preg_match('/Chrome/i', $ua)) $result['browser'] = 'Chrome';
        elseif (preg_match('/Firefox/i', $ua)) $result['browser'] = 'Firefox';
        elseif (preg_match('/Safari/i', $ua)) $result['browser'] = 'Safari';
        elseif (preg_match('/MSIE|Trident/i', $ua)) $result['browser'] = 'IE';

        // Detect OS
        if (preg_match('/Windows NT 10/i', $ua)) $result['os'] = 'Windows 10';
        elseif (preg_match('/Windows NT 6.3/i', $ua)) $result['os'] = 'Windows 8.1';
        elseif (preg_match('/Windows NT 6.2/i', $ua)) $result['os'] = 'Windows 8';
        elseif (preg_match('/Windows NT 6.1/i', $ua)) $result['os'] = 'Windows 7';
        elseif (preg_match('/Windows/i', $ua)) $result['os'] = 'Windows';
        elseif (preg_match('/Mac OS X/i', $ua)) $result['os'] = 'macOS';
        elseif (preg_match('/Linux/i', $ua)) $result['os'] = 'Linux';
        elseif (preg_match('/Android/i', $ua)) $result['os'] = 'Android';
        elseif (preg_match('/iOS|iPhone|iPad/i', $ua)) $result['os'] = 'iOS';

        return $result;
    }
}
