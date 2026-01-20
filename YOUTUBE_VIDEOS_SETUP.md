# YouTube Videos Section Setup Guide

## Overview
This guide explains how to set up and use the dynamic YouTube Videos section for your medical template. The section allows you to manage YouTube videos via the admin panel and display them on your website.

---

## Installation Steps

### 1. Run Database Migration
Execute the SQL migration to create the `youtube_videos` table:

```bash
# Option A: Using the SQL file directly
mysql -u root -p your_database_name < sql/migration_012_create_youtube_videos.sql

# Option B: Manually copy/paste in phpMyAdmin
# Open sql/migration_012_create_youtube_videos.sql and execute
```

The table structure includes:
- `id` - Primary key
- `uid` - Unique identifier
- `title` - Video title (required)
- `description` - Video description
- `youtube_url` - Full YouTube URL (required)
- `youtube_video_id` - Extracted video ID (auto-generated)
- `thumbnail_url` - YouTube thumbnail (auto-generated)
- `category` - Video category/tag
- `is_active` - Show/hide on website
- `is_featured` - Show on homepage
- `display_order` - Sort order
- `created_at` / `updated_at` - Timestamps

### 2. Files Created

The following files have been created:

**Database:**
- `sql/migration_012_create_youtube_videos.sql` - Database migration

**Models:**
- `application/models/Youtube_videos_model.php` - Data handling model

**Controllers:**
- `application/controllers/Admin_youtube.php` - Admin management controller

**Admin Views:**
- `application/views/admin/youtube/dashboard.php` - Video list
- `application/views/admin/youtube/create.php` - Add new video form
- `application/views/admin/youtube/edit.php` - Edit video form

**Frontend Views:**
- `application/views/templates/medical/sections/youtube_videos.php` - Reusable video section component

**Updated Files:**
- `application/controllers/Home.php` - Added YouTube videos loading
- `application/views/templates/medical/pages/home.php` - Added YouTube videos section

---

## How to Use

### Admin Panel - Adding Videos

1. **Navigate to Admin Panel**
   - Go to: `http://localhost/institute/admin-youtube`
   - Login with your admin credentials

2. **Click "Add Video" button**

3. **Fill in the form:**
   - **Video Title** (Required): Give your video a descriptive title
   - **YouTube URL** (Required): Paste the full YouTube URL
     - Supports both formats:
       - `https://www.youtube.com/watch?v=dQw4w9WgXcQ`
       - `https://youtu.be/dQw4w9WgXcQ`
   - **Category**: Group videos by category (e.g., "Health Tips", "Educational", "Wellness")
   - **Description**: Add a brief description of the video
   - **Active**: Check to make video visible on website
   - **Featured**: Check to display on homepage

4. **Preview**
   - The thumbnail will automatically display as you enter the YouTube URL
   - The video ID is automatically extracted

5. **Submit**
   - Click "Add Video" to save

### Admin Panel - Managing Videos

**Edit Video:**
- Click the edit button (pencil icon) next to any video
- Modify any field and click "Update Video"

**Delete Video:**
- Click the delete button (trash icon)
- Confirm deletion

**Toggle Status:**
- Use the switch in the "Status" column to activate/deactivate videos
- Use the star icon to mark as featured

**Reorder Videos:**
- Drag videos by the grip handle to change display order
- Changes save automatically

---

## Frontend Display

### Homepage Integration
The YouTube videos section is automatically displayed on your homepage:
- Location: Between "Latest Blog Posts" and "Call To Action" sections
- Shows: 6 featured videos by default
- Display: Responsive grid layout (3 columns on desktop, 1 on mobile)

### User Interaction
- **Click Play Button**: Opens video in modal overlay
- **Autoplay**: Video plays automatically when modal opens
- **Close Modal**: 
  - Click the X button
  - Click outside the video
  - Press Escape key

---

## Customization

### Change Number of Videos Displayed

**On Homepage:**
Edit `application/controllers/Home.php`, line ~280:

```php
// Change from:
$data['youtube_videos'] = $this->Youtube_videos_model->get_featured(6);

// To (example: show 9 videos):
$data['youtube_videos'] = $this->Youtube_videos_model->get_featured(9);
```

### Display Videos on Other Pages

To include the YouTube videos section anywhere on your site, use:

```php
<?php 
// In your controller:
$this->load->model('Youtube_videos_model');
$data['youtube_videos'] = $this->Youtube_videos_model->get_featured(6);

// In your view:
<?php echo $this->load->view('templates/medical/sections/youtube_videos', $data, TRUE); ?>
?>
```

### Styling the Section

All CSS for the YouTube videos section is contained within:
`application/views/templates/medical/sections/youtube_videos.php`

Key CSS classes:
- `.youtube-videos-section` - Main container
- `.video-grid` - Video grid layout
- `.video-card` - Individual video card
- `.video-thumbnail-wrapper` - Thumbnail container
- `.video-modal` - Modal overlay

