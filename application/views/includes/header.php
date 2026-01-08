<?php
/**
 * Header Router
 * 
 * This file automatically loads the header view for the active template.
 * Template-specific headers are located in: views/templates/{template_name}/header.php
 */

// Load template helper if not already loaded
if (!function_exists('load_template_view')) {
    $this->load->helper('template');
}

// Load the template-specific header
load_template_view('header', get_defined_vars());
