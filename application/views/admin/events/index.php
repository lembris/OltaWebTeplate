<!-- Events List -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $page_title ?></h1>
    </div>
    <div>
        <a href="<?= base_url('admin/events/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Event
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

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Search and Filter -->
<div class="card mb-3">
    <div class="card-body">
        <form method="get" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="keyword" class="form-control" placeholder="Search events..." value="<?= isset($keyword) ? htmlspecialchars($keyword) : '' ?>">
            </div>
            <div class="col-md-4">
                <select name="department" class="form-select">
                    <option value="">All Departments</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept->id ?>" <?= isset($dept_filter) && $dept_filter == $dept->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dept->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Events Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Event Title</th>
                    <th>Start Date</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Registrations</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($event->title) ?></strong>
                            <?php if ($event->is_featured): ?>
                                <span class="badge bg-warning ms-2">Featured</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= date('M d, Y H:i', strtotime($event->start_date)) ?>
                        </td>
                        <td><?= htmlspecialchars($event->location) ?></td>
                        <td>
                            <span class="badge bg-info"><?= ucfirst($event->event_type) ?></span>
                        </td>
                        <td>
                            <?php if ($event->status === 'upcoming'): ?>
                                <span class="badge bg-success">Upcoming</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Cancelled</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php $count = $this->Event_calendar_model->count_registrations($event->id); ?>
                            <span class="badge bg-secondary"><?= $count ?></span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/events/view/' . $event->uid) ?>" class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= base_url('admin/events/edit/' . $event->uid) ?>" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('admin/events/delete/' . $event->uid) ?>', 'event')" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-inbox text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2">No events found</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


