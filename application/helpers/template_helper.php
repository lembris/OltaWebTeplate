<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Template Helper
 * 
 * Provides functions for managing and switching between website templates.
 * Supports dynamic template loading from database settings.
 */

if (!function_exists('get_active_template')) {
    /**
     * Get the currently active template name
     * 
     * @return string Template name (e.g., 'tourism', 'college')
     */
    function get_active_template()
    {
        $CI = &get_instance();
        $CI->load->model('Settings_model');
        
        $template = $CI->Settings_model->get('active_template');
        
        // Default to 'tourism' if not set
        return !empty($template) ? $template : 'tourism';
    }
}

if (!function_exists('get_template_path')) {
    /**
     * Get the base path for template assets
     * 
     * @param string $template Optional template name (uses active if not provided)
     * @return string Full URL path to template assets
     */
    function get_template_path($template = null)
    {
        if ($template === null) {
            $template = get_active_template();
        }
        
        $CI = &get_instance();
        return base_url('assets/templates/' . $template . '/');
    }
}

if (!function_exists('get_template_css')) {
    /**
     * Get CSS file URL from active template
     * 
     * @param string $file CSS filename (e.g., 'style.css')
     * @param string $template Optional template name
     * @return string Full URL to CSS file
     */
    function get_template_css($file, $template = null)
    {
        return get_template_path($template) . 'css/' . $file;
    }
}

if (!function_exists('get_template_js')) {
    /**
     * Get JS file URL from active template
     * 
     * @param string $file JS filename (e.g., 'main.js')
     * @param string $template Optional template name
     * @return string Full URL to JS file
     */
    function get_template_js($file, $template = null)
    {
        return get_template_path($template) . 'js/' . $file;
    }
}

if (!function_exists('get_template_image')) {
    /**
     * Get image URL from active template
     * 
     * @param string $file Image filename
     * @param string $template Optional template name
     * @return string Full URL to image file
     */
    function get_template_image($file, $template = null)
    {
        return get_template_path($template) . 'images/' . $file;
    }
}

if (!function_exists('get_template_view_path')) {
    /**
     * Get the view path for template-specific views
     * 
     * @param string $template Optional template name
     * @return string View path prefix (e.g., 'templates/tourism/')
     */
    function get_template_view_path($template = null)
    {
        if ($template === null) {
            $template = get_active_template();
        }
        
        return 'templates/' . $template . '/';
    }
}

if (!function_exists('load_template_view')) {
    /**
     * Load a template-specific view with fallback to default
     * 
     * @param string $view View name (e.g., 'header', 'footer')
     * @param array $data Data to pass to view
     * @param bool $return Whether to return view content
     * @return mixed View content if $return is true, otherwise void
     */
    function load_template_view($view, $data = [], $return = false)
    {
        $CI = &get_instance();
        $template = get_active_template();
        
        // Check if template-specific view exists
        $template_view = 'templates/' . $template . '/' . $view;
        $default_view = 'includes/' . $view;
        
        // Try template-specific view first
        if (file_exists(APPPATH . 'views/' . $template_view . '.php')) {
            return $CI->load->view($template_view, $data, $return);
        }
        
        // Fallback to default view
        return $CI->load->view($default_view, $data, $return);
    }
}

if (!function_exists('get_available_templates')) {
    /**
     * Get list of available templates
     * 
     * @return array Array of template info ['name' => 'display_name']
     */
    function get_available_templates()
    {
        $templates_path = FCPATH . 'assets/templates/';
        $templates = [];
        
        if (is_dir($templates_path)) {
            $dirs = scandir($templates_path);
            foreach ($dirs as $dir) {
                if ($dir !== '.' && $dir !== '..' && is_dir($templates_path . $dir)) {
                    // Check if template has required structure
                    if (is_dir($templates_path . $dir . '/css')) {
                        $templates[$dir] = get_template_info($dir);
                    }
                }
            }
        }
        
        return $templates;
    }
}

if (!function_exists('get_template_info')) {
    /**
     * Get template metadata
     * 
     * @param string $template Template name
     * @return array Template info array
     */
    function get_template_info($template)
    {
        $template_path = FCPATH . 'assets/templates/' . $template . '/';
        $info_file = $template_path . 'template.json';
        
        $default_info = [
            'name' => $template,
            'display_name' => ucfirst(str_replace(['-', '_'], ' ', $template)),
            'description' => 'Website template',
            'version' => '1.0.0',
            'author' => 'Unknown',
            'preview' => ''
        ];
        
        // Load from template.json if exists
        if (file_exists($info_file)) {
            $json = file_get_contents($info_file);
            $info = json_decode($json, true);
            if ($info) {
                return array_merge($default_info, $info);
            }
        }
        
        return $default_info;
    }
}

if (!function_exists('is_template_active')) {
    /**
     * Check if a specific template is currently active
     * 
     * @param string $template Template name to check
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
     * @param string $template Optional template name
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
     * This allows each template to have completely different layouts for pages.
     * Falls back to the shared 'pages/' folder if no template-specific version exists.
     * 
     * @param string $page Page name (e.g., 'home', 'about', 'contact')
     * @param array $data Data to pass to view
     * @param bool $return Whether to return view content
     * @return mixed View content if $return is true, otherwise void
     */
    function load_template_page($page, $data = [], $return = false)
    {
        $CI = &get_instance();
        $template = get_active_template();
        
        // Check if template-specific page view exists
        $template_page = 'templates/' . $template . '/pages/' . $page;
        $shared_page = 'pages/' . $page;
        
        // Try template-specific page first
        if (file_exists(APPPATH . 'views/' . $template_page . '.php')) {
            return $CI->load->view($template_page, $data, $return);
        }
        
        // Fallback to shared page view
        return $CI->load->view($shared_page, $data, $return);
    }
}

