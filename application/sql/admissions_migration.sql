-- Admissions Migration
-- Run this SQL to create the admissions table

CREATE TABLE IF NOT EXISTS `admissions` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` int(11) UNSIGNED DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other','prefer_not_to_say') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institution_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `graduation_year` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gpa_score` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_relation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documents` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'JSON array of uploaded document paths',
  `personal_statement` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `how_did_you_hear` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','under_review','accepted','rejected','waitlisted','enrolled','withdrawn') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reviewed_by` int(11) UNSIGNED DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `intake_term` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intake_year` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`),
  UNIQUE KEY `reference_number` (`reference_number`),
  KEY `program_id` (`program_id`),
  KEY `status` (`status`),
  KEY `email` (`email`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admission notes table for tracking communication and internal notes
CREATE TABLE IF NOT EXISTS `admission_notes` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `admission_id` int(11) UNSIGNED NOT NULL,
  `admin_id` int(11) UNSIGNED DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `admission_id` (`admission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Status history table
CREATE TABLE IF NOT EXISTS `admission_status_history` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `admission_id` int(11) UNSIGNED NOT NULL,
  `old_status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `changed_by` int(11) UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `admission_id` (`admission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
