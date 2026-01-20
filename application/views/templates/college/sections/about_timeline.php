<!-- ============================================
     TIMELINE SECTION - REUSABLE
     ============================================ -->
<?php if (!empty($timeline_items)): ?>
<section class="ftco-section" style="background-color: #faf8f6;">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Our Journey</span>
                <h2 class="mb-4" style="color: #333;">History & Milestones</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="timeline">
                    <?php foreach ($timeline_items as $index => $item): ?>
                    <div class="timeline-item<?php echo $index % 2 == 0 ? ' left' : ' right'; ?> ftco-animate">
                        <div class="timeline-content" style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); padding: 20px; position: relative;">
                            <div class="timeline-icon" style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); width: 40px; height: 40px; background: var(--primary-color, #C7805C); border-radius: 50%; display: flex; align-items: center; justify-content: center; z-index: 1;">
                                <span class="fa <?php echo htmlspecialchars($item->icon ?? 'fa-calendar'); ?>" style="color: white;"></span>
                            </div>
                            <span class="year" style="display: inline-block; background: var(--primary-color, #C7805C); color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; margin-bottom: 10px; margin-top: 10px;"><?php echo htmlspecialchars($item->year); ?></span>
                            <h3 style="color: #333; margin-bottom: 10px; font-size: 1.2rem;"><?php echo htmlspecialchars($item->title); ?></h3>
                            <p style="color: #666; line-height: 1.7; margin-bottom: 0;"><?php echo htmlspecialchars($item->description); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}
.timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 3px;
    height: 100%;
    background: var(--primary-color, #C7805C);
}
.timeline-item {
    padding: 10px 40px;
    position: relative;
    width: 50%;
    box-sizing: border-box;
}
.timeline-item.left {
    left: 0;
    text-align: right;
}
.timeline-item.right {
    left: 50%;
    text-align: left;
}
.timeline-item.left .timeline-icon {
    right: -50px;
    left: auto;
}
.timeline-item.right .timeline-icon {
    left: -50px;
}
@media (max-width: 768px) {
    .timeline::before {
        left: 20px;
    }
    .timeline-item {
        width: 100%;
        padding-left: 60px;
        padding-right: 15px;
    }
    .timeline-item.left,
    .timeline-item.right {
        left: 0;
        text-align: left;
    }
    .timeline-item.left .timeline-icon,
    .timeline-item.right .timeline-icon {
        left: -20px;
        right: auto;
    }
}
</style>
<?php endif; ?>