if (!function_exists('template_page_exists')) {
    /**
     * Check if a template-specific page view exists
     * 
     * @param string $page Page name
     * @param string $template Optional template name
     * @return bool True if the template has a specific page view
     */
    function template_page_exists($page, $template = null)
    {
        if ($template === null) {
            $template = get_active_template();
        }
        
        $template_page = APPPATH . 'views/templates/' . $template . '/pages/' . $page . '.php';
        return file_exists($template_page);
    }
}

if (!function_exists('include_template_css')) {
    /**
     * Generate link tags for template CSS files
     * 
     * @param array $files Array of CSS filenames
     * @param string $template Optional template name
     * @return string HTML link tags
     */
    function include_template_css($files, $template = null)
    {
        $html = '';
        foreach ((array)$files as $file) {
            $html .= '<link href="' . get_template_css($file, $template) . '" rel="stylesheet">' . "\n";
        }
        return $html;
    }
}

if (!function_exists('include_template_js')) {
    /**
     * Generate script tags for template JS files
     * 
     * @param array $files Array of JS filenames
     * @param string $template Optional template name
     * @return string HTML script tags
     */
    function include_template_js($files, $template = null)
    {
        $html = '';
        foreach ((array)$files as $file) {
            $html .= '<script src="' . get_template_js($file, $template) . '"></script>' . "\n";
        }
        return $html;
    }
}

if (!function_exists('get_admin_menu')) {
    /**
     * Get admin menu configuration from template's admin_menu.json
     * 
     * @param string $template Optional template name (uses active if not provided)
     * @return array Admin menu configuration
     */
    function get_admin_menu($template = null)
    {
        if ($template === null) {
            $template = get_active_template();
        }
        
        $menu_file = FCPATH . 'assets/templates/' . $template . '/admin_menu.json';
        
        // Fallback to default menu if template doesn't have one
        if (!file_exists($menu_file)) {
            $menu_file = FCPATH . 'assets/templates/college/admin_menu.json';
        }
        
        if (file_exists($menu_file)) {
            $json = file_get_contents($menu_file);
            $menu = json_decode($json, true);
            if ($menu) {
                return $menu;
            }
        }
        
        // Return empty structure if no menu found
        return ['menu_name' => 'Admin Menu', 'sections' => []];
    }
}

if (!function_exists('render_admin_menu')) {
    /**
     * Render admin sidebar menu HTML from JSON configuration
     * 
     * @param array $menu Menu configuration array
     * @param object $ci CodeIgniter instance for URI checking
     * @param array $badges Badge counts (e.g., ['unread_contacts' => 5])
     * @return string HTML output
     */
    function render_admin_menu($menu, $ci, $badges = [])
    {
        $html = '';
        
        // Get current URI segments
        $segment2 = $ci->uri->segment(2);
        $segment3 = $ci->uri->segment(3);
        
        foreach ($menu['sections'] as $section) {
            // Section header
            $html .= '<li class="menu-header">' . htmlspecialchars($section['header']) . '</li>' . "\n";
            
            // Menu items
            foreach ($section['items'] as $item) {
                $is_active = false;
                
                // Check if current URL matches this menu item
                if (!empty($item['segment']) && is_array($item['segment'])) {
                    $segment_count = count($item['segment']);
                    
                    if ($segment_count === 1) {
                        // Single segment match (e.g., "blog", "pages", "gallery")
                        $is_active = (trim($segment2) === trim($item['segment'][0]));
                    } elseif ($segment_count >= 2) {
                        // Two segment match (e.g., "dashboard" + "operations")
                        $is_active = (trim($segment2) === trim($item['segment'][0]) && trim($segment3) === trim($item['segment'][1]));
                    }
                    
                    // Special case for dashboard default (no segment3 means operations)
                    if (trim($item['segment'][0]) === 'dashboard' && isset($item['segment'][1]) && trim($item['segment'][1]) === 'operations') {
                        if (trim($segment2) === 'dashboard' && (trim($segment3) === 'operations' || empty($segment3))) {
                            $is_active = true;
                        }
                        if (empty($segment2)) {
                            $is_active = true;
                        }
                    }
                }
                
                $active_class = $is_active ? 'active' : '';
                $url = base_url($item['url']);
                
                $html .= '<li>' . "\n";
                $html .= '    <a href="' . $url . '" class="' . $active_class . '">' . "\n";
                $html .= '        <i class="' . htmlspecialchars($item['icon']) . '"></i>' . "\n";
                $html .= '        <span>' . htmlspecialchars($item['label']) . '</span>' . "\n";
                
                // Badge support
                if (!empty($item['badge']) && isset($badges[$item['badge']]) && $badges[$item['badge']] > 0) {
                    $html .= '        <span class="badge bg-danger ms-auto">' . $badges[$item['badge']] . '</span>' . "\n";
                }
                
                $html .= '    </a>' . "\n";
                $html .= '</li>' . "\n";
            }
        }
        
        return $html;
    }
}
