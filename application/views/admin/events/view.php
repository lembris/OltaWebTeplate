<!-- Event Details View -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $page_title ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/events') ?>">Events</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($event->title) ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/events/edit/' . $event->uid) ?>" class="btn btn-warning me-2">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="<?= base_url('admin/events') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Event Header -->
        <div class="card mb-3">
            <div class="card-body">
                <h2><?= htmlspecialchars($event->title) ?></h2>
                <p class="text-muted mb-0">
                    <i class="fas fa-calendar me-2"></i><?= date('M d, Y H:i', strtotime($event->start_date)) ?> to 
                    <?= date('M d, Y H:i', strtotime($event->end_date)) ?>
                </p>
            </div>
        </div>

        <!-- Banner Image -->
        <?php if (!empty($event->banner)): ?>
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-image me-2"></i>Banner Image
            </div>
            <div class="card-body">
                <img src="<?= base_url($event->banner) ?>" alt="<?= htmlspecialchars($event->title) ?>" class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
            </div>
        </div>
        <?php endif; ?>

        <!-- Event Image -->
        <?php if (!empty($event->image)): ?>
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-image me-2"></i>Event Image
            </div>
            <div class="card-body">
                <img src="<?= base_url($event->image) ?>" alt="<?= htmlspecialchars($event->title) ?>" class="img-fluid rounded" style="max-height: 300px; width: 100%; object-fit: cover;">
            </div>
        </div>
        <?php endif; ?>

        <!-- Event Details -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i>Event Information
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Location:</strong>
                        <p><?= htmlspecialchars($event->location) ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Event Type:</strong>
                        <p><span class="badge bg-info"><?= ucfirst($event->event_type) ?></span></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p>
                            <?php if ($event->status === 'upcoming'): ?>
                                <span class="badge bg-success">Upcoming</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Cancelled</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Visibility:</strong>
                        <p>
                            <?php if ($event->visibility === 'public'): ?>
                                <span class="badge bg-primary">Public</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Private</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong>Featured:</strong>
                        <p><?= $event->is_featured ? '<span class="badge bg-warning">Yes</span>' : 'No' ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Registration Required:</strong>
                        <p><?= $event->registration_required ? '<span class="badge bg-success">Yes</span>' : 'No' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-align-left me-2"></i>Description
            </div>
            <div class="card-body">
                <?php if ($event->description): ?>
                    <?= $event->description ?>
                <?php else: ?>
                    <p class="text-muted">No description provided.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Registrations -->
        <?php if ($event->registration_required): ?>
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>Event Registrations
                <span class="badge bg-primary float-end"><?= count($registrations) ?></span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Affiliation</th>
                            <th>Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($registrations)): ?>
                            <?php foreach ($registrations as $reg): ?>
                            <tr>
                                <td><?= htmlspecialchars($reg->first_name . ' ' . $reg->last_name) ?></td>
                                <td><?= htmlspecialchars($reg->email) ?></td>
                                <td><?= htmlspecialchars($reg->phone) ?></td>
                                <td><?= htmlspecialchars($reg->affiliation) ?></td>
                                <td><?= date('M d, Y H:i', strtotime($reg->registration_date)) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted">
                                    No registrations yet
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Event Metadata -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-database me-2"></i>Event Info
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-muted">ID:</td>
                        <td><strong><?= $event->id ?></strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">UID:</td>
                        <td><code class="small"><?= substr($event->uid, 0, 12) ?>...</code></td>
                    </tr>
                    <?php if ($event->department_name): ?>
                    <tr>
                        <td class="text-muted">Department:</td>
                        <td><?= htmlspecialchars($event->department_name) ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td class="text-muted">Created:</td>
                        <td><?= date('M d, Y H:i', strtotime($event->created_at)) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Updated:</td>
                        <td><?= date('M d, Y H:i', strtotime($event->updated_at)) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-cog me-2"></i>Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= base_url('admin/events/edit/' . $event->uid) ?>" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Event
                    </a>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete('<?= base_url('admin/events/delete/' . $event->uid) ?>', 'event')">
                        <i class="fas fa-trash me-2"></i>Delete Event
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


