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

// Get admin menu from template's admin_menu.json file
if (!function_exists('get_admin_menu')) {
    function get_admin_menu()
    {
        $CI = &get_instance();
        
        // Get active template
        $CI->load->helper('template');
        $active_template = get_active_template();
        
        // Try to load admin_menu.json from template folder first
        $json_file = FCPATH . 'assets/templates/' . $active_template . '/admin_menu.json';
        
        if (file_exists($json_file)) {
            $json = file_get_contents($json_file);
            $menu_data = json_decode($json, true);
            
            if ($menu_data && isset($menu_data['sections'])) {
                // Convert sections format to flat items for compatibility
                $items = _convert_sections_to_items($menu_data['sections']);
                
                return [
                    'menu' => (object)[
                        'id' => 0, 
                        'menu_name' => $menu_data['menu_name'] ?? 'Admin Menu', 
                        'location' => 'admin',
                        'template' => $active_template,
                        'source' => 'file'
                    ],
                    'items' => $items,
                    'sections' => $menu_data['sections'],
                    'source' => 'file'
                ];
            }
        }
        
        // Fallback: Try to get admin menu JSON from site_settings for this template
        $CI->load->model('Settings_model');
        $admin_menu_json = $CI->Settings_model->get('admin_menu_json', $active_template);
        
        if (!empty($admin_menu_json)) {
            $menu_data = json_decode($admin_menu_json, true);
            if ($menu_data && isset($menu_data['items'])) {
                $items = _convert_menu_array_to_objects($menu_data['items']);
                return [
                    'menu' => (object)[
                        'id' => 0, 
                        'menu_name' => $menu_data['menu_name'] ?? 'Admin Menu', 
                        'location' => 'admin',
                        'template' => $active_template,
                        'source' => 'database'
                    ],
                    'items' => $items,
                    'source' => 'database'
                ];
            }
        }
        
        // Fallback: try to get from Menu_model database table
        $CI->load->model('Menu_model');
        $menu = $CI->Menu_model->get_menu_by_location('admin');
        
        if ($menu) {
            $items = $CI->Menu_model->get_menu_items_tree($menu->id);
            return [
                'menu' => $menu,
                'items' => $items,
                'source' => 'menu_model'
            ];
        }
        
        // Return default admin menu structure based on template
        return [
            'menu' => (object)[
                'id' => 0, 
                'menu_name' => 'Admin Menu', 
                'location' => 'admin',
                'template' => $active_template
            ],
            'items' => _get_default_admin_menu_items($active_template),
            'source' => 'default'
        ];
    }
}

// Convert sections from admin_menu.json to flat items array
if (!function_exists('_convert_sections_to_items')) {
    function _convert_sections_to_items($sections)
    {
        $items = [];
        $sort_order = 1;
        
        foreach ($sections as $section) {
            if (!isset($section['items']) || !is_array($section['items'])) continue;
            
            foreach ($section['items'] as $item) {
                $obj = (object)[
                    'id' => 0,
                    'item_label' => $item['label'] ?? '',
                    'item_url' => $item['url'] ?? '#',
                    'item_icon' => $item['icon'] ?? '',
                    'item_class' => '',
                    'target_blank' => 0,
                    'is_visible' => 1,
                    'sort_order' => $sort_order++,
                    'children' => [],
                    'badge' => $item['badge'] ?? null,
                    'segment' => $item['segment'] ?? [],
                    'section_header' => $section['header'] ?? ''
                ];
                $items[] = $obj;
            }
        }
        
        return $items;
    }
}

// Convert menu array from JSON to objects
if (!function_exists('_convert_menu_array_to_objects')) {
    function _convert_menu_array_to_objects($items)
    {
        $result = [];
        foreach ($items as $item) {
            $obj = (object)[
                'id' => $item['id'] ?? 0,
                'item_label' => $item['label'] ?? '',
                'item_url' => $item['url'] ?? '#',
                'item_icon' => $item['icon'] ?? '',
                'item_class' => $item['class'] ?? '',
                'target_blank' => $item['target_blank'] ?? 0,
                'is_visible' => $item['is_visible'] ?? 1,
                'sort_order' => $item['sort_order'] ?? 0,
                'children' => []
            ];
            if (!empty($item['children'])) {
                $obj->children = _convert_menu_array_to_objects($item['children']);
            }
            $result[] = $obj;
        }
        return $result;
    }
}

