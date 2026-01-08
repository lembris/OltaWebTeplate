# Institute College Management System

A comprehensive college website and management system built with CodeIgniter 3. Supports both educational institution and tourism business templates with flexible multi-template architecture.

## Features

### Frontend - College Template
- **Academic Programs** - Browse and view detailed degree, diploma, and certification programs
- **Departments** - Explore college departments and their offerings
- **Faculty Directory** - Faculty member profiles with expertise and qualifications
- **Events Calendar** - Upcoming college events, seminars, and workshops
- **Announcements** - Important college announcements and news
- **Notices** - Academic notices, exam schedules, and important dates
- **Enquiry System** - Contact forms with reference tracking for admissions inquiries
- **Gallery** - Photo galleries of campus, facilities, and student activities
- **Blog** - Educational articles, student testimonials, and campus news
- **Newsletter Subscription** - Email subscription system for updates
- **Search** - Search functionality across programs, faculty, and content
- **Responsive Design** - Mobile-friendly interface optimized for all devices

### Admin Panel
- **Dashboard** - Overview with key metrics, quick actions, and analytics
- **Visitor Analytics** - Track page views, countries, devices, browsers
- **Program Management** - Create/edit academic programs with details and requirements
- **Department Management** - Manage college departments
- **Faculty Management** - Add and manage faculty profiles with credentials
- **Event Management** - Create and manage college events
- **Notice Management** - Publish academic notices and important dates
- **Announcement Management** - Post college-wide announcements
- **Enquiry Management** - Handle student inquiries with responses
- **Blog Management** - Write and publish blog posts with CKEditor
- **Gallery Management** - Upload and organize campus photos by category
- **Page Management** - Edit static pages (About, Contact, Admissions, etc.)
- **SEO Settings** - Meta tags, descriptions, and sitemap configuration
- **AI-Powered SEO Generation** - Auto-generate meta titles, descriptions, keywords using OpenAI or Claude API
- **Profile Management** - Admin user profile and password updates
- **Site Settings** - Site configuration, contact info, social links
- **Role-Based Access Control** - Roles & Permissions system with visual ranking indicators
- **Template Switching** - Toggle between college and tourism templates
- **Multi-template Support** - Seamlessly switch between different website templates

### Frontend - Tourism Template
- **Safari Packages** - Browse and view detailed safari tour packages
- **Destinations** - Explore wildlife destinations (Serengeti, Ngorongoro, etc.)
- **Itineraries** - Day-by-day safari itinerary details
- **Online Booking** - Complete booking system with email notifications
- **Gallery** - Photo gallery of safari experiences
- **Blog** - Travel guides, safari tips, and wildlife articles

## Installation

### Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache with mod_rewrite enabled
- XAMPP/WAMP/LAMP or similar

### Setup Steps

1. **Clone or download** to your web server directory:
   ```bash
   git clone <repository-url> institute
   ```

2. **Create database** named `institute` in phpMyAdmin

3. **Import SQL migrations** from `DB/` folder:
   - `admin_panel_complete_migration.sql`
   - `visitors_tracking_migration.sql`
   - `college_template_migration.sql`

4. **Configure database** in `application/config/database.php`:
   ```php
   'hostname' => 'localhost',
   'username' => 'root',
   'password' => '',
   'database' => 'institute',
   ```

5. **Configure base URL** in `application/config/config.php`:
   ```php
   $config['base_url'] = 'http://localhost/institute/';
   ```

6. **Set folder permissions** (Windows/Linux/Mac):
   ```bash
   chmod -R 755 assets/uploads
   chmod -R 755 assets/images
   ```

## Admin Access

- **URL:** `http://localhost/institute/admin`
- **Username:** `admin`
- **Password:** `admin123`

> ⚠️ Change the default password after first login!

## Project Structure

```
institute/
├── application/
│   ├── config/              # Configuration files
│   ├── controllers/         # Controllers (frontend & admin)
│   │   ├── Admin_*.php      # Admin panel controllers
│   │   ├── Home.php         # Homepage controller
│   │   └── ...              # Feature controllers
│   ├── core/                # Base controllers
│   ├── models/              # Database models
│   │   ├── Academic_program_model.php
│   │   ├── Faculty_staff_model.php
│   │   ├── Department_model.php
│   │   ├── Package_model.php    # Tourism packages
│   │   └── ...
│   ├── views/               # View templates
│   │   ├── admin/           # Admin panel views
│   │   ├── templates/       # Multi-template views
│   │   │   ├── college/     # College template pages
│   │   │   └── tourism/     # Tourism template pages
│   │   ├── pages/           # Frontend pages
│   │   └── includes/        # Header, footer, navigation
│   ├── helpers/             # Helper functions
│   └── sql/                 # Database migrations
├── assets/
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript files
│   ├── images/              # Static images
│   └── uploads/             # User uploads
├── template/                # Template files
├── system/                  # CodeIgniter core
├── DB/                      # Database migration files
└── index.php                # Application entry point
```

## Technologies

- **Backend:** CodeIgniter 3.x (PHP)
- **Database:** MySQL
- **Frontend:** Bootstrap 5, JavaScript
- **Icons:** Font Awesome 6, Bootstrap Icons
- **Charts:** Chart.js
- **Editor:** CKEditor 5
- **Tables:** DataTables

## Template System

The system supports multiple templates for different business types:

### College Template
Optimized for educational institutions with:
- Academic program management
- Faculty directory
- Department structure
- Events and announcements
- Admissions-focused features

### Tourism Template
Optimized for tourism businesses with:
- Safari packages
- Destinations
- Tour itineraries
- Booking system
- Travel guides

Switch templates in Admin Settings (no database changes required).

## Visitor Analytics

Built-in analytics dashboard provides:
- Page views & unique visitors
- Device breakdown (desktop/mobile/tablet)
- Browser statistics
- Country geolocation (via ip-api.com)
- Popular pages ranking
- Weekly/monthly trends with charts

## Email Configuration

Configure email in `application/config/email.php` for:
- Booking confirmations
- Enquiry notifications
- Program inquiry responses
- Password reset
- Newsletter delivery

## Maintenance

### Clear Logs
```bash
rm -f application/logs/*.php
```

### Cleanup Old Visitor Data
The system automatically handles cleanup, or run manually via model:
```php
$this->Visitor_model->cleanup_old_logs(90); // Keep 90 days
```

## License

This project is proprietary software for Institute College Management System.

## Support

For support or questions, contact the development team.

---

Built with care for educational institutions and tourism businesses
