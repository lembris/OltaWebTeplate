-- Create Testimonials Table
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `company` varchar(150) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` tinyint(1) DEFAULT 5,
  `image` varchar(255) DEFAULT NULL,
  `theme` varchar(50) DEFAULT 'all',
  `display_order` int(11) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`),
  KEY `status` (`status`),
  KEY `theme` (`theme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample testimonials for medical template
INSERT INTO `testimonials` (`uid`, `name`, `role`, `company`, `location`, `content`, `rating`, `theme`, `display_order`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES
('TST-001-MEDICAL-001', 'Dr. Sarah Johnson', 'Cardiologist', 'National Hospital', 'Dar es Salaam, Tanzania', 'TNA CARE has been an invaluable partner in our medical outreach programs. Their commitment to healthcare excellence is truly inspiring.', 5, 'medical', 1, 1, 'active', NOW(), NOW()),
('TST-002-MEDICAL-002', 'Michael Chen', 'Hospital Administrator', 'City Medical Center', 'Arusha, Tanzania', 'The corporate wellness programs offered by TNA CARE have significantly improved our staff health metrics. Highly recommended!', 5, 'medical', 2, 1, 'active', NOW(), NOW()),
('TST-003-MEDICAL-003', 'Emily Williams', 'Patient', '', 'Mwanza, Tanzania', 'The health education resources provided helped me understand my condition better. Grateful for TNA CARE\'s dedication.', 5, 'medical', 3, 0, 'active', NOW(), NOW()),
('TST-004-MEDICAL-004', 'Dr. James Wilson', 'General Practitioner', 'Rural Health Clinic', ' Dodoma, Tanzania', 'TNA CARE\'s medical outreach brought specialist services to our community. Life-changing work!', 5, 'medical', 4, 1, 'active', NOW(), NOW());
