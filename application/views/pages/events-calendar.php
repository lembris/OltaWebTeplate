<div class="container py-5">
    <div class="mb-5">
        <h1 class="page-title">Events Calendar</h1>
        <p class="page-subtitle text-muted"><?php echo date('F Y', strtotime($year . '-' . $month . '-01')); ?></p>
    </div>

    <!-- Month Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
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
        <a href="<?php echo base_url('events/calendar?year=' . $prev_year . '&month=' . $prev_month); ?>" class="btn btn-outline-primary">
            <i class="fas fa-chevron-left me-2"></i>Previous Month
        </a>
        <h3 class="mb-0"><?php echo date('F Y', strtotime($year . '-' . $month . '-01')); ?></h3>
        <a href="<?php echo base_url('events/calendar?year=' . $next_year . '&month=' . $next_month); ?>" class="btn btn-outline-primary">
            Next Month<i class="fas fa-chevron-right ms-2"></i>
        </a>
    </div>

    <!-- Calendar Grid -->
    <div class="calendar-wrapper">
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
            $first_day = date('w', strtotime($year . '-' . $month . '-01'));
            $days_in_month = date('t', strtotime($year . '-' . $month . '-01'));
            $today = date('Y-m-d');
            
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
                $current_date = sprintf('%s-%02d-%02d', $year, $month, $day);
                $is_today = ($current_date === $today);
                $has_events = isset($events_by_date[$current_date]);
            ?>
                <div class="calendar-day <?php echo $is_today ? 'today' : ''; ?> <?php echo $has_events ? 'has-events' : ''; ?>">
                    <span class="day-number"><?php echo $day; ?></span>
                    <?php if ($has_events): ?>
                        <div class="day-events">
                            <?php foreach (array_slice($events_by_date[$current_date], 0, 2) as $event): ?>
                                <a href="<?php echo base_url('events/view/' . $event->id); ?>" class="event-dot" title="<?php echo htmlspecialchars($event->title); ?>">
                                    <?php echo strlen($event->title) > 15 ? substr($event->title, 0, 15) . '...' : $event->title; ?>
                                </a>
                            <?php endforeach; ?>
                            <?php if (count($events_by_date[$current_date]) > 2): ?>
                                <span class="more-events">+<?php echo count($events_by_date[$current_date]) - 2; ?> more</span>
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
        <div class="mt-5">
            <h3 class="mb-4">Events This Month</h3>
            <div class="row g-4">
                <?php foreach ($events as $event): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2"><?php echo ucfirst($event->event_type); ?></span>
                                <h5 class="card-title"><?php echo htmlspecialchars($event->title); ?></h5>
                                <p class="card-text text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    <?php echo date('M d, Y', strtotime($event->start_date)); ?>
                                    <?php if (!empty($event->start_time)): ?>
                                        at <?php echo date('g:i A', strtotime($event->start_time)); ?>
                                    <?php endif; ?>
                                </p>
                                <a href="<?php echo base_url('events/view/' . $event->id); ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="<?php echo base_url('events'); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Events
        </a>
    </div>
</div>

<style>
.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    color: #666;
}

.calendar-wrapper {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.calendar-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background: var(--primary-color, #0d6efd);
    color: white;
}

.calendar-day-header {
    padding: 1rem;
    text-align: center;
    font-weight: 600;
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
}

.calendar-day.empty {
    background: #f9f9f9;
}

.calendar-day.today {
    background: rgba(13, 110, 253, 0.1);
}

.calendar-day.today .day-number {
    background: var(--primary-color, #0d6efd);
    color: white;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.calendar-day.has-events {
    background: rgba(25, 135, 84, 0.05);
}

.day-number {
    font-weight: 600;
    color: #333;
}

.day-events {
    margin-top: 0.5rem;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.event-dot {
    display: block;
    padding: 2px 6px;
    background: var(--primary-color, #0d6efd);
    color: white;
    border-radius: 3px;
    font-size: 0.7rem;
    text-decoration: none;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.event-dot:hover {
    opacity: 0.8;
    color: white;
}

.more-events {
    font-size: 0.7rem;
    color: #666;
    font-style: italic;
}

@media (max-width: 768px) {
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
        background: var(--primary-color, #0d6efd);
        border-radius: 50%;
    }
}
</style>
