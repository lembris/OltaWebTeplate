<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Template Helper
 * 
 * Provides functions for managing and switching between website templates.
 * All template data is stored in site_settings table.
 */

if (!function_exists('get_active_template')) {
    /**
     * Get the currently active template key
     * 
     * @return string Template key (e.g., 'tourism', 'medical', 'college')
     */
    function get_active_template()
    {
        $CI = &get_instance();
        $CI->load->model('Settings_model');
        
        $template = $CI->Settings_model->get('active_template');
        
        return !empty($template) ? $template : 'tourism';
    }
}

if (!function_exists('get_template_path')) {
    /**
     * Get the base path for template assets
     * 
     * @param string|null $template Optional template key
     * @return string Full URL path to template assets
     */
    function get_template_path($template = null)
    {
        if ($template === null) {
            $template = get_active_template();
        }
        
        return base_url('assets/templates/' . $template . '/');
    }
}

if (!function_exists('get_template_css')) {
    /**
     * Get CSS file URL from active template
     * 
     * @param string $file CSS filename
     * @param string|null $template Optional template key
     * @return string Full URL to CSS file
     */
    function get_template_css($file, $template = null)
    {
        return get_template_path($template) . 'css/' . $file;
    }
}

if (!function_exists('get_template_img')) {
    /**
     * Get image URL from active template
     * 
     * @param string $file Image filename
     * @param string|null $template Optional template key
     * @return string Full URL to image
     */
    function get_template_img($file, $template = null)
    {
        return get_template_path($template) . 'img/' . $file;
    }
}

if (!function_exists('get_template_js')) {
    /**
     * Get JS file URL from active template
     * 
     * @param string $file JS filename
     * @param string|null $template Optional template key
     * @return string Full URL to JS file
     */
    function get_template_js($file, $template = null)
    {
        return get_template_path($template) . 'js/' . $file;
    }
}

if (!function_exists('get_template_vendor')) {
    /**
     * Get vendor asset URL from active template
     * 
     * @param string $path Vendor asset path
     * @param string|null $template Optional template key
     * @return string Full URL to vendor asset
     */
    function get_template_vendor($path, $template = null)
    {
        return get_template_path($template) . 'vendor/' . $path;
    }
}

if (!function_exists('get_available_templates')) {
    /**
     * Get all available templates by scanning folders
     * All template data comes from site_settings database
     * 
     * @return array Array of template info with colors from site_settings
     */
    function get_available_templates()
    {
        $templates_path = FCPATH . 'assets/templates/';
        $templates = [];
        
        if (!is_dir($templates_path)) {
            return $templates;
        }
        
        $dirs = scandir($templates_path);
        $active_template = get_active_template();
        
        foreach ($dirs as $dir) {
            if ($dir === '.' || $dir === '..') continue;
            if (!is_dir($templates_path . $dir)) continue;
            if (!is_dir($templates_path . $dir . '/css')) continue;
            
            // Get template info from site_settings
            $CI = &get_instance();
            $CI->load->model('Settings_model');
            $settings = $CI->Settings_model->get_all($dir);
            
            // Default values (no template.json fallback)
            $display_name = ucfirst(str_replace(['-', '_'], ' ', $dir));
            $description = 'Website template';
            $version = '1.0.0';
            $author = 'Unknown';
            $type = 'general';
            $is_active = ($dir === $active_template) ? 1 : 0;
            $colors = [
                'primary' => '#006EB0',
                'secondary' => '#0CA69C',
                'accent' => '#E43834',
                'background' => '#E9F7F6'
            ];
            
            // Override with database values if they exist
            if (!empty($settings['template_display_name'])) {
                $display_name = $settings['template_display_name'];
            }
            if (!empty($settings['template_description'])) {
                $description = $settings['template_description'];
            }
            if (!empty($settings['template_version'])) {
                $version = $settings['template_version'];
            }
            if (!empty($settings['template_author'])) {
                $author = $settings['template_author'];
            }
            if (!empty($settings['template_type'])) {
                $type = $settings['template_type'];
            }
            
            // Get colors from site_settings (theme colors)
            if (!empty($settings['theme_primary_color'])) {
                $colors['primary'] = $settings['theme_primary_color'];
            }
            if (!empty($settings['theme_secondary_color'])) {
                $colors['secondary'] = $settings['theme_secondary_color'];
            }
            if (!empty($settings['theme_accent_color'])) {
                $colors['accent'] = $settings['theme_accent_color'];
            }
            if (!empty($settings['theme_background_color'])) {
                $colors['background'] = $settings['theme_background_color'];
            }
            
            $templates[$dir] = [
                'name' => $dir,
                'display_name' => $display_name,
                'description' => $description,
                'version' => $version,
                'author' => $author,
                'type' => $type,
                'preview' => 'preview.png',
                'is_active' => $is_active,
                'colors' => $colors
            ];
        }
        
        return $templates;
    }
}

