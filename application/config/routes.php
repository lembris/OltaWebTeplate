<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Booking System Routes
$route['booking'] = 'booking/index';
$route['booking/check-availability'] = 'booking/check_availability';
$route['booking/check_availability'] = 'booking/check_availability';
$route['booking/calculate_price'] = 'booking/calculate_price';
$route['booking/get-pricing'] = 'booking/calculate_price';
$route['booking/process'] = 'booking/process';
$route['booking/confirmation/(:any)'] = 'booking/confirmation/$1';
$route['booking/lookup'] = 'booking/lookup';

// Gallery Routes
$route['gallery'] = 'gallery/index';

// Enquiry Routes
$route['enquiry'] = 'enquiry/index';
$route['enquiry/submit'] = 'enquiry/submit';
$route['enquiry/success'] = 'enquiry/success';

// Contact Routes
$route['contact'] = 'contact/index';
$route['contact/submit'] = 'contact/submit';
$route['contact/success'] = 'contact/success';
$route['contact/refresh_captcha'] = 'contact/refresh_captcha';
$route['contact/booking_query'] = 'contact/booking_query';

// Directory Routes
$route['directory'] = 'directorycontroller/index';
$route['directory/by_type/(:any)'] = 'directorycontroller/by_type/$1';
$route['directory/search'] = 'directorycontroller/search';
$route['directory/([a-f0-9\-]+)'] = 'directorycontroller/view/$1';

// Package Routes - SEO Optimized
$route['packages'] = 'packages/index';
$route['packages/(:any)'] = 'packages/package/$1';  // Clean URL: /packages/5-days-safari

// Alternative SEO Routes
$route['safari-packages'] = 'packages/index';
$route['safari-packages/(:any)'] = 'packages/package/$1';
$route['tanzania-safaris'] = 'packages/index';
$route['tanzania-safaris/(:any)'] = 'packages/package/$1';

// Legacy URL support (redirect old URLs)
$route['packages/package/(:any)'] = 'packages/package/$1';
$route['safari/(:any)'] = 'packages/package/$1';

// Destination Routes - SEO Optimized
$route['destinations'] = 'destinations/index';
$route['destinations/(:any)'] = 'destinations/destination/$1';  // Clean URL: /destinations/serengeti-national-park

// Destination SEO Aliases
$route['safari-destinations'] = 'destinations/index';
$route['safari-destinations/(:any)'] = 'destinations/destination/$1';
$route['tanzania-destinations'] = 'destinations/index';
$route['tanzania-destinations/(:any)'] = 'destinations/destination/$1';

// Legacy destination URL support
$route['destinations/destination/(:any)'] = 'destinations/destination/$1';

// Search Route
$route['search'] = 'packages/search';

// Blog Routes - SEO Optimized
$route['blog'] = 'blog/index';
$route['blog/page/(:num)'] = 'blog/index/$1';
$route['blog/post/(:any)'] = 'blog/post/$1';
$route['blog/category/(:any)'] = 'blog/category/$1';
$route['blog/category/(:any)/(:num)'] = 'blog/category/$1/$2';
$route['blog/search'] = 'blog/search';
$route['blog/(:any)'] = 'blog/post/$1';  // Catchall for clean blog URLs

// Blog SEO Aliases
$route['safari-blog'] = 'blog/index';
$route['travel-tips'] = 'blog/index';
$route['safari-blog/(:any)'] = 'blog/post/$1';

// Blog API
$route['api/blog/latest'] = 'blog/api_latest';
$route['api/blog/popular'] = 'blog/api_most_viewed';
$route['api/blog/most-viewed'] = 'blog/api_most_viewed';
$route['api/blog/popular-tags'] = 'blog/api_popular_tags';

// Programs Routes - SEO Optimized
$route['programs'] = 'programs/index';
$route['programs/(:any)'] = 'programs/view/$1';  // Clean URL: /programs/BBA

// Page Routes - SEO Optimized
$route['page/(:any)'] = 'page/view/$1';

// SEO Routes - Sitemap & Robots
$route['sitemap.xml'] = 'sitemap/index';
$route['sitemap'] = 'sitemap/index';
$route['sitemap-index.xml'] = 'sitemap/sitemap_index';

// =====================================================
// ADMIN PANEL ROUTES
// =====================================================

// Admin Authentication
$route['admin'] = 'admin/dashboard';
$route['admin/login'] = 'admin/auth/login';
$route['admin/logout'] = 'admin/auth/logout';
$route['admin/forgot-password'] = 'admin/auth/forgot_password';

// Admin Dashboard
$route['admin/dashboard'] = 'admin/dashboard/index';

// Admin Packages
$route['admin/packages'] = 'admin/packages/index';
$route['admin/packages/create'] = 'admin/packages/create';
$route['admin/packages/edit/(:num)'] = 'admin/packages/edit/$1';
$route['admin/packages/delete/(:num)'] = 'admin/packages/delete/$1';
$route['admin/packages/toggle-featured/(:num)'] = 'admin/packages/toggle_featured/$1';
$route['admin/packages/toggle-active/(:num)'] = 'admin/packages/toggle_active/$1';

