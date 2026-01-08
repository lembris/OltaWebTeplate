<?php
/**
 * Navigation Router
 * 
 * This file automatically loads the navigation view for the active template.
 * Template-specific navigation are located in: views/templates/{template_name}/navigation.php
 */

// Load template helper if not already loaded
if (!function_exists('load_template_view')) {
    $this->load->helper('template');
}

// Load the template-specific navigation
load_template_view('navigation', get_defined_vars());