if (!function_exists('get_template_image')) {
    /**
     * Get template-specific image or fallback
     * 
     * @param string $image Image filename
     * @param string|null $template Optional template key
     * @return string Full URL to image
     */
    function get_template_image($image, $template = null)
    {
        if ($template === null) {
            $template = get_active_template();
        }
        
        $path = FCPATH . 'assets/templates/' . $template . '/img/' . $image;
        if (file_exists($path)) {
            return base_url('assets/templates/' . $template . '/img/' . $image);
        }
        
        // Try tourism as fallback
        $fallback = FCPATH . 'assets/templates/tourism/img/' . $image;
        if (file_exists($fallback)) {
            return base_url('assets/templates/tourism/img/' . $image);
        }
        
        return base_url('assets/img/placeholder.png');
    }
}

if (!function_exists('is_template_active')) {
    /**
     * Check if a specific template is currently active
     * 
     * @param string $template Template key to check
     * @return bool True if the template is active
     */
    function is_template_active($template)
    {
        return get_active_template() === $template;
    }
}

if (!function_exists('template_asset')) {
    /**
     * Universal helper to get any template asset path
     * 
     * @param string $type Asset type ('css', 'js', 'images', 'fonts')
     * @param string $file Filename
     * @param string|null $template Optional template key
     * @return string Full URL to asset
     */
    function template_asset($type, $file, $template = null)
    {
        return get_template_path($template) . $type . '/' . $file;
    }
}

if (!function_exists('load_template_page')) {
    /**
     * Load a template-specific page view with fallback to shared pages
     * 
     * @param string $page Page name
     * @param array $data Data to pass to view
     * @param bool $return Whether to return view content
     * @return mixed View content if $return is true
     */
    function load_template_page($page, $data = [], $return = false)
    {
        $CI = &get_instance();
        $template = get_active_template();
        
        $template_view = 'templates/' . $template . '/pages/' . $page . '.php';
        $shared_view = 'templates/pages/' . $page . '.php';
        
        if (file_exists(APPPATH . 'views/' . $template_view)) {
            $view = $template_view;
        } elseif (file_exists(APPPATH . 'views/' . $shared_view)) {
            $view = $shared_view;
        } else {
            show_404();
            return;
        }
        
        if ($return) {
            return $CI->load->view($view, $data, true);
        }
        
        $CI->load->view($view, $data);
    }
}

/**
 * Load template view with layout (header, page, footer)
 * This is the main template rendering function
 * 
 * @param string $page Page name (without extension)
 * @param array $data Data to pass to views
 * @param bool $return Return as string or output directly
 * @return string|null View content if $return is true
 */
if (!function_exists('load_template_view')) {
    function load_template_view($page, $data = [], $return = false)
    {
        $CI = &get_instance();
        $template = get_active_template();
        
        // Define view paths
        $views_path = APPPATH . 'views/templates/' . $template . '/';
        
        $header = $views_path . 'header.php';
        $page_view = $views_path . 'pages/' . $page . '.php';
        $footer = $views_path . 'footer.php';
        
        // Check if template views exist
        if (!file_exists($header)) {
            show_error('Template header not found: ' . $header);
            return;
        }
        
        if (!file_exists($page_view)) {
            show_error('Template page not found: ' . $page_view);
            return;
        }
        
        if (!file_exists($footer)) {
            show_error('Template footer not found: ' . $footer);
            return;
        }
        
        // Load common data if not provided
        if (!isset($data['page_title'])) {
            $data['page_title'] = ucfirst(str_replace(['-', '_'], ' ', $page));
        }
        
        // Build output
        $output = '';
        
        // Load header
        $output .= $CI->load->view('templates/' . $template . '/header', $data, true);
        
        // Load page content
        $output .= $CI->load->view('templates/' . $template . '/pages/' . $page, $data, true);
        
        // Load footer
        $output .= $CI->load->view('templates/' . $template . '/footer', $data, true);
        
        if ($return) {
            return $output;
        }
        
        echo $output;
    }
}