You can override these in your theme's custom CSS.

---

## Database Functions (For Developers)

### Model Methods

```php
// Get featured videos (for homepage)
$videos = $this->Youtube_videos_model->get_featured(6);

// Get all active videos
$videos = $this->Youtube_videos_model->get_all(50, 0);

// Get videos by category
$videos = $this->Youtube_videos_model->get_by_category('Health Tips', 20);

// Get all categories
$categories = $this->Youtube_videos_model->get_categories();

// Get single video
$video = $this->Youtube_videos_model->get_by_uid($uid);

// Search videos
$results = $this->Youtube_videos_model->search('keyword');

// Extract video ID from URL
$video_id = $this->Youtube_videos_model->extract_video_id('https://youtube.com/watch?v=...');

// Get embed URL
$embed_url = $this->Youtube_videos_model->get_embed_url($video);
```

---

## Troubleshooting

### Videos Not Appearing

1. **Check database table exists:**
   - Go to phpMyAdmin
   - Verify `youtube_videos` table exists

2. **Verify videos are marked as active:**
   - In admin panel, check the toggle switch is ON
   - Or check `is_active = 1` in database

3. **Check featured videos:**
   - Ensure at least one video has `is_featured = 1`

4. **Clear browser cache:**
   - Hard refresh (Ctrl+F5 or Cmd+Shift+R)

### YouTube URL Not Working

1. **Use full URLs:**
   - ✓ Correct: `https://www.youtube.com/watch?v=dQw4w9WgXcQ`
   - ✗ Wrong: Just the video ID
   - ✓ Correct: `https://youtu.be/dQw4w9WgXcQ`

2. **Video privacy settings:**
   - Ensure video is set to "Public" or "Unlisted" on YouTube
   - "Private" videos won't show

3. **Extract video ID manually:**
   - If auto-extraction fails, the video ID should be:
   - Example: `dQw4w9WgXcQ` (11 characters)
   - This is extracted and stored in `youtube_video_id` field

### Thumbnail Not Displaying

- Thumbnails are auto-generated from YouTube
- If not showing:
  1. Verify the `youtube_video_id` is correct (11 characters)
  2. Check YouTube video exists and is public
  3. Thumbnail URL format: `https://img.youtube.com/vi/{VIDEO_ID}/hqdefault.jpg`

---

## API Reference

### REST Endpoints (Admin)

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/admin-youtube` | GET | List all videos |
| `/admin-youtube/create` | GET/POST | Create new video |
| `/admin-youtube/edit/{uid}` | GET/POST | Edit video |
| `/admin-youtube/delete/{uid}` | GET | Delete video |
| `/admin-youtube/toggle_active/{uid}` | GET | Toggle active status |
| `/admin-youtube/toggle_featured/{uid}` | GET | Toggle featured status |
| `/admin-youtube/update_order` | POST | Update display order |

---

## Features

✓ **Easy to Use:** Simple admin interface for managing videos
✓ **Auto-Extract:** Automatically extracts YouTube video ID and thumbnail
✓ **Responsive:** Works perfectly on all devices
✓ **Modal Player:** Watch videos in overlay without leaving the page
✓ **Categories:** Organize videos by category
✓ **Reorderable:** Drag and drop to change display order
✓ **Status Control:** Toggle active/featured status
✓ **Validation:** Validates YouTube URLs
✓ **SEO Friendly:** Proper meta data and structure

---

## Support & Maintenance

### Regular Tasks

1. **Review and update videos regularly:**
   - Remove old or irrelevant videos
   - Update descriptions and categories

2. **Monitor video performance:**
   - Track which videos get viewed most
   - Update featured videos accordingly

3. **Maintain thumbnails:**
   - Ensure videos are still public on YouTube
   - If videos are deleted, remove from your site

### Best Practices

- Use clear, descriptive titles
- Add helpful descriptions
- Organize with consistent categories
- Feature your best/most recent content
- Keep descriptions under 200 characters
- Test videos in different browsers

---

## Version Information

- **Created:** January 2026
- **Compatible with:** CodeIgniter 3.x
- **Database:** MySQL/MariaDB
- **Browser Support:** All modern browsers

---

## Quick Reference

| Task | Location |
|------|----------|
| View/Manage Videos | `/admin-youtube` |
| Add New Video | `/admin-youtube/create` |
| Edit Video | `/admin-youtube/edit/{uid}` |
| View on Website | Check featured videos on home page |
| Database | `youtube_videos` table |
| Model | `Youtube_videos_model.php` |
| Frontend View | `youtube_videos.php` (in sections) |

---

## Notes

- The section is designed specifically for the medical template but can be adapted for other templates
- Video URLs are stored for flexibility (change YouTube account if needed)
- All timestamps are automatically managed
- UIDs are UUID v4 format for uniqueness
- Supports unlimited categories

