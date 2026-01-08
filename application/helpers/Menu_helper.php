<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Get menu by location
if (!function_exists('get_menu')) {
    function get_menu($location = 'primary', $options = [])
    {
        $CI = &get_instance();
        $CI->load->model('Menu_model');
        
        $menu = $CI->Menu_model->get_menu_by_location($location);
        
        if (!$menu) {
            return NULL;
        }
        
        $items = $CI->Menu_model->get_menu_items_tree($menu->id);
        
        return [
            'menu' => $menu,
            'items' => $items
        ];
    }
}

// Render menu HTML
if (!function_exists('render_menu')) {
    function render_menu($location = 'primary', $options = [])
    {
        $menu_data = get_menu($location, $options);
        
        if (!$menu_data) {
            return '';
        }
        
        $defaults = [
            'menu_class' => 'navbar-nav',
            'item_class' => 'nav-item',
            'link_class' => 'nav-link',
            'active_class' => 'active',
            'current_url' => current_url(),
            'wrap_list' => true,
            'max_depth' => NULL
        ];
        
        $options = array_merge($defaults, $options);
        
        $html = '';
        
        if ($options['wrap_list']) {
            $html .= '<ul class="' . htmlspecialchars($options['menu_class']) . '">' . PHP_EOL;
        }
        
        $html .= _render_menu_items($menu_data['items'], $options, 0);
        
        if ($options['wrap_list']) {
            $html .= '</ul>' . PHP_EOL;
        }
        
        return $html;
    }
}

// Render individual menu items (recursive)
if (!function_exists('_render_menu_items')) {
    function _render_menu_items($items, $options, $depth = 0)
    {
        $html = '';
        
        // Check max depth
        if ($options['max_depth'] !== NULL && $depth >= $options['max_depth']) {
            return $html;
        }
        
        foreach ($items as $item) {
            // Skip hidden items
            if (!$item->is_visible) {
                continue;
            }
            
            $url = _resolve_menu_item_url($item);
            $is_active = _is_menu_item_active($url, $options['current_url']);
            
            $item_class = $options['item_class'];
            if ($is_active) {
                $item_class .= ' ' . $options['active_class'];
            }
            
            // Has children
            if (!empty($item->children)) {
                $item_class .= ' dropdown';
            }
            
            $html .= '<li class="' . htmlspecialchars($item_class) . '">' . PHP_EOL;
            
            // Build link attributes
            $link_class = $options['link_class'];
            if (is_array($item->children) && !empty($item->children)) {
                $link_class .= ' dropdown-toggle';
            }
            
            $link_attrs = 'class="' . htmlspecialchars($link_class) . '"';
            
            if (is_array($item->children) && !empty($item->children)) {
                $link_attrs .= ' data-bs-toggle="dropdown" aria-expanded="false"';
            }
            
            if ($item->target_blank) {
                $link_attrs .= ' target="_blank" rel="noopener noreferrer"';
            }
            
            // Add custom classes if present
            if ($item->item_class) {
                $link_attrs .= ' ' . htmlspecialchars($item->item_class);
            }
            
            $html .= '<a href="' . htmlspecialchars($url) . '" ' . $link_attrs . '>';
            
            if ($item->item_icon) {
                $html .= '<i class="' . htmlspecialchars($item->item_icon) . ' me-2"></i>';
            }
            
            $html .= htmlspecialchars($item->item_label);
            $html .= '</a>' . PHP_EOL;
            
            // Render children
            if (is_array($item->children) && !empty($item->children)) {
                $html .= '<ul class="dropdown-menu">' . PHP_EOL;
                $html .= _render_menu_items($item->children, $options, $depth + 1);
                $html .= '</ul>' . PHP_EOL;
            }
            
            $html .= '</li>' . PHP_EOL;
        }
        
        return $html;
    }
}

// Resolve menu item URL
if (!function_exists('_resolve_menu_item_url')) {
    function _resolve_menu_item_url($item)
    {
        if (!$item->item_url) {
            return '#';
        }
        
        // External URL
        if (strpos($item->item_url, 'http') === 0) {
            return $item->item_url;
        }
        
        // Internal URL - if it doesn't start with /, add base_url
        if (strpos($item->item_url, '/') === 0) {
            return site_url(ltrim($item->item_url, '/'));
        }
        
        return site_url($item->item_url);
    }
}

