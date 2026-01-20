# YouTube Videos Section - Architecture & Flow

## System Architecture

```
┌─────────────────────────────────────────────────────────────────────┐
│                        MEDICAL WEBSITE TEMPLATE                     │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  ┌──────────────────────────────────────────────────────────────┐  │
│  │                    FRONTEND (Website)                        │  │
│  ├──────────────────────────────────────────────────────────────┤  │
│  │                                                              │  │
│  │  Home Page (index.php)                                      │  │
│  │    ├─ Hero Section                                          │  │
│  │    ├─ Featured Expertises                                   │  │
│  │    ├─ Blog Posts                                            │  │
│  │    ├─ ⭐ YOUTUBE VIDEOS SECTION ⭐                           │  │
│  │    │   ├─ Grid Layout (Responsive)                         │  │
│  │    │   ├─ Video Cards (6 featured videos)                  │  │
│  │    │   ├─ Modal Player                                     │  │
│  │    │   └─ Category Display                                 │  │
│  │    └─ Call To Action                                       │  │
│  │                                                              │  │
│  │  Data Flow: youtube_videos.php → youtube_videos_model      │  │
│  │                                                              │  │
│  └──────────────────────────────────────────────────────────────┘  │
│                                                                     │
│  ┌──────────────────────────────────────────────────────────────┐  │
│  │                    ADMIN PANEL                               │  │
│  ├──────────────────────────────────────────────────────────────┤  │
│  │                                                              │  │
│  │  /admin-youtube (Dashboard)                                │  │
│  │    ├─ Video List (with drag-drop reorder)                 │  │
│  │    ├─ Stats Cards (Total, Active, Featured, Inactive)     │  │
│  │    ├─ Active/Featured Toggles                             │  │
│  │    └─ Action Buttons (Edit, Delete)                       │  │
│  │                                                              │  │
│  │  /admin-youtube/create (Add Video)                         │  │
│  │    ├─ Title Input                                          │  │
│  │    ├─ YouTube URL Input                                    │  │
│  │    ├─ Category Input                                       │  │
│  │    ├─ Description Text Area                                │  │
│  │    ├─ Status Toggles                                       │  │
│  │    └─ Thumbnail Preview                                    │  │
│  │                                                              │  │
│  │  /admin-youtube/edit/{uid} (Edit Video)                    │  │
│  │    └─ Same as Create + Update                              │  │
│  │                                                              │  │
│  │  Data Flow: Admin Views → Admin_youtube Controller         │  │
│  │           → Youtube_videos_model → Database                │  │
│  │                                                              │  │
│  └──────────────────────────────────────────────────────────────┘  │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
                              ▼
                    ┌──────────────────┐
                    │   MySQL/MariaDB  │
                    ├──────────────────┤
                    │ youtube_videos   │
                    │   - id (PK)      │
                    │   - uid          │
                    │   - title        │
                    │   - youtube_url  │
                    │   - video_id     │
                    │   - thumbnail    │
                    │   - category     │
                    │   - is_active    │
                    │   - is_featured  │
                    │   - order        │
                    │   - timestamps   │
                    └──────────────────┘
```

---

## Request Flow Diagram

### Frontend Display Flow
```
User visits home page (localhost/institute)
           ▼
Home Controller loads
           ▼
load_medical_content() executes
           ▼
Youtube_videos_model->get_featured(6) queries
           ▼
Fetches 6 videos where is_active=1 AND is_featured=1
           ▼
Data passed to home.php view
           ▼
youtube_videos.php component included
           ▼
Videos rendered as responsive grid
           ▼
User sees featured videos on homepage
           ▼
User clicks play button
           ▼
Modal opens with embedded YouTube player
           ▼
Video plays with autoplay enabled
```

### Admin Management Flow
```
Admin visits /admin-youtube
           ▼
Admin_youtube::index() executes
           ▼
Fetches all videos (with pagination)
           ▼
dashboard.php view renders
           ▼
Admin sees video list with stats
           ▼
Admin clicks "Add Video"
           ▼
create.php form displays
           ▼
Admin fills in form & submits
           ▼
Admin_youtube::create() validates input
           ▼
extract_video_id() extracts ID from URL
           ▼
Youtube_videos_model->create() saves to DB
           ▼
Redirect back to dashboard
           ▼
Success message displays
           ▼
New video now visible in list
           ▼
Drag to reorder updates display_order
           ▼
Toggle active/featured updates via AJAX
```

---

## File Relationships

