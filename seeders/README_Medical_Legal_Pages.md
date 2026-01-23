# Medical Legal Pages Seeder

This seeder creates essential legal pages for the Medical template of your TNA CARE website.

## 📄 Pages Created

The seeder creates the following pages with medical/healthcare-specific content:

1. **Privacy Policy** (`/page/privacy-policy`)
   - Healthcare data protection
   - Patient information handling
   - Medical privacy rights

2. **Terms of Service** (`/page/terms-of-service`)
   - Healthcare service terms
   - Medical consultation conditions
   - Payment and liability terms

3. **Refund Policy** (`/page/refund-policy`)
   - Healthcare service refunds
   - Consultation cancellation terms
   - Medical tourism refunds

4. **Cookie Policy** (`/page/cookie-policy`)
   - Website cookie usage
   - Analytics and tracking
   - Privacy compliance

5. **Disclaimer** (`/page/disclaimer`)
   - Medical advice limitations
   - Service liability disclaimers
   - Healthcare information notices

## 🚀 How to Run the Seeder

### Method 1: Web Interface (Admin Only)
```
https://localhost/institute/seeders/medical_legal_pages
```
*Requires admin login*

### Method 2: Command Line
```bash
cd /path/to/your/project
php cli_seed_medical_legal.php
```

### Method 3: Direct PHP Execution
```bash
php index.php seeders/medical_legal_pages
```

## ✅ Features

- **Theme-Specific**: All pages are created with `theme = 'medical'`
- **Footer Integration**: Pages are set to `show_in_footer = 1` by default
- **SEO Optimized**: Includes meta titles, descriptions, and keywords
- **Duplicate Safe**: Skips pages that already exist
- **Professional Content**: Healthcare-focused legal content
- **Responsive Display**: Works with existing page templates

## 🎯 What Happens After Running

1. **Database**: 5 new records added to `pages` table
2. **Footer**: Links appear automatically in medical template footer
3. **Admin Panel**: Pages can be edited at `/admin/pages`
4. **URLs**: Accessible at `/page/privacy-policy`, etc.

## 📋 Page Specifications

Each page includes:
- ✅ Proper HTML content with healthcare context
- ✅ SEO meta tags optimized for medical services
- ✅ Footer display enabled
- ✅ Published status
- ✅ Sort order for proper footer arrangement
- ✅ Medical theme designation

## 🔧 Customization

After seeding, you can:
- Edit content in admin panel (`/admin/pages`)
- Modify SEO settings
- Change footer display preferences
- Add custom styling or sections

## ⚠️ Important Notes

- Seeder is safe to run multiple times (won't create duplicates)
- Only affects the Medical template (`theme = 'medical'`)
- Requires database connection and Page_model
- All content is in English (can be translated via admin)

## 🆘 Troubleshooting

If seeder fails:
1. Check database connection
2. Verify `pages` table exists
3. Ensure proper file permissions
4. Check PHP error logs

---

**Created for TNA CARE Healthcare Services**
*Medical Legal Content - Theme: Medical*</content>
<parameter name="filePath">C:\xampp\htdocs\institute\seeders\README.md