/**
 * Get template info with colors from database
 * 
 * @param string|null $template Template key
 * @return array Template info with colors
 */
if (!function_exists('get_template_info')) {
    function get_template_info($template = null)
    {
        $CI = &get_instance();
        $CI->load->model('Settings_model');
        
        if ($template === null) {
            $template = get_active_template();
        }
        
        $settings = $CI->Settings_model->get_all($template);
        
        return [
            'name' => $template,
            'display_name' => $settings['template_display_name'] ?? ucfirst(str_replace(['-', '_'], ' ', $template)),
            'description' => $settings['template_description'] ?? '',
            'version' => $settings['template_version'] ?? '1.0.0',
            'author' => $settings['template_author'] ?? 'Unknown',
            'type' => $settings['template_type'] ?? 'general',
            'colors' => [
                'primary' => $settings['theme_primary_color'] ?? '#006EB0',
                'secondary' => $settings['theme_secondary_color'] ?? '#0CA69C',
                'accent' => $settings['theme_accent_color'] ?? '#E43834',
                'background' => $settings['theme_background_color'] ?? '#E9F7F6'
            ]
        ];
    }
}

if (!function_exists('generate_breadcrumb_schema')) {
    /**
     * Generate JSON-LD Breadcrumb schema for SEO
     * 
     * @param array $breadcrumbs Array of breadcrumb items with 'name' and 'url' keys
     * @return string JSON-LD script tag
     */
    function generate_breadcrumb_schema($breadcrumbs = [])
    {
        if (empty($breadcrumbs)) {
            return '';
        }
        
        $breadcrumbList = [];
        foreach ($breadcrumbs as $index => $breadcrumb) {
            $breadcrumbList[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $breadcrumb['name'],
                'item' => $breadcrumb['url']
            ];
        }
        
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbList
        ];
        
        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
    }
}

if (!function_exists('generate_medical_service_schema')) {
    /**
     * Generate JSON-LD Medical Service schema for expertise/specialties
     * 
     * @param array $service Service details with keys: name, description, provider
     * @return string JSON-LD script tag
     */
    function generate_medical_service_schema($service = [])
    {
        if (empty($service['name'])) {
            return '';
        }
        
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'MedicalBusiness',
            'name' => $service['name'],
            'description' => $service['description'] ?? '',
            'provider' => [
                '@type' => 'MedicalOrganization',
                'name' => $service['provider'] ?? 'TNA CARE'
            ]
        ];
        
        if (!empty($service['image'])) {
            $schema['image'] = $service['image'];
        }
        
        if (!empty($service['offers'])) {
            $schema['offers'] = [
                '@type' => 'Offer',
                'priceCurrency' => $service['offers']['currency'] ?? 'USD',
                'price' => $service['offers']['price'] ?? ''
            ];
        }
        
        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
    }
}

if (!function_exists('get_breadcrumbs')) {
    /**
     * Build breadcrumb array based on current URI
     * 
     * @return array Breadcrumb items
     */
    function get_breadcrumbs()
    {
        $CI = &get_instance();
        $breadcrumbs = [
            [
                'name' => 'Home',
                'url' => base_url()
            ]
        ];
        
        $uri_segments = $CI->uri->segment_array();
        $current_url = base_url();
        
        $breadcrumb_labels = [
            'about' => 'About Us',
            'services' => 'Services',
            'expertise' => 'Medical Expertise',
            'partners' => 'Hospital Partners',
            'blog' => 'Blog',
            'contact' => 'Contact Us'
        ];
        
        foreach ($uri_segments as $segment) {
            $current_url .= $segment . '/';
            $label = $breadcrumb_labels[$segment] ?? ucfirst(str_replace('-', ' ', $segment));
            
            $breadcrumbs[] = [
                'name' => $label,
                'url' => $current_url
            ];
        }
        
        return $breadcrumbs;
    }
}
