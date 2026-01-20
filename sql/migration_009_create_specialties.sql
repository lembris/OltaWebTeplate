-- Migration 009: Create specialties table for medical template
-- Stores TNA CARE services (Health Education, Medical Outreach, Corporate Wellness, etc.)
-- Run this SQL in phpMyAdmin (database: dmi)

CREATE TABLE IF NOT EXISTS `specialties` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `uid` varchar(36) NOT NULL,
    `name` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `short_description` varchar(255) DEFAULT NULL,
    `description` text DEFAULT NULL,
    `icon` varchar(100) DEFAULT NULL COMMENT 'Bootstrap icon class or image path',
    `image` varchar(255) DEFAULT NULL,
    `category` varchar(100) DEFAULT NULL COMMENT 'e.g., health_education, medical_outreach, corporate_wellness, health_media',
    `features` text DEFAULT NULL COMMENT 'JSON array of feature points',
    `display_order` int(11) NOT NULL DEFAULT 0,
    `is_featured` tinyint(1) NOT NULL DEFAULT 0,
    `status` enum('active','inactive') NOT NULL DEFAULT 'active',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert 10 TNA CARE services
INSERT INTO `specialties` (`uid`, `name`, `slug`, `short_description`, `description`, `icon`, `category`, `features`, `display_order`, `is_featured`, `status`) VALUES
('serv-001', 'Digital Health Education', 'digital-health-education', 'Online health education programs and resources', 'Comprehensive digital health education programs designed to bridge the gap between reliable health information and underserved communities across Tanzania and East Africa.', 'bi-laptop', 'health_education', '["Online Courses", "Webinars & Workshops", "Health Podcasts", "Interactive Content", "Mobile Health Apps"]', 1, 1, 'active'),
('serv-002', 'Community Health Outreach', 'community-health-outreach', 'Mobile health camps and community screenings', 'Our community outreach programs bring essential healthcare services directly to underserved populations through mobile health camps, school screenings, and village health days.', 'bi-people', 'medical_outreach', '["Free Health Screenings", "Vaccination Drives", "Health Awareness Campaigns", "Community Training", "Mobile Clinics"]', 2, 1, 'active'),
('serv-003', 'Corporate Wellness Programs', 'corporate-wellness-programs', 'Employee health and wellness solutions', 'Customized wellness and mental health solutions designed to improve employee health, productivity, and workplace satisfaction for companies and institutions.', 'bi-briefcase', 'corporate_wellness', '["Employee Health Assessments", "Stress Management Workshops", "Ergonomic Training", "Wellness Seminars", "Mental Health Support"]', 3, 1, 'active'),
('serv-004', 'Health Media Solutions', 'health-media-solutions', 'Health communication and media production', 'Professional health communication and media production services including documentaries, social media campaigns, print materials, and radio programs.', 'bi-camera-video', 'health_media', '["Health Documentaries", "Social Media Campaigns", "Print Materials", "Radio Programs", "Video Production"]', 4, 0, 'active'),
('serv-005', 'Nutrition & Diet Counseling', 'nutrition-diet-counseling', 'Professional nutrition advice and meal planning', 'Expert nutrition and diet counseling services tailored to individual health needs, promoting healthy eating habits and managing diet-related conditions.', 'bi-apple', 'health_education', '["Personalized Diet Plans", "Nutritional Assessments", "Weight Management", "Disease-Specific Diets", "Nutrition Workshops"]', 5, 0, 'active'),
('serv-006', 'Mental Health Support', 'mental-health-support', 'Psychological counseling and mental wellness', 'Comprehensive mental health support services including individual counseling, group therapy, crisis intervention, and mental wellness workshops.', 'bi-heart-pulse', 'health_education', '["Individual Counseling", "Group Therapy", "Crisis Intervention", "Mental Health Workshops", "Stress Management"]', 6, 0, 'active'),
('serv-007', 'Maternal & Child Health', 'maternal-child-health', 'Care for mothers and children', 'Specialized maternal and child health services focusing on prenatal care, postnatal support, child immunization, and growth monitoring.', 'bi-heart', 'medical_outreach', '["Prenatal Care", "Postnatal Support", "Child Immunization", "Growth Monitoring", "Mother Education"]', 7, 1, 'active'),
('serv-008', 'Chronic Disease Management', 'chronic-disease-management', 'Long-term care for chronic conditions', 'Ongoing care and management for chronic conditions including diabetes, hypertension, COPD, and cancer screening services.', 'bi-activity', 'health_education', '["Diabetes Management", "Hypertension Monitoring", "COPD Care", "Cancer Screening", "Lifestyle Counseling"]', 8, 0, 'active'),
('serv-009', 'School Health Programs', 'school-health-programs', 'Health education and services in schools', 'Comprehensive health programs designed for schools including health education, screenings, vaccination drives, and student wellness initiatives.', 'bi-book', 'medical_outreach', '["Health Education", "Vision Screening", "Dental Checks", "Nutrition Programs", "Mental Health Support"]', 9, 0, 'active'),
('serv-010', 'NGO & Government Partnerships', 'ngo-government-partnerships', 'Collaborations with organizations', 'Strategic partnerships with NGOs and government agencies to implement large-scale health programs and community interventions.', 'bi-building', 'corporate_wellness', '["Program Implementation", "Health Surveys", "Capacity Building", "Policy Support", "Monitoring & Evaluation"]', 10, 0, 'active');