```
Controllers:
├─ Home.php (MODIFIED)
│  └─ Loads Youtube_videos_model
│     └─ Calls get_featured()
│
└─ Admin_youtube.php (NEW)
   ├─ index() → dashboard.php
   ├─ create() → create.php
   ├─ edit() → edit.php
   ├─ delete() → redirect
   ├─ toggle_active() → AJAX
   ├─ toggle_featured() → AJAX
   └─ update_order() → AJAX

Models:
├─ Youtube_videos_model.php (NEW)
│  ├─ get_featured() - 6 videos for homepage
│  ├─ get_all() - all active videos
│  ├─ get_by_category() - filter by category
│  ├─ get_categories() - all unique categories
│  ├─ create() - add new video
│  ├─ update() - modify video
│  ├─ delete() - remove video
│  ├─ toggle_active() - AJAX status
│  ├─ toggle_featured() - AJAX featured
│  ├─ update_order() - AJAX reorder
│  ├─ extract_video_id() - parse URL
│  ├─ get_embed_url() - generate embed URL
│  └─ search() - search videos

Views - Frontend:
├─ templates/medical/pages/home.php (MODIFIED)
│  └─ Includes youtube_videos.php section
│
└─ templates/medical/sections/youtube_videos.php (NEW)
   ├─ Video grid display
   ├─ Modal player
   ├─ JavaScript interactions
   └─ Responsive CSS

Views - Admin:
├─ admin/youtube/dashboard.php (NEW)
│  ├─ List all videos
│  ├─ Stats cards
│  └─ AJAX toggles
│
├─ admin/youtube/create.php (NEW)
│  ├─ Form inputs
│  ├─ Thumbnail preview
│  └─ Form validation
│
└─ admin/youtube/edit.php (NEW)
   ├─ Editable form
   ├─ Thumbnail preview
   └─ Update functionality

Database:
└─ youtube_videos table (NEW)
   ├─ id, uid, title, description
   ├─ youtube_url, youtube_video_id, thumbnail_url
   ├─ category, is_active, is_featured
   ├─ display_order, created_at, updated_at
   └─ Indexes on is_active, is_featured, display_order
```

---

## Data Transformation Pipeline

```
Step 1: User Input (Admin Form)
┌────────────────────────────────┐
│ Video Title: "Health Update"   │
│ URL: https://youtube.com/...   │
│ Category: "Health Tips"        │
│ Description: "Learn health..." │
│ Active: ✓                      │
│ Featured: ✓                    │
└────────────────────────────────┘
           ▼
Step 2: Controller Validation & Processing
┌────────────────────────────────┐
│ Form validation checks         │
│ URL format verified            │
│ Extract video ID: dQw4w9WgXcQ  │
│ Generate thumbnail URL         │
│ Create UUID for uid            │
│ Set timestamps                 │
└────────────────────────────────┘
           ▼
Step 3: Database Storage
┌────────────────────────────────┐
│ INSERT into youtube_videos     │
│ {                              │
│   id: 1,                       │
│   uid: "550e8400...",          │
│   title: "Health Update",      │
│   youtube_url: "https://...",  │
│   youtube_video_id: "dQw4w...",│
│   thumbnail_url: "https://...",│
│   category: "Health Tips",     │
│   is_active: 1,                │
│   is_featured: 1,              │
│   display_order: 1,            │
│   created_at: NOW(),           │
│   updated_at: NOW()            │
│ }                              │
└────────────────────────────────┘
           ▼
Step 4: Frontend Retrieval
┌────────────────────────────────┐
│ SELECT * FROM youtube_videos   │
│ WHERE is_active = 1            │
│ AND is_featured = 1            │
│ ORDER BY display_order ASC     │
│ LIMIT 6                        │
└────────────────────────────────┘
           ▼
Step 5: View Rendering
┌────────────────────────────────┐
│ Generate HTML grid             │
│ - Video card (responsive)      │
│ - Thumbnail image              │
│ - Play button overlay          │
│ - Title and category badge     │
│ - Description excerpt          │
└────────────────────────────────┘
           ▼
Step 6: User Interaction
┌────────────────────────────────┐
│ User clicks play button        │
│ Modal opens                    │
│ YouTube iframe loads           │
│ Video autoplays                │
│ User can close modal           │
└────────────────────────────────┘
```

---

## State Management

### Video States
```
┌─────────────────────────────────────────┐
│         Video Lifecycle States          │
├─────────────────────────────────────────┤
│                                         │
│  Created (is_active=0, is_featured=0)  │
│    ├─ Inactive draft state             │
│    └─ Not visible anywhere             │
│         ▼                               │
│                                         │
│  Active (is_active=1, is_featured=0)   │
│    ├─ Visible on site                  │
│    ├─ Not on homepage                  │
│    └─ In video list pages              │
│         ▼                               │
│                                         │
│  Featured (is_active=1, is_featured=1) │
│    ├─ Visible on site                  │
│    ├─ Shows on homepage                │
│    └─ Priority display                 │
│         ▼                               │
│                                         │
│  Archived (is_active=0, any)           │
│    ├─ Soft delete                      │
│    ├─ Still in database                │
│    └─ Invisible everywhere             │
│         ▼                               │
│                                         │
│  Deleted (removed from DB)             │
│    └─ Permanently gone                 │
│                                         │
└─────────────────────────────────────────┘
```