// Admin Blog
$route['admin/blog'] = 'admin/blog/index';
$route['admin/blog/create'] = 'admin/blog/create';
$route['admin/blog/edit/([a-f0-9\-]+)'] = 'admin/blog/edit/$1';
$route['admin/blog/delete/([a-f0-9\-]+)'] = 'admin/blog/delete/$1';
$route['admin/blog/toggle_publish/([a-f0-9\-]+)'] = 'admin/blog/toggle_publish/$1';

// Admin Bookings
$route['admin/bookings'] = 'admin/bookings/index';
$route['admin/bookings/view/(:num)'] = 'admin/bookings/view/$1';
$route['admin/bookings/update-status/(:num)'] = 'admin/bookings/update_status/$1';
$route['admin/bookings/delete/(:num)'] = 'admin/bookings/delete/$1';
$route['admin/bookings/export'] = 'admin/bookings/export';

// Admin Enquiries
$route['admin/enquiries'] = 'admin/enquiries/index';
$route['admin/enquiries/view/([a-f0-9\-]+)'] = 'admin/enquiries/view/$1';
$route['admin/enquiries/update-status/([a-f0-9\-]+)'] = 'admin/enquiries/update_status/$1';
$route['admin/enquiries/reply/([a-f0-9\-]+)'] = 'admin/enquiries/reply/$1';
$route['admin/enquiries/edit/([a-f0-9\-]+)'] = 'admin/enquiries/edit/$1';
$route['admin/enquiries/add-note/([a-f0-9\-]+)'] = 'admin/enquiries/add_note/$1';
$route['admin/enquiries/delete/([a-f0-9\-]+)'] = 'admin/enquiries/delete/$1';
$route['admin/enquiries/export'] = 'admin/enquiries/export';

// Admin Itineraries
$route['admin/itineraries'] = 'admin/itineraries/index';
$route['admin/itineraries/manage/(:num)'] = 'admin/itineraries/manage/$1';
$route['admin/itineraries/create/(:num)'] = 'admin/itineraries/create/$1';
$route['admin/itineraries/edit/(:num)'] = 'admin/itineraries/edit/$1';
$route['admin/itineraries/delete/(:num)'] = 'admin/itineraries/delete/$1';
$route['admin/itineraries/reorder'] = 'admin/itineraries/reorder';

// Admin Settings
$route['admin/settings'] = 'admin/settings/index';
$route['admin/settings/save'] = 'admin/settings/save';
$route['admin/settings/clear-cache'] = 'admin/settings/clear_cache';
$route['admin/settings/test-email'] = 'admin/settings/test_email';

// Admin SEO
$route['admin/seo/generate-quick'] = 'admin/seo/generate_quick';
$route['admin/seo/generate-ai'] = 'admin/seo/generate_ai';
$route['admin/seo/ai-status'] = 'admin/seo/ai_status';

// Admin Directory
$route['admin/directory'] = 'admin/directorycontroller/index';
$route['admin/directory/create'] = 'admin/directorycontroller/create';
$route['admin/directory/edit/([a-f0-9\-]+)'] = 'admin/directorycontroller/edit/$1';
$route['admin/directory/view/([a-f0-9\-]+)'] = 'admin/directorycontroller/view/$1';
$route['admin/directory/delete/([a-f0-9\-]+)'] = 'admin/directorycontroller/delete/$1';
$route['admin/directory/toggle-status/([a-f0-9\-]+)'] = 'admin/directorycontroller/toggle_status/$1';

// Legacy directorymgmt routes (for backward compatibility)
$route['admin/directorymgmt'] = 'admin/directorycontroller/index';
$route['admin/directorymgmt/create'] = 'admin/directorycontroller/create';
$route['admin/directorymgmt/edit/([a-f0-9\-]+)'] = 'admin/directorycontroller/edit/$1';
$route['admin/directorymgmt/view/([a-f0-9\-]+)'] = 'admin/directorycontroller/view/$1';
$route['admin/directorymgmt/delete/([a-f0-9\-]+)'] = 'admin/directorycontroller/delete/$1';
$route['admin/directorymgmt/toggle-status/([a-f0-9\-]+)'] = 'admin/directorycontroller/toggle_status/$1';

// Frontend Events Routes
$route['events'] = 'events/index';
$route['events/calendar'] = 'events/calendar';
$route['events/search'] = 'events/search';
$route['events/type/(:any)'] = 'events/by_type/$1';
$route['events/register/([a-f0-9\-]+)'] = 'events/register/$1';
$route['events/([a-f0-9\-]+)'] = 'events/view/$1';

// Admin Events
$route['admin/events'] = 'admin/events/index';
$route['admin/events/create'] = 'admin/events/create';
$route['admin/events/edit/([a-f0-9\-]+)'] = 'admin/events/edit/$1';
$route['admin/events/view/([a-f0-9\-]+)'] = 'admin/events/view/$1';
$route['admin/events/delete/([a-f0-9\-]+)'] = 'admin/events/delete/$1';
$route['admin/events/toggle-status/([a-f0-9\-]+)'] = 'admin/events/toggle_status/$1';

