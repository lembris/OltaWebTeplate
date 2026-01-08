<div class="container-fluid page-wrapper">
    <div class="page-header mb-4">
        <h1><?php echo htmlspecialchars($event->title); ?></h1>
        <span class="badge badge-lg badge-primary"><?php echo ucfirst($event->event_type); ?></span>
    </div>

    <div class="row">
        <div class="col-md-8">
            <?php if (!empty($event->banner)): ?>
                <img src="<?php echo base_url($event->banner); ?>" class="img-fluid rounded mb-4" alt="<?php echo htmlspecialchars($event->title); ?>">
            <?php elseif (!empty($event->image)): ?>
                <img src="<?php echo base_url($event->image); ?>" class="img-fluid rounded mb-4" alt="<?php echo htmlspecialchars($event->title); ?>">
            <?php else: ?>
                <div class="bg-light rounded mb-4 d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="fas fa-image text-secondary" style="font-size: 3rem;"></i>
                </div>
            <?php endif; ?>

            <div class="event-description mb-4">
                <h3>Event Details</h3>
                <?php echo nl2br(htmlspecialchars($event->description)); ?>
            </div>

            <?php if (!empty($event->registrations_count) && $event->registration_required): ?>
                <div class="alert alert-info">
                    <strong><?php echo $event->registrations_count; ?></strong> people have registered for this event.
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Event Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Date:</dt>
                        <dd class="col-sm-7"><?php echo date('M d, Y', strtotime($event->start_date)); ?></dd>

                        <?php if (!empty($event->start_time)): ?>
                            <dt class="col-sm-5">Start Time:</dt>
                            <dd class="col-sm-7"><?php echo date('g:i A', strtotime($event->start_time)); ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($event->end_date)): ?>
                            <dt class="col-sm-5">End Date:</dt>
                            <dd class="col-sm-7"><?php echo date('M d, Y', strtotime($event->end_date)); ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($event->location)): ?>
                            <dt class="col-sm-5">Location:</dt>
                            <dd class="col-sm-7"><?php echo htmlspecialchars($event->location); ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($event->organizer)): ?>
                            <dt class="col-sm-5">Organizer:</dt>
                            <dd class="col-sm-7"><?php echo htmlspecialchars($event->organizer); ?></dd>
                        <?php endif; ?>

                        <?php if (!empty($event->capacity)): ?>
                            <dt class="col-sm-5">Capacity:</dt>
                            <dd class="col-sm-7"><?php echo $event->capacity; ?> people</dd>
                        <?php endif; ?>
                    </dl>
                </div>
            </div>

            <?php if (!empty($event->contact_email) || !empty($event->contact_phone)): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Contact</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($event->contact_person)): ?>
                            <p><strong><?php echo htmlspecialchars($event->contact_person); ?></strong></p>
                        <?php endif; ?>
                        <?php if (!empty($event->contact_email)): ?>
                            <p><a href="mailto:<?php echo htmlspecialchars($event->contact_email); ?>"><?php echo htmlspecialchars($event->contact_email); ?></a></p>
                        <?php endif; ?>
                        <?php if (!empty($event->contact_phone)): ?>
                            <p><a href="tel:<?php echo htmlspecialchars($event->contact_phone); ?>"><?php echo htmlspecialchars($event->contact_phone); ?></a></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($event->registration_required): ?>
                <a href="<?php echo base_url('events/register/' . $event->id); ?>" class="btn btn-primary btn-block btn-lg">
                    <i class="fas fa-clipboard-list"></i> Register for Event
                </a>
            <?php endif; ?>

            <?php if (!empty($event->registration_link)): ?>
                <a href="<?php echo htmlspecialchars($event->registration_link); ?>" class="btn btn-info btn-block mt-2" target="_blank">
                    <i class="fas fa-external-link-alt"></i> External Registration
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-4">
        <a href="<?php echo base_url('events'); ?>" class="btn btn-outline-secondary">Back to Events</a>
    </div>
    </div>