### Admin State Transitions
```
Dashboard Page
   ├─ View all videos
   ├─ Click "Add Video" → Create Page
   │   └─ Submit → Save to DB → Dashboard
   ├─ Click Edit → Edit Page
   │   └─ Submit → Update DB → Dashboard
   ├─ Click Delete → Confirm → Delete → Dashboard
   ├─ Toggle Active → AJAX → Update → Refresh
   ├─ Toggle Featured → AJAX → Update → Refresh
   └─ Drag to Reorder → AJAX → Update order → Refresh
```

---

## Performance & Optimization

### Database Queries
```
Homepage Load:
  SELECT * FROM youtube_videos
  WHERE is_active = 1
  AND is_featured = 1
  ORDER BY display_order ASC
  LIMIT 6
  ↓
  Result: ~1-5ms on typical server
  
Admin Dashboard:
  SELECT * FROM youtube_videos
  ORDER BY display_order, created_at DESC
  LIMIT 20 OFFSET 0
  ↓
  Result: ~1-5ms with pagination
  
Category List:
  SELECT DISTINCT category, COUNT(*)
  WHERE is_active = 1
  GROUP BY category
  ↓
  Result: ~1ms (indexed)
```

### Caching Strategy
```
Frontend:
├─ Browser cache: Thumbnails from YouTube CDN
├─ Server cache: Query results (configurable)
└─ Video embeds: Loaded on-demand in modal

Admin:
├─ No caching (always fresh data)
└─ Real-time updates via AJAX
```

---

## Security Considerations

```
Input Validation:
├─ Title: required, max 255 chars
├─ URL: valid_url, must be HTTPS
├─ Description: max 2000 chars
├─ Category: max 100 chars
└─ Boolean flags: cast to int

XSS Protection:
├─ All output escaped with htmlspecialchars()
├─ Form inputs sanitized with input->post(TRUE)
└─ Database queries use prepared statements

CSRF Protection:
├─ Form tokens on all POST forms
├─ AJAX requests include token headers
└─ Token refreshed per session

SQL Injection:
├─ CodeIgniter query builder used
├─ No raw SQL in model methods
└─ All inputs parameterized

Access Control:
├─ Admin pages check session login
├─ Redirect to login if not authenticated
└─ No public edit/delete endpoints
```

---

## Database Indexes Strategy

```
youtube_videos table indexes:
├─ PRIMARY KEY (id) - Auto-indexed
├─ UNIQUE KEY (uid) - For lookups
├─ INDEX (is_active) - For WHERE clauses
├─ INDEX (is_featured) - For homepage query
├─ INDEX (display_order) - For sorting
└─ INDEX (category) - For filtering

Query Optimization:
├─ get_featured() → uses is_active + is_featured + display_order
├─ get_by_category() → uses is_active + category
├─ search() → no index (acceptable for low volume)
└─ Overall: ~5-10ms queries on typical database
```

---

## Responsive Design Breakpoints

```
Desktop (≥1200px):
└─ 3-column grid
└─ Full modal size

Tablet (768px - 1199px):
└─ 2-column grid
└─ Modal at 95% width

Mobile (<768px):
└─ 1-column grid
└─ Modal at 95% width
└─ Touch-optimized buttons
```

---

## Integration Points

### With Existing System
```
Home Page:
  ├─ Already loads settings
  ├─ Already loads models
  ├─ Already passes data to views
  └─ YouTube videos fit seamlessly

Navigation:
  ├─ No changes needed
  ├─ Videos accessible via home
  └─ Could add menu item if desired

Settings:
  ├─ Uses standard video count config
  ├─ Can be overridden per template
  └─ No new settings table needed
```

### Possible Extensions
```
Future Features:
├─ Video playlists
├─ Video ratings/comments
├─ Analytics tracking
├─ Social sharing buttons
├─ Video transcripts/captions
├─ Related videos suggestions
├─ Video search functionality
└─ Category filter page
```

---

## Version Compatibility

```
CodeIgniter: 3.x (uses CI conventions)
PHP: 7.2+ (supports modern syntax)
MySQL: 5.7+ (standard SQL features)
Browsers: All modern (ES6 support)

Browser Compatibility:
├─ Chrome/Edge: Full support
├─ Firefox: Full support
├─ Safari: Full support
├─ Mobile browsers: Full support
└─ IE 11: No support (ES6 requirement)
```

---

## Deployment Checklist

```
Before Production:
✓ Database migration executed
✓ Files uploaded to server
✓ File permissions set correctly (644 for files, 755 for dirs)
✓ Database backups in place
✓ Test admin functionality
✓ Test frontend display
✓ Verify YouTube videos are public
✓ Clear browser cache
✓ Test on multiple devices
✓ Test modal functionality
✓ Verify responsive design
✓ Check for console errors
```

---

**Created:** January 20, 2026  
**Status:** Complete  
**Last Updated:** January 20, 2026

