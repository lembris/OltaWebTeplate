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
        $this->load->helper('template');
        
        $active_template = get_active_template();
        
        // Load template-specific models
        if ($active_template === 'medical') {
            if (file_exists(APPPATH . 'models/Specialty_model.php')) {
                $this->load->model('Specialty_model');
            }
            if (file_exists(APPPATH . 'models/Expertise_model.php')) {
                $this->load->model('Expertise_model');
            }
            if (file_exists(APPPATH . 'models/Partner_model.php')) {
                $this->load->model('Partner_model');
            }
        } else {
            $this->load->model('Package_model');
            $this->load->model('Destination_model');
        }
        
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
        
        $active_template = get_active_template();
        
        $data['pages'] = $this->get_static_pages();
        $data['blogs'] = $this->get_blogs();
        $data['base_url'] = base_url();
        
        // Template-specific content
        if ($active_template === 'medical') {
            $data['specialties'] = $this->get_specialties();
            $data['expertises'] = $this->get_expertises();
            $data['partners'] = $this->get_partners();
            $data['packages'] = [];
            $data['destinations'] = [];
        } else {
            $data['packages'] = $this->get_packages();
            $data['destinations'] = $this->get_destinations();
            $data['specialties'] = [];
            $data['expertises'] = [];
            $data['partners'] = [];
        }
        
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
        $active_template = get_active_template();
        
        $base_pages = [
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
                'loc' => base_url('blog'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ],
        ];
        
        // Template-specific pages
        if ($active_template === 'medical') {
            $base_pages[] = [
                'loc' => base_url('services'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ];
            $base_pages[] = [
                'loc' => base_url('expertise'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ];
            $base_pages[] = [
                'loc' => base_url('consultation'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ];
        } else {
            $base_pages[] = [
                'loc' => base_url('packages'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ];
            $base_pages[] = [
                'loc' => base_url('destinations'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ];
            $base_pages[] = [
                'loc' => base_url('booking'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ];
            $base_pages[] = [
                'loc' => base_url('enquiry'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ];
        }
        
        return $base_pages;
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

    /**
     * Get all specialties for medical sitemap
     */
    private function get_specialties() {
        $specialties = [];
        
        try {
            if (isset($this->Specialty_model) && method_exists($this->Specialty_model, 'get_all')) {
                $result = $this->Specialty_model->get_all();
                
                if ($result) {
                    foreach ($result as $specialty) {
                        $slug = isset($specialty->slug) ? $specialty->slug : url_title($specialty->name, 'dash', TRUE);
                        $specialties[] = [
                            'loc' => base_url('services/' . $slug),
                            'lastmod' => isset($specialty->updated_at) ? date('Y-m-d', strtotime($specialty->updated_at)) : date('Y-m-d'),
                            'changefreq' => 'monthly',
                            'priority' => '0.7'
                        ];
                    }
                }
            }
        } catch (Exception $e) {
            // Model might not have this method
        }
        
        return $specialties;
    }

    /**
     * Get all expertises for medical sitemap
     */
    private function get_expertises() {
        $expertises = [];
        
        try {
            if (isset($this->Expertise_model) && method_exists($this->Expertise_model, 'get_all')) {
                $result = $this->Expertise_model->get_all();
                
                if ($result) {
                    foreach ($result as $expertise) {
                        $slug = isset($expertise->slug) ? $expertise->slug : url_title($expertise->name, 'dash', TRUE);
                        $expertises[] = [
                            'loc' => base_url('expertise/' . $slug),
                            'lastmod' => isset($expertise->updated_at) ? date('Y-m-d', strtotime($expertise->updated_at)) : date('Y-m-d'),
                            'changefreq' => 'monthly',
                            'priority' => '0.7'
                        ];
                    }
                }
            }
        } catch (Exception $e) {
            // Model might not have this method
        }
        
        return $expertises;
    }

    /**
     * Get all partners for medical sitemap
     */
    private function get_partners() {
        $partners = [];
        
        try {
            if (isset($this->Partner_model) && method_exists($this->Partner_model, 'get_all')) {
                $result = $this->Partner_model->get_all();
                
                if ($result) {
                    foreach ($result as $partner) {
                        $slug = isset($partner->slug) ? $partner->slug : url_title($partner->name, 'dash', TRUE);
                        $partners[] = [
                            'loc' => base_url('partners/' . $slug),
                            'lastmod' => isset($partner->updated_at) ? date('Y-m-d', strtotime($partner->updated_at)) : date('Y-m-d'),
                            'changefreq' => 'monthly',
                            'priority' => '0.6'
                        ];
                    }
                }
            }
        } catch (Exception $e) {
            // Model might not have this method
        }
        
        return $partners;
    }
}