// Get default admin menu items based on template type
if (!function_exists('_get_default_admin_menu_items')) {
    function _get_default_admin_menu_items($template = 'tourism')
    {
        // Base menu items for all templates
        $base_items = [
            (object)[
                'id' => 1,
                'item_label' => 'Dashboard',
                'item_url' => 'admin/dashboard',
                'item_icon' => 'fas fa-home',
                'item_class' => '',
                'target_blank' => 0,
                'is_visible' => 1,
                'sort_order' => 1,
                'children' => []
            ]
        ];
        
        // Template-specific menu items
        $template_items = [];
        
        if ($template === 'medical') {
            // TNA CARE / Medical template menu
            $template_items = [
                (object)[
                    'id' => 10,
                    'item_label' => 'Consultations',
                    'item_url' => 'admin/consultations',
                    'item_icon' => 'fas fa-user-md',
                    'item_class' => '',
                    'target_blank' => 0,
                    'is_visible' => 1,
                    'sort_order' => 2,
                    'children' => []
                ],
                (object)[
                    'id' => 11,
                    'item_label' => 'Appointments',
                    'item_url' => 'admin/appointments',
                    'item_icon' => 'fas fa-calendar-check',
                    'item_class' => '',
                    'target_blank' => 0,
                    'is_visible' => 1,
                    'sort_order' => 3,
                    'children' => []
                ],
                (object)[
                    'id' => 12,
                    'item_label' => 'Specialties',
                    'item_url' => 'admin/specialties',
                    'item_icon' => 'fas fa-stethoscope',
                    'item_class' => '',
                    'target_blank' => 0,
                    'is_visible' => 1,
                    'sort_order' => 4,
                    'children' => []
                ],
                (object)[
                    'id' => 13,
                    'item_label' => 'Health Services',
                    'item_url' => 'admin/health-services',
                    'item_icon' => 'fas fa-heartbeat',
                    'item_class' => '',
                    'target_blank' => 0,
                    'is_visible' => 1,
                    'sort_order' => 5,
                    'children' => []
                ]
            ];
        } elseif ($template === 'tourism') {
            // Tourism template menu
            $template_items = [
                (object)[
                    'id' => 20,
                    'item_label' => 'Destinations',
                    'item_url' => 'admin/destinations',
                    'item_icon' => 'fas fa-map-marker-alt',
                    'item_class' => '',
                    'target_blank' => 0,
                    'is_visible' => 1,
                    'sort_order' => 2,
                    'children' => []
                ],
                (object)[
                    'id' => 21,
                    'item_label' => 'Packages',
                    'item_url' => 'admin/packages',
                    'item_icon' => 'fas fa-box-open',
                    'item_class' => '',
                    'target_blank' => 0,
                    'is_visible' => 1,
                    'sort_order' => 3,
                    'children' => []
                ],
                (object)[
                    'id' => 22,
                    'item_label' => 'Bookings',
                    'item_url' => 'admin/bookings',
                    'item_icon' => 'fas fa-ticket-alt',
                    'item_class' => '',
                    'target_blank' => 0,
                    'is_visible' => 1,
                    'sort_order' => 4,
                    'children' => []
                ]
            ];
        } else {
            // Generic/College template menu
            $template_items = [
                (object)[
                    'id' => 30,
                    'item_label' => 'Programs',
                    'item_url' => 'admin/programs',
                    'item_icon' => 'fas fa-graduation-cap',
                    'item_class' => '',
                    'target_blank' => 0,
                    'is_visible' => 1,
                    'sort_order' => 2,
                    'children' => []
                ],
                (object)[
                    'id' => 31,
                    'item_label' => 'Faculty',
                    'item_url' => 'admin/faculty',
                    'item_icon' => 'fas fa-users',
                    'item_class' => '',
                    'target_blank' => 0,
                    'is_visible' => 1,
                    'sort_order' => 3,
                    'children' => []
                ],
                (object)[
                    'id' => 32,
                    'item_label' => 'Events',
                    'item_url' => 'admin/events',
                    'item_icon' => 'fas fa-calendar-alt',
                    'item_class' => '',
                    'target_blank' => 0,
                    'is_visible' => 1,
                    'sort_order' => 4,
                    'children' => []
                ],
                (object)[
                    'id' => 33,
                    'item_label' => 'YouTube Videos',
                    'item_url' => 'admin-youtube',
                    'item_icon' => 'fas fa-video',
                    'item_class' => '',
                    'target_blank' => 0,
                    'is_visible' => 1,
                    'sort_order' => 5,
                    'children' => []
                ]
            ];
        }
        
        // Add YouTube Videos menu item to medical template
        if ($template === 'medical') {
            $template_items[] = (object)[
                'id' => 14,
                'item_label' => 'YouTube Videos',
                'item_url' => 'admin-youtube',
                'item_icon' => 'fas fa-video',
                'item_class' => '',
                'target_blank' => 0,
                'is_visible' => 1,
                'sort_order' => 6,
                'children' => []
            ];
        }
        
        // Common items for all templates
        $common_items = [
            (object)[
                'id' => 100,
                'item_label' => 'Pages',
                'item_url' => 'admin/pages',
                'item_icon' => 'fas fa-file-alt',
                'item_class' => '',
                'target_blank' => 0,
                'is_visible' => 1,
                'sort_order' => 50,
                'children' => []
            ],
            (object)[
                'id' => 101,
                'item_label' => 'Blog',
                'item_url' => 'admin/blog',
                'item_icon' => 'fas fa-blog',
                'item_class' => '',
                'target_blank' => 0,
                'is_visible' => 1,
                'sort_order' => 51,
                'children' => []
            ],
            (object)[
                'id' => 102,
                'item_label' => 'Gallery',
                'item_url' => 'admin/gallery',
                'item_icon' => 'fas fa-images',
                'item_class' => '',
                'target_blank' => 0,
                'is_visible' => 1,
                'sort_order' => 52,
                'children' => []
            ],
            (object)[
                'id' => 103,
                'item_label' => 'Contacts',
                'item_url' => 'admin/contacts',
                'item_icon' => 'fas fa-envelope',
                'item_class' => '',
                'target_blank' => 0,
                'is_visible' => 1,
                'sort_order' => 53,
                'children' => []
            ],
            (object)[
                'id' => 104,
                'item_label' => 'Settings',
                'item_url' => 'admin/settings',
                'item_icon' => 'fas fa-cog',
                'item_class' => '',
                'target_blank' => 0,
                'is_visible' => 1,
                'sort_order' => 99,
                'children' => []
            ]
        ];
        
        // Merge all items
        return array_merge($base_items, $template_items, $common_items);
    }
}

