<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sitemap Controller
 * Generates dynamic XML sitemap for SEO
 * 
 * Created: December 5, 2025
 * Version: 1.0
 */
class Sitemap extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Package_model');
        $this->load->model('Destination_model');
        
        // Load blog model if exists
        if (file_exists(APPPATH . 'models/Blog_model.php')) {
            $this->load->model('Blog_model');
        }
    }

    /**
     * Generate XML Sitemap
     */
    public function index() {
        header("Content-Type: application/xml; charset=utf-8");
        
        $data['pages'] = $this->get_static_pages();
        $data['packages'] = $this->get_packages();
        $data['destinations'] = $this->get_destinations();
        $data['blogs'] = $this->get_blogs();
        $data['base_url'] = base_url();
        
        $this->load->view('sitemap_xml', $data);
    }

    /**
     * Generate Sitemap Index (for large sites)
     */
    public function sitemap_index() {
        header("Content-Type: application/xml; charset=utf-8");
        
        $data['base_url'] = base_url();
        $data['sitemaps'] = [
            ['loc' => base_url('sitemap.xml'), 'lastmod' => date('Y-m-d')],
        ];
        
        $this->load->view('sitemap_index_xml', $data);
    }

    /**
     * Get static pages
     */
    private function get_static_pages() {
        return [
            [
                'loc' => base_url(),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '1.0'
            ],
            [
                'loc' => base_url('about'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => base_url('packages'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ],
            [
                'loc' => base_url('destinations'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ],
            [
                'loc' => base_url('gallery'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ],
            [
                'loc' => base_url('contact'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            [
                'loc' => base_url('booking'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => base_url('enquiry'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => base_url('blog'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ],
        ];
    }

    /**
     * Get all packages for sitemap
     */
    private function get_packages() {
        $packages = [];
        
        try {
            $result = $this->Package_model->get_all_packages();
            
            if ($result) {
                foreach ($result as $package) {
                    $packages[] = [
                        'loc' => base_url('packages/' . $package->slug),
                        'lastmod' => isset($package->updated_at) ? date('Y-m-d', strtotime($package->updated_at)) : date('Y-m-d'),
                        'changefreq' => 'weekly',
                        'priority' => '0.8'
                    ];
                }
            }
        } catch (Exception $e) {
            // Model might not have this method
        }
        
        return $packages;
    }

    /**
     * Get all destinations for sitemap
     */
    private function get_destinations() {
        $destinations = [];
        
        try {
            if (method_exists($this->Destination_model, 'get_all_destinations')) {
                $result = $this->Destination_model->get_all_destinations();
                
                if ($result) {
                    foreach ($result as $destination) {
                        $slug = isset($destination->slug) ? $destination->slug : url_title($destination->name, 'dash', TRUE);
                        $destinations[] = [
                            'loc' => base_url('destinations/' . $slug),
                            'lastmod' => isset($destination->updated_at) ? date('Y-m-d', strtotime($destination->updated_at)) : date('Y-m-d'),
                            'changefreq' => 'monthly',
                            'priority' => '0.7'
                        ];
                    }
                }
            }
        } catch (Exception $e) {
            // Model might not have this method
        }
        
        return $destinations;
    }

    /**
     * Get all blog posts for sitemap
     */
    private function get_blogs() {
        $blogs = [];
        
        try {
            if (isset($this->Blog_model) && method_exists($this->Blog_model, 'get_published_posts')) {
                $result = $this->Blog_model->get_published_posts();
                
                if ($result) {
                    foreach ($result as $post) {
                        $blogs[] = [
                            'loc' => base_url('blog/' . $post->slug),
                            'lastmod' => isset($post->updated_at) ? date('Y-m-d', strtotime($post->updated_at)) : date('Y-m-d'),
                            'changefreq' => 'monthly',
                            'priority' => '0.6'
                        ];
                    }
                }
            }
        } catch (Exception $e) {
            // Blog model might not exist
        }
        
        return $blogs;
    }
}
