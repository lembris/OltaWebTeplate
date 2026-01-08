<?php
/**
 * Footer Router
 * 
 * This file automatically loads the footer view for the active template.
 * Template-specific footers are located in: views/templates/{template_name}/footer.php
 */

// Load template helper if not already loaded
if (!function_exists('load_template_view')) {
    $this->load->helper('template');
}

// Load the template-specific footer
load_template_view('footer', get_defined_vars());