// Check if current user is super admin
if (!function_exists('is_super_admin')) {
    function is_super_admin()
    {
        $CI = &get_instance();
        
        // Check admin session first
        if ($CI->session->userdata('admin_logged_in')) {
            return $CI->session->userdata('admin_role') === 'super_admin';
        }
        
        // Check user session (from Users controller)
        if ($CI->session->userdata('user_logged_in')) {
            return $CI->session->userdata('user_role') === 'super_admin';
        }
        
        return false;
    }
}

// Check if menu item should be hidden based on user role
if (!function_exists('_should_hide_menu_item')) {
    function _should_hide_menu_item($url)
    {
        // URLs that should only be visible to super admins
        $super_admin_only = [
            'admin/settings',
            'admin/users'
        ];
        
        foreach ($super_admin_only as $admin_url) {
            if (strpos($url, $admin_url) === 0) {
                if (!is_super_admin()) {
                    return true;
                }
            }
        }
        
        return false;
    }
}

// Render admin menu - supports both section-based (from admin_menu.json) and flat formats
if (!function_exists('render_admin_menu')) {
    function render_admin_menu($admin_menu, $CI, $badges = [])
    {
        $items = $admin_menu['items'] ?? [];
        $sections = $admin_menu['sections'] ?? [];
        $current_url = current_url();
        
        $html = '';
        
        // If we have sections (from admin_menu.json), render with section headers
        if (!empty($sections)) {
            foreach ($sections as $section) {
                $section_header = $section['header'] ?? '';
                $section_items = $section['items'] ?? [];
                
                if (empty($section_items)) continue;
                
                // Filter out items that should be hidden for non-super-admins
                $visible_items = [];
                foreach ($section_items as $item) {
                    $url = $item['url'] ?? '#';
                    if (!_should_hide_menu_item($url)) {
                        $visible_items[] = $item;
                    }
                }
                
                if (empty($visible_items)) continue;
                
                // Render section header
                if (!empty($section_header)) {
                    $html .= '<li class="sidebar-section-header">' . htmlspecialchars($section_header) . '</li>' . PHP_EOL;
                }
                
                // Render items in this section
                foreach ($visible_items as $item) {
                    $url = $item['url'] ?? '#';
                    $label = $item['label'] ?? '';
                    $icon = $item['icon'] ?? '';
                    $badge = $item['badge'] ?? null;
                    $segments = $item['segment'] ?? [];
                    
                    // Check if current URL matches any segment
                    $is_active = false;
                    $current_uri = uri_string();
                    foreach ($segments as $segment) {
                        if (strpos($current_uri, $segment) !== false) {
                            $is_active = true;
                            break;
                        }
                    }
                    
                    $li_class = 'sidebar-item';
                    if ($is_active) {
                        $li_class .= ' active';
                    }
                    
                    $html .= '<li class="' . htmlspecialchars($li_class) . '">' . PHP_EOL;
                    $html .= '<a href="' . base_url($url) . '" class="sidebar-link' . ($is_active ? ' active' : '') . '">' . PHP_EOL;
                    
                    if ($icon) {
                        $html .= '<i class="' . htmlspecialchars($icon) . '"></i>' . PHP_EOL;
                    }
                    
                    $html .= '<span class="menu-text">' . htmlspecialchars($label) . '</span>' . PHP_EOL;
                    
                    // Dynamic badge
                    if ($badge && isset($badges[$badge]) && $badges[$badge] > 0) {
                        $html .= '<span class="badge bg-primary">' . $badges[$badge] . '</span>' . PHP_EOL;
                    }
                    
                    $html .= '</a>' . PHP_EOL;
                    $html .= '</li>' . PHP_EOL;
                }
            }
        } else {
            // Fallback to flat items rendering
            foreach ($items as $item) {
                if (!$item->is_visible) {
                    continue;
                }
                
                // Check if item should be hidden for non-super-admins
                if (_should_hide_menu_item($item->item_url)) {
                    continue;
                }
                
                $url = _resolve_menu_item_url($item);
                $is_active = _is_menu_item_active($url, $current_url);
                
                $li_class = 'sidebar-item';
                if ($is_active) {
                    $li_class .= ' active';
                }
                
                $has_children = !empty($item->children);
                if ($has_children) {
                    $li_class .= ' has-submenu';
                }
                
                $html .= '<li class="' . htmlspecialchars($li_class) . '">' . PHP_EOL;
                
                $link_class = 'sidebar-link';
                if ($is_active) {
                    $link_class .= ' active';
                }
                
                $link_attrs = 'class="' . htmlspecialchars($link_class) . '"';
                if ($item->target_blank) {
                    $link_attrs .= ' target="_blank" rel="noopener noreferrer"';
                }
                
                $html .= '<a href="' . htmlspecialchars($url) . '" ' . $link_attrs . '>' . PHP_EOL;
                
                if ($item->item_icon) {
                    $html .= '<i class="' . htmlspecialchars($item->item_icon) . '"></i>' . PHP_EOL;
                }
                
                $html .= '<span class="menu-text">' . htmlspecialchars($item->item_label) . '</span>' . PHP_EOL;
                
                // Badges for flat items
                if ($item->item_url == 'admin/contacts' && isset($badges['unread_contacts']) && $badges['unread_contacts'] > 0) {
                    $html .= '<span class="badge bg-danger">' . $badges['unread_contacts'] . '</span>' . PHP_EOL;
                }
                if ($item->item_url == 'admin/appointments' && isset($badges['booking_count']) && $badges['booking_count'] > 0) {
                    $html .= '<span class="badge bg-primary">' . $badges['booking_count'] . '</span>' . PHP_EOL;
                }
                
                if ($has_children) {
                    $html .= '<i class="fas fa-chevron-right submenu-toggle"></i>' . PHP_EOL;
                }
                
                $html .= '</a>' . PHP_EOL;
                
                if ($has_children) {
                    $html .= '<ul class="submenu">' . PHP_EOL;
                    foreach ($item->children as $child) {
                        if (!$child->is_visible) continue;
                        
                        $child_url = _resolve_menu_item_url($child);
                        $child_active = _is_menu_item_active($child_url, $current_url);
                        
                        $child_class = 'submenu-item';
                        if ($child_active) {
                            $child_class .= ' active';
                        }
                        
                        $html .= '<li class="' . htmlspecialchars($child_class) . '">' . PHP_EOL;
                        $html .= '<a href="' . htmlspecialchars($child_url) . '">';
                        if ($child->item_icon) {
                            $html .= '<i class="' . htmlspecialchars($child->item_icon) . '"></i> ';
                        }
                        $html .= htmlspecialchars($child->item_label) . '</a>' . PHP_EOL;
                        $html .= '</li>' . PHP_EOL;
                    }
                    $html .= '</ul>' . PHP_EOL;
                }
                
                $html .= '</li>' . PHP_EOL;
            }
        }
        
        return $html;
    }
}

