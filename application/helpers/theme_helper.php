<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Theme Helper
 * Handles theme colors and styling configurations
 */

/**
 * Get all theme colors from settings
 */
function get_theme_colors()
{
    $ci = &get_instance();
    $ci->load->model('Settings_model');
    $ci->load->helper('template');
    
    $active_template = get_active_template();
    $settings = $ci->Settings_model->get_all($active_template);
    
    return [
        'primary' => $settings['theme_primary_color'] ?? $settings['primary_color'] ?? '#C7805C',
        'secondary' => $settings['theme_secondary_color'] ?? $settings['secondary_color'] ?? '#90B3A7',
        'accent' => $settings['theme_accent_color'] ?? $settings['accent_color'] ?? '#D9B39B',
        'background' => $settings['theme_background_color'] ?? $settings['background_color'] ?? '#F5F0E1',
        'text' => $settings['theme_text_color'] ?? $settings['text_color'] ?? '#2c3e50',
    ];
}

/**
 * Get dynamic event type colors based on theme
 */
function get_event_type_colors()
{
    $colors = get_theme_colors();
    
    // Map event types to theme colors
    return [
        'workshop' => $colors['primary'],
        'academic' => $colors['secondary'],
        'conference' => $colors['accent'],
        'cultural' => $colors['primary'],
        'sports' => $colors['secondary'],
        'seminar' => $colors['accent'],
        'webinar' => $colors['primary'],
        'guest_lecture' => $colors['secondary'],
        'competition' => $colors['accent'],
        'default' => $colors['text']
    ];
}

/**
 * Get color for specific event type
 * 
 * @param string $event_type Event type name
 * @return string Hex color code
 */
function get_event_color($event_type = 'default')
{
    $colors = get_event_type_colors();
    $type = strtolower(str_replace(' ', '_', $event_type ?? 'default'));
    return $colors[$type] ?? $colors['default'];
}

/**
 * Get primary theme color
 */
function get_primary_color()
{
    $colors = get_theme_colors();
    return $colors['primary'];
}

/**
 * Get secondary theme color
 */
function get_secondary_color()
{
    $colors = get_theme_colors();
    return $colors['secondary'];
}

/**
 * Get accent theme color
 */
function get_accent_color()
{
    $colors = get_theme_colors();
    return $colors['accent'];
}

/**
 * Get background theme color
 */
function get_background_color()
{
    $colors = get_theme_colors();
    return $colors['background'];
}

/**
 * Get text/dark theme color
 */
function get_text_color()
{
    $colors = get_theme_colors();
    return $colors['text'];
}

/**
 * Get a specific theme color by name
 * 
 * @param string $name Color name (primary, secondary, accent, background, text)
 * @return string Hex color code
 */
function get_theme_color($name = 'primary')
{
    $colors = get_theme_colors();
    return $colors[$name] ?? $colors['primary'];
}

/**
 * Check if a color is light or dark
 * 
 * @param string $hex Hex color code
 * @return bool True if light, false if dark
 */
function is_light_color($hex)
{
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    return $brightness > 155;
}

/**
 * Get contrasting text color (white or black) for a given background
 * 
 * @param string $hex Hex color code
 * @return string White or black hex color
 */
function get_contrast_text_color($hex)
{
    return is_light_color($hex) ? '#000000' : '#FFFFFF';
}

/**
 * Convert hex to RGB
 * 
 * @param string $hex Hex color code
 * @return string RGB values (e.g., "23, 92, 221")
 */
function hex_to_rgb($hex)
{
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return "{$r}, {$g}, {$b}";
}

/**
 * Generate CSS for theme colors
 * 
 * @return string CSS rules
 */
function generate_theme_css()
{
    $colors = get_theme_colors();
    $primary_dark = darken_color($colors['primary'], 15);
    $secondary_dark = darken_color($colors['secondary'], 15);
    $primary_rgb = hex_to_rgb($colors['primary']);
    $secondary_rgb = hex_to_rgb($colors['secondary']);
    $accent_rgb = hex_to_rgb($colors['accent']);
    
    $css = ":root {
        --primary-color: {$colors['primary']};
        --theme-primary: {$colors['primary']};
        --theme-primary-rgb: {$primary_rgb};
        --primary-dark: {$primary_dark};
        --primary: {$colors['primary']};
        --primary-light: {$colors['accent']};
        --secondary-color: {$colors['secondary']};
        --theme-secondary: {$colors['secondary']};
        --theme-secondary-rgb: {$secondary_rgb};
        --secondary-dark: {$secondary_dark};
        --secondary: {$colors['secondary']};
        --accent-color: {$colors['accent']};
        --theme-accent: {$colors['accent']};
        --theme-accent-rgb: {$accent_rgb};
        --accent: {$colors['accent']};
        --background-color: {$colors['background']};
        --theme-background: {$colors['background']};
        --text-color: {$colors['text']};
        --theme-text: {$colors['text']};
        --contrast-color: #ffffff;
        --surface-color: #ffffff;
    }
    
    /* Button styling - overrides Bootstrap defaults with high specificity */
    .btn-primary,
    .btn.btn-primary,
    a.btn-primary,
    a.btn.btn-primary,
    button.btn-primary,
    button.btn.btn-primary,
    input.btn-primary,
    input.btn.btn-primary {
        background-color: {$colors['primary']} !important;
        border-color: {$colors['primary']} !important;
        background: linear-gradient(135deg, {$colors['primary']} 0%, {$primary_dark} 100%) !important;
        color: white !important;
    }
    
    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active,
    .btn.btn-primary:hover,
    .btn.btn-primary:focus,
    .btn.btn-primary:active,
    a.btn-primary:hover,
    a.btn.btn-primary:hover,
    button.btn-primary:hover,
    button.btn.btn-primary:hover {
        background-color: {$primary_dark} !important;
        border-color: {$primary_dark} !important;
        background: linear-gradient(135deg, {$primary_dark} 0%, {$colors['primary']} 100%) !important;
        color: white !important;
    }
    ";
    
    return $css;
}

/**
 * Darken a hex color
 * 
 * @param string $hex Hex color code
 * @param int $percent Percentage to darken (0-100)
 * @return string Darkened hex color
 */
function darken_color($hex, $percent)
{
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $r = max(0, $r - round(255 * ($percent / 100)));
    $g = max(0, $g - round(255 * ($percent / 100)));
    $b = max(0, $b - round(255 * ($percent / 100)));
    
    return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT) . 
           str_pad(dechex($g), 2, '0', STR_PAD_LEFT) . 
           str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
}

/**
 * Lighten a hex color
 * 
 * @param string $hex Hex color code
 * @param int $percent Percentage to lighten (0-100)
 * @return string Lightened hex color
 */
function lighten_color($hex, $percent)
{
     $hex = str_replace('#', '', $hex);
     $r = hexdec(substr($hex, 0, 2));
     $g = hexdec(substr($hex, 2, 2));
     $b = hexdec(substr($hex, 4, 2));
     
     $r = min(255, $r + round(255 * ($percent / 100)));
     $g = min(255, $g + round(255 * ($percent / 100)));
     $b = min(255, $b + round(255 * ($percent / 100)));
     
     return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT) . 
            str_pad(dechex($g), 2, '0', STR_PAD_LEFT) . 
            str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
}

/**
 * Output dynamic theme CSS as inline style tag
 * 
 * @return string HTML style tag with theme CSS
 */
function get_theme_css()
{
     $css = generate_theme_css();
     return '<style>' . "\n" . $css . "\n" . '</style>';
}
