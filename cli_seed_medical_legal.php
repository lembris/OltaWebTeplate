<?php
/**
 * Command Line Seeder Runner
 *
 * Run from command line: php index.php seeders/medical_legal_pages
 */

// Include the seeder class
require_once APPPATH . 'seeders/Medical_Legal_Pages_Seeder.php';

// Create and run the seeder
$seeder = new Medical_Legal_Pages_Seeder();
$seeder->run();