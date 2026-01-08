-- Add active_template setting to site_settings table
-- Run this SQL to enable template switching

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`, `created_at`, `updated_at`) 
VALUES ('active_template', 'tourism', 'template', NOW(), NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- Add template-related settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`, `created_at`, `updated_at`) 
VALUES ('template_cache_enabled', '0', 'template', NOW(), NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();
