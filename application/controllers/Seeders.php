<?php
/**
 * Run Medical Legal Pages Seeder
 *
 * Usage: Include this file in your CodeIgniter application and visit the URL
 * or run via command line: php index.php seeders/medical_legal_pages
 */

class Seeders extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function medical_legal_pages()
    {
        // Check if user is admin (optional security)
        if (!$this->session->userdata('admin_logged_in')) {
            show_error('Access denied. Admin login required.', 403);
            return;
        }

        // Include the seeder
        require_once APPPATH . 'seeders/Medical_Legal_Pages_Seeder.php';

        // Create and run the seeder
        $seeder = new Medical_Legal_Pages_Seeder();
        $seeder->run();

        echo '<br><br><a href="' . base_url('admin/pages') . '">← Back to Pages Management</a>';
    }
}