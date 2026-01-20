<?php
/**
 * College Template - Events Calendar Page (Interactive)
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// Get theme colors dynamically
$primary_color = get_theme_color('primary');
$secondary_color = get_theme_color('secondary');
$primary_dark = darken_color($primary_color, 15);
?>

<!-- ============================================
      INNER HERO SECTION
      ============================================ -->
<?php include VIEWPATH . 'templates/college/sections/inner_hero.php'; ?>

<!-- Calendar Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 ftco-animate">
                <!-- Month Navigation -->
                <div class="d-flex justify-content-between align-items-center mb-5 pb-4" style="border-bottom: 2px solid <?php echo $primary_color; ?>;">
                    <?php
                    $prev_month = $month - 1;
                    $prev_year = $year;
                    if ($prev_month < 1) {
                        $prev_month = 12;
                        $prev_year--;
                    }
                    
                    $next_month = $month + 1;
                    $next_year = $year;
                    if ($next_month > 12) {
                        $next_month = 1;
                        $next_year++;
                    }
                    ?>
                    <a href="<?php echo base_url('events/calendar?year=' . $prev_year . '&month=' . $prev_month); ?>" class="btn" style="background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%); color: white; border: none;">
                        <i class="fa fa-chevron-left me-2"></i>Previous Month
                    </a>
                    <h2 class="mb-0" style="color: #333; font-weight: 600;">
                        <i class="fa fa-calendar me-2" style="color: <?php echo $primary_color; ?>;"></i><?php echo date('F Y', strtotime($year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01')); ?>
                    </h2>
                    <a href="<?php echo base_url('events/calendar?year=' . $next_year . '&month=' . $next_month); ?>" class="btn" style="background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%); color: white; border: none;">
                        Next Month<i class="fa fa-chevron-right ms-2"></i>
                    </a>
                </div>

                <!-- Calendar Grid -->
                <div class="calendar-wrapper mb-5">
                    <div class="calendar-header">
                        <div class="calendar-day-header">Sun</div>
                        <div class="calendar-day-header">Mon</div>
                        <div class="calendar-day-header">Tue</div>
                        <div class="calendar-day-header">Wed</div>
                        <div class="calendar-day-header">Thu</div>
                        <div class="calendar-day-header">Fri</div>
                        <div class="calendar-day-header">Sat</div>
                    </div>
                    
                    <div class="calendar-body">
                        <?php
                        $first_day = date('w', strtotime($year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01'));
                        $days_in_month = date('t', strtotime($year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01'));
                        $today = date('Y-m-d');
                        $month_str = str_pad($month, 2, '0', STR_PAD_LEFT);
                        
                        // Group events by date
                        $events_by_date = [];
                        if (!empty($events)) {
                            foreach ($events as $event) {
                                $date = date('Y-m-d', strtotime($event->start_date));
                                if (!isset($events_by_date[$date])) {
                                    $events_by_date[$date] = [];
                                }
                                $events_by_date[$date][] = $event;
                            }
                        }
                        
                        // Empty cells before first day
                        for ($i = 0; $i < $first_day; $i++):
                        ?>
                            <div class="calendar-day empty"></div>
                        <?php endfor; ?>
                        
                        <?php for ($day = 1; $day <= $days_in_month; $day++):
                            $current_date = sprintf('%s-%s-%02d', $year, $month_str, $day);
                            $is_today = ($current_date === $today);
                            $has_events = isset($events_by_date[$current_date]);
                            $day_events = $has_events ? $events_by_date[$current_date] : [];
                        ?>
                            <div class="calendar-day <?php echo $is_today ? 'today' : ''; ?> <?php echo $has_events ? 'has-events' : ''; ?>" 
                                 <?php if ($has_events): ?>
                                 data-date="<?php echo $current_date; ?>"
                                 data-events='<?php echo json_encode(array_map(function($e) use ($event_colors, $primary_color) {
                                     $type = strtolower(str_replace(' ', '_', $e->event_type ?? 'default'));
                                     return [
                                         'title' => $e->title,
                                         'slug' => $e->slug,
                                         'type' => $e->event_type,
                                         'color' => isset($event_colors[$type]) ? $event_colors[$type] : $primary_color,
                                         'time' => !empty($e->start_time) ? date('g:i A', strtotime($e->start_time)) : '',
                                         'location' => $e->location ?? '',
                                         'banner' => $e->banner ?? '',
                                         'image' => $e->image ?? ''
                                     ];
                                 }, $day_events)); ?>'
                                 onclick="showDayEvents(this)"
                                 style="cursor: pointer;"
                                 <?php endif; ?>
                                 title="<?php echo $has_events ? count($day_events) . ' event(s) on ' . date('F d, Y', strtotime($current_date)) : ''; ?>">
                                <span class="day-number"><?php echo $day; ?></span>
                                <?php if ($has_events): ?>
                                    <div class="day-events">
                                        <?php foreach (array_slice($day_events, 0, 2) as $event): 
                                            $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                                            $color = isset($event_colors[$eventType]) ? $event_colors[$eventType] : $primary_color;
                                        ?>
                                            <span class="event-dot" style="background-color: <?php echo $color; ?>;">
                                                <?php echo strlen($event->title) > 15 ? substr($event->title, 0, 15) . '...' : $event->title; ?>
                                            </span>
                                        <?php endforeach; ?>
                                        <?php if (count($day_events) > 2): ?>
                                            <span class="more-events">+<?php echo count($day_events) - 2; ?> more</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                        
                        <?php
                        // Empty cells after last day
                        $total_cells = $first_day + $days_in_month;
                        $remaining = 7 - ($total_cells % 7);
                        if ($remaining < 7):
                            for ($i = 0; $i < $remaining; $i++):
                        ?>
                            <div class="calendar-day empty"></div>
                        <?php
                            endfor;
                        endif;
                        ?>
                    </div>
                </div>

                <!-- Events List for Current Month -->
                <?php if (!empty($events)): ?>
                    <div class="mt-5 pt-5" style="border-top: 1px solid #ddd;">
                        <h3 class="mb-4" style="color: #333; font-weight: 600;">
                            <i class="fa fa-list-ul me-2" style="color: <?php echo $primary_color; ?>;"></i>Events This Month
                        </h3>
                        <div class="row g-4">
                            <?php foreach ($events as $event): 
                                $eventType = strtolower(str_replace(' ', '_', $event->event_type ?? 'default'));
                                $color = isset($event_colors[$eventType]) ? $event_colors[$eventType] : $primary_color;
                            ?>
                                <div class="col-md-6 col-lg-4">
                                    <article class="blog-entry">
                                        <?php if (!empty($event->banner)): ?>
                                            <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="block-20" style="background-image: url('<?php echo base_url($event->banner); ?>');" title="<?php echo htmlspecialchars($event->title); ?>"></a>
                                        <?php elseif (!empty($event->image)): ?>
                                            <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="block-20" style="background-image: url('<?php echo base_url($event->image); ?>');" title="<?php echo htmlspecialchars($event->title); ?>"></a>
                                        <?php else: ?>
                                            <div class="block-20 d-flex align-items-center justify-content-center" style="background-color: #f8f9fa; border-left: 4px solid <?php echo $color; ?>;">
                                                <?php 
                                                if (!empty($site_logo)):
                                                ?>
                                                    <img src="<?php echo base_url($site_logo); ?>" alt="Logo" class="img-fluid" style="max-height: 80px; max-width: 90%; object-fit: contain;">
                                                <?php else: ?>
                                                    <i class="fa fa-calendar" style="font-size: 2rem; color: <?php echo $color; ?>;"></i>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="text p-3">
                                            <span class="badge mb-2" style="background-color: <?php echo $color; ?>; color: #fff;">
                                                <?php echo ucfirst($event->event_type); ?>
                                            </span>
                                            <h3 class="heading mt-2">
                                                <a href="<?php echo base_url('events/view/' . $event->slug); ?>">
                                                    <?php echo htmlspecialchars($event->title); ?>
                                                </a>
                                            </h3>
                                            <p class="meta">
                                                <span class="fa fa-calendar me-1" style="color: <?php echo $color; ?>;"></span> 
                                                <?php echo date('M d, Y', strtotime($event->start_date)); ?>
                                                <?php if (!empty($event->start_time)): ?>
                                                    at <?php echo date('g:i A', strtotime($event->start_time)); ?>
                                                <?php endif; ?>
                                            </p>
                                            <a href="<?php echo base_url('events/view/' . $event->slug); ?>" class="more-link mt-2">View Details <i class="fa fa-arrow-right ms-1"></i></a>
                                        </div>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Back Button -->
                <div class="mt-5 pt-4" style="border-top: 1px solid #ddd;">
                    <a href="<?php echo base_url('events'); ?>" class="btn" style="background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%); color: white; border: none;">
                        <i class="fa fa-chevron-left me-2"></i>Back to All Events
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Day Events Modal -->
<div class="modal fade" id="dayEventsModal" tabindex="-1" role="dialog" aria-labelledby="dayEventsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%); color: white;">
                <h5 class="modal-title" id="dayEventsModalLabel">
                    <i class="fa fa-calendar me-2"></i>Events on <span id="modalDate"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalEventsList">
                <!-- Events will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Partners Section -->
<?php include VIEWPATH . 'templates/college/sections/partners.php'; ?>

<!-- Final CTA -->
<?php include VIEWPATH . 'templates/college/sections/final_cta.php'; ?>

<script>
function showDayEvents(element) {
    const date = element.getAttribute('data-date');
    const events = JSON.parse(element.getAttribute('data-events'));
    
    // Format date
    const formattedDate = new Date(date.replace(/-/g, '/')).toLocaleDateString('en-US', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
    
    document.getElementById('modalDate').textContent = formattedDate;
    
    let eventsHtml = '';
    
    if (events.length === 0) {
        eventsHtml = '<div class="text-center text-muted py-4"><p>No events on this day.</p></div>';
    } else {
        eventsHtml = '<div class="row">';
        
        events.forEach(function(event) {
            const imageUrl = event.banner ? '<?php echo base_url(); ?>' + event.banner : 
                           (event.image ? '<?php echo base_url(); ?>' + event.image : '');
            
            eventsHtml += '<div class="col-md-6 mb-3">';
            eventsHtml += '<div class="card h-100">';
            
            if (imageUrl) {
                eventsHtml += '<div class="card-img-top" style="height: 120px; background-size: cover; background-position: center; background-image: url(\'' + imageUrl + '\');"></div>';
            }
            
            eventsHtml += '<div class="card-body">';
            eventsHtml += '<span class="badge mb-2" style="background-color: ' + event.color + ';">' + event.type + '</span>';
            eventsHtml += '<h6 class="card-title">' + event.title + '</h6>';
            
            if (event.time) {
                eventsHtml += '<p class="card-text small text-muted mb-1"><i class="fa fa-clock-o me-1"></i>' + event.time + '</p>';
            }
            
            if (event.location) {
                eventsHtml += '<p class="card-text small text-muted mb-2"><i class="fa fa-map-marker me-1"></i>' + event.location + '</p>';
            }
            
            eventsHtml += '<a href="<?php echo base_url('events/view/'); ?>' + event.slug + '" class="btn btn-sm mt-2" style="background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%); color: white; border: none;">View Details</a>';
            eventsHtml += '</div></div></div>';
        });
        
        eventsHtml += '</div>';
    }
    
    document.getElementById('modalEventsList').innerHTML = eventsHtml;
    
    $('#dayEventsModal').modal('show');
}
</script>

<style>
.calendar-wrapper {
    background: #fff;
    border-radius: 0.25rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.calendar-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%);
    color: white;
}

.calendar-day-header {
    padding: 1rem;
    text-align: center;
    font-weight: 600;
    font-size: 0.95rem;
}

.calendar-body {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
}

.calendar-day {
    min-height: 100px;
    padding: 0.5rem;
    border: 1px solid #eee;
    position: relative;
    background: #fff;
}

.calendar-day.empty {
    background: #f9f9fa;
}

.calendar-day.today {
    background: rgba(<?php echo hex_to_rgb($primary_color); ?>, 0.05);
}

.calendar-day.today .day-number {
    background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $primary_dark; ?> 100%);
    color: white;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.calendar-day.has-events {
    background: rgba(<?php echo hex_to_rgb($primary_color); ?>, 0.02);
}

.day-number {
    font-weight: 600;
    color: #333;
    display: inline-block;
}

.day-events {
    margin-top: 0.5rem;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.event-dot {
    display: block;
    padding: 3px 6px;
    background: <?php echo $primary_color; ?>;
    color: white;
    border-radius: 3px;
    font-size: 0.7rem;
    text-decoration: none;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: all 0.3s ease;
}

.event-dot:hover {
    background: <?php echo $primary_dark; ?>;
    color: white;
}

.more-events {
    font-size: 0.7rem;
    color: #666;
    font-style: italic;
}

.block-20 {
    height: 180px;
    background-size: cover;
    background-position: center;
    display: block;
    border-radius: 0.25rem;
}

.blog-entry .text {
    background-color: #f8f9fa;
}

.heading {
    font-weight: 600;
    color: #1a1a1a;
}

.heading a {
    color: #1a1a1a;
    text-decoration: none;
}

.heading a:hover {
    color: <?php echo $primary_color; ?>;
}

.meta {
    font-size: 0.9rem;
    color: #666;
}

.more-link {
    color: <?php echo $primary_color; ?>;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.more-link:hover {
    color: <?php echo $primary_dark; ?>;
}

.badge {
    display: inline-block;
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    font-size: 0.85rem;
    font-weight: 500;
}

@media (max-width: 768px) {
    .bread {
        font-size: 1.75rem;
    }

    .calendar-day {
        min-height: 60px;
        padding: 0.25rem;
    }
    
    .calendar-day-header {
        padding: 0.5rem;
        font-size: 0.8rem;
    }
    
    .day-events {
        display: none;
    }
    
    .calendar-day.has-events::after {
        content: '';
        position: absolute;
        bottom: 4px;
        left: 50%;
        transform: translateX(-50%);
        width: 6px;
        height: 6px;
        background: <?php echo $primary_color; ?>;
        border-radius: 50%;
    }
}
</style>