// =====================================================
// COMMUNICATIONS MODULE ROUTES
// =====================================================

// Frontend Notices Routes
$route['notices'] = 'notices/index';
$route['notices/page/(:num)'] = 'notices/index/$1';
$route['notices/category/(:any)'] = 'notices/category/$1';
$route['notices/category/(:any)/(:num)'] = 'notices/category/$1/$2';
$route['notices/download/(:any)'] = 'notices/download/$1';
$route['notices/(:any)'] = 'notices/view/$1';

// Frontend Announcements Routes
$route['announcements'] = 'announcements/index';
$route['announcements/track_click/(:any)'] = 'announcements/track_click/$1';
$route['announcements/(:any)'] = 'announcements/view/$1';

// Notices/Announcements API
$route['api/notices/latest'] = 'notices/api_latest';
$route['api/notices/pinned'] = 'notices/api_pinned';
$route['api/announcements/homepage'] = 'announcements/api_homepage';
$route['api/announcements/header'] = 'announcements/api_header';
$route['api/announcements/popup'] = 'announcements/api_popup';

// Admin Notices Routes
$route['admin/notices'] = 'admin/notices/index';
$route['admin/notices/create'] = 'admin/notices/create';
$route['admin/notices/edit/([a-f0-9\-]+)'] = 'admin/notices/edit/$1';
$route['admin/notices/delete/([a-f0-9\-]+)'] = 'admin/notices/delete/$1';
$route['admin/notices/toggle_publish/([a-f0-9\-]+)'] = 'admin/notices/toggle_publish/$1';
$route['admin/notices/toggle_pinned/([a-f0-9\-]+)'] = 'admin/notices/toggle_pinned/$1';

// Admin Announcements Routes
$route['admin/announcements'] = 'admin/announcements/index';
$route['admin/announcements/create'] = 'admin/announcements/create';
$route['admin/announcements/edit/([a-f0-9\-]+)'] = 'admin/announcements/edit/$1';
$route['admin/announcements/delete/([a-f0-9\-]+)'] = 'admin/announcements/delete/$1';
$route['admin/announcements/toggle_publish/([a-f0-9\-]+)'] = 'admin/announcements/toggle_publish/$1';
$route['admin/announcements/update_order'] = 'admin/announcements/update_order';

// Admin Contact Groups Routes (using UID pattern)
$route['admin/contact-groups'] = 'admin/contactgroups/index';
$route['admin/contact-groups/create'] = 'admin/contactgroups/create';
$route['admin/contact-groups/edit/([a-f0-9\-]+)'] = 'admin/contactgroups/edit/$1';
$route['admin/contact-groups/delete/([a-f0-9\-]+)'] = 'admin/contactgroups/delete/$1';
$route['admin/contact-groups/toggle-status/([a-f0-9\-]+)'] = 'admin/contactgroups/toggle_status/$1';
$route['admin/contact-groups/members/([a-f0-9\-]+)'] = 'admin/contactgroups/members/$1';
$route['admin/contact-groups/add-member/([a-f0-9\-]+)'] = 'admin/contactgroups/add_member/$1';
$route['admin/contact-groups/edit-member/([a-f0-9\-]+)'] = 'admin/contactgroups/edit_member/$1';
$route['admin/contact-groups/delete-member/([a-f0-9\-]+)'] = 'admin/contactgroups/delete_member/$1';
$route['admin/contact-groups/toggle-member-status/([a-f0-9\-]+)'] = 'admin/contactgroups/toggle_member_status/$1';
$route['admin/contact-groups/import-members/([a-f0-9\-]+)'] = 'admin/contactgroups/import_members/$1';
$route['admin/contact-groups/get-member-json/([a-f0-9\-]+)'] = 'admin/contactgroups/get_member_json/$1';

// Admin Bulk Notifications Routes
$route['admin/bulk-notifications'] = 'admin/bulknotifications/index';
$route['admin/bulk-notifications/create'] = 'admin/bulknotifications/create';
$route['admin/bulk-notifications/edit/([a-f0-9\-]+)'] = 'admin/bulknotifications/edit/$1';
$route['admin/bulk-notifications/view/([a-f0-9\-]+)'] = 'admin/bulknotifications/view/$1';
$route['admin/bulk-notifications/send/([a-f0-9\-]+)'] = 'admin/bulknotifications/send/$1';
$route['admin/bulk-notifications/delete/([a-f0-9\-]+)'] = 'admin/bulknotifications/delete/$1';
$route['admin/bulk-notifications/cancel/([a-f0-9\-]+)'] = 'admin/bulknotifications/cancel/$1';
$route['admin/bulk-notifications/duplicate/([a-f0-9\-]+)'] = 'admin/bulknotifications/duplicate/$1';
$route['admin/bulk-notifications/templates'] = 'admin/bulknotifications/templates';
$route['admin/bulk-notifications/get-template-json/(:num)'] = 'admin/bulknotifications/get_template_json/$1';
$route['admin/bulk-notifications/preview-recipients'] = 'admin/bulknotifications/preview_recipients';