// Save admin menu JSON to database for a specific template
if (!function_exists('save_admin_menu_json')) {
    function save_admin_menu_json($menu_json, $template = null)
    {
        $CI = &get_instance();
        $CI->load->model('Settings_model');
        
        if ($template === null) {
            $CI->load->helper('template');
            $template = get_active_template();
        }
        
        return $CI->Settings_model->update('admin_menu_json', $menu_json, $template, 'admin');
    }
}

// Get admin menu JSON from database for a specific template
if (!function_exists('get_admin_menu_json')) {
    function get_admin_menu_json($template = null)
    {
        $CI = &get_instance();
        $CI->load->model('Settings_model');
        
        if ($template === null) {
            $CI->load->helper('template');
            $template = get_active_template();
        }
        
        return $CI->Settings_model->get('admin_menu_json', $template);
    }
}

// Reset admin menu to default for a template
if (!function_exists('reset_admin_menu')) {
    function reset_admin_menu($template = null)
    {
        $CI = &get_instance();
        $CI->load->model('Settings_model');
        
        if ($template === null) {
            $CI->load->helper('template');
            $template = get_active_template();
        }
        
        // Delete the admin_menu_json setting
        $CI->db->where('setting_key', 'admin_menu_json');
        $CI->db->where('template', $template);
        return $CI->db->delete('site_settings');
    }
}

// Export admin menu as JSON
if (!function_exists('export_admin_menu_json')) {
    function export_admin_menu_json($items)
    {
        $export = [];
        foreach ($items as $item) {
            $export[] = [
                'id' => $item->id,
                'label' => $item->item_label,
                'url' => $item->item_url,
                'icon' => $item->item_icon,
                'class' => $item->item_class,
                'target_blank' => $item->target_blank,
                'is_visible' => $item->is_visible,
                'sort_order' => $item->sort_order,
                'children' => !empty($item->children) ? export_admin_menu_json($item->children) : []
            ];
        }
        return $export;
    }
}