// Check if menu item is active
if (!function_exists('_is_menu_item_active')) {
    function _is_menu_item_active($item_url, $current_url)
    {
        // Normalize URLs for comparison
        $item_url = rtrim($item_url, '/');
        $current_url = rtrim($current_url, '/');
        
        return $item_url === $current_url || strpos($current_url, $item_url) === 0;
    }
}

// Get menu items as array
if (!function_exists('get_menu_items')) {
    function get_menu_items($menu_id)
    {
        $CI = &get_instance();
        $CI->load->model('Menu_model');
        
        return $CI->Menu_model->get_menu_items($menu_id);
    }
}

// Get menu items tree
if (!function_exists('get_menu_items_tree')) {
    function get_menu_items_tree($menu_id)
    {
        $CI = &get_instance();
        $CI->load->model('Menu_model');
        
        return $CI->Menu_model->get_menu_items_tree($menu_id);
    }
}

// Get all menus
if (!function_exists('get_all_menus')) {
    function get_all_menus()
    {
        $CI = &get_instance();
        $CI->load->model('Menu_model');
        
        return $CI->Menu_model->get_all_menus();
    }
}

// Get active menus
if (!function_exists('get_active_menus')) {
    function get_active_menus()
    {
        $CI = &get_instance();
        $CI->load->model('Menu_model');
        
        return $CI->Menu_model->get_active_menus();
    }
}

// Render menu as breadcrumbs
if (!function_exists('render_menu_breadcrumbs')) {
    function render_menu_breadcrumbs($location = 'primary', $options = [])
    {
        $menu_data = get_menu($location);
        
        if (!$menu_data) {
            return '';
        }
        
        $defaults = [
            'breadcrumb_class' => 'breadcrumb',
            'item_class' => 'breadcrumb-item',
            'active_class' => 'active'
        ];
        
        $options = array_merge($defaults, $options);
        
        $html = '<nav aria-label="breadcrumb">' . PHP_EOL;
        $html .= '<ol class="' . htmlspecialchars($options['breadcrumb_class']) . '">' . PHP_EOL;
        
        $html .= _render_breadcrumb_items($menu_data['items'], $options);
        
        $html .= '</ol>' . PHP_EOL;
        $html .= '</nav>' . PHP_EOL;
        
        return $html;
    }
}

// Render breadcrumb items (recursive)
if (!function_exists('_render_breadcrumb_items')) {
    function _render_breadcrumb_items($items, $options, $depth = 0)
    {
        $html = '';
        
        foreach ($items as $item) {
            if (!$item->is_visible) {
                continue;
            }
            
            $url = _resolve_menu_item_url($item);
            $is_active = _is_menu_item_active($url, current_url());
            
            $item_class = $options['item_class'];
            if ($is_active) {
                $item_class .= ' ' . $options['active_class'];
            }
            
            $html .= '<li class="' . htmlspecialchars($item_class) . '">';
            
            if ($is_active) {
                $html .= htmlspecialchars($item->item_label);
            } else {
                $html .= '<a href="' . htmlspecialchars($url) . '">' . htmlspecialchars($item->item_label) . '</a>';
            }
            
            $html .= '</li>' . PHP_EOL;
            
            // Only show first level for breadcrumbs
            if (!empty($item->children) && $depth == 0) {
                $html .= _render_breadcrumb_items($item->children, $options, $depth + 1);
            }
        }
        
        return $html;
    }
}

// Get menu statistics
if (!function_exists('get_menu_statistics')) {
    function get_menu_statistics()
    {
        $CI = &get_instance();
        $CI->load->model('Menu_model');
        
        return $CI->Menu_model->get_menu_statistics();
    }
}

// Render menu in sidebar style
if (!function_exists('render_menu_sidebar')) {
    function render_menu_sidebar($location = 'sidebar', $options = [])
    {
        return render_menu($location, array_merge($options, [
            'menu_class' => 'sidebar-menu',
            'item_class' => 'sidebar-item',
            'link_class' => 'sidebar-link'
        ]));
    }
}

// Render menu in footer style
if (!function_exists('render_menu_footer')) {
    function render_menu_footer($location = 'footer', $options = [])
    {
        return render_menu($location, array_merge($options, [
            'menu_class' => 'footer-menu',
            'item_class' => 'footer-menu-item',
            'link_class' => 'footer-link'
        ]));
    }
}
