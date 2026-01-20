<!-- Event Form -->
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $page_title ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/events') ?>">Events</a></li>
                <li class="breadcrumb-item active"><?= $page_title ?></li>
            </ol>
        </nav>
    </div>
    <div>
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

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= validation_errors() ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?= form_open_multipart(isset($event) && $event ? 'admin/events/edit/' . $event->uid : 'admin/events/create', ['id' => 'eventForm']) ?>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-calendar me-2"></i>Basic Information
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Event Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= form_error('title') ? 'is-invalid' : '' ?>" 
                               name="title" 
                               value="<?= set_value('title', isset($event) && $event ? $event->title : '') ?>" 
                               placeholder="e.g., Annual Conference 2024"
                               required>
                        <?php if (form_error('title')): ?>
                            <div class="text-danger small mt-1"><?= form_error('title') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control <?= form_error('start_date') ? 'is-invalid' : '' ?>" 
                                   name="start_date" 
                                   value="<?= set_value('start_date', isset($event) && $event ? date('Y-m-d', strtotime($event->start_date)) : '') ?>"
                                   required>
                            <?php if (form_error('start_date')): ?>
                                <div class="text-danger small mt-1"><?= form_error('start_date') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Time</label>
                            <input type="time" 
                                   class="form-control" 
                                   name="start_time" 
                                   value="<?= set_value('start_time', isset($event) && $event && $event->start_time ? date('H:i', strtotime($event->start_time)) : '') ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control <?= form_error('end_date') ? 'is-invalid' : '' ?>" 
                                   name="end_date" 
                                   value="<?= set_value('end_date', isset($event) && $event ? date('Y-m-d', strtotime($event->end_date)) : '') ?>"
                                   required>
                            <?php if (form_error('end_date')): ?>
                                <div class="text-danger small mt-1"><?= form_error('end_date') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Time</label>
                            <input type="time" 
                                   class="form-control" 
                                   name="end_time" 
                                   value="<?= set_value('end_time', isset($event) && $event && $event->end_time ? date('H:i', strtotime($event->end_time)) : '') ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= form_error('location') ? 'is-invalid' : '' ?>" 
                               name="location" 
                               value="<?= set_value('location', isset($event) && $event ? $event->location : '') ?>" 
                               placeholder="e.g., Main Auditorium"
                               required>
                        <?php if (form_error('location')): ?>
                            <div class="text-danger small mt-1"><?= form_error('location') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department_id">
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept->id ?>" 
                                        <?= set_select('department_id', $dept->id, isset($event) && $event && $event->department_id == $dept->id) ?>>
                                        <?= htmlspecialchars($dept->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Event Type</label>
                            <select class="form-select" name="event_type">
                                <option value="academic" <?= set_select('event_type', 'academic', !isset($event) || !$event || $event->event_type == 'academic') ?>>Academic</option>
                                <option value="administrative" <?= set_select('event_type', 'administrative', isset($event) && $event && $event->event_type == 'administrative') ?>>Administrative</option>
                                <option value="cultural" <?= set_select('event_type', 'cultural', isset($event) && $event && $event->event_type == 'cultural') ?>>Cultural</option>
                                <option value="sports" <?= set_select('event_type', 'sports', isset($event) && $event && $event->event_type == 'sports') ?>>Sports</option>
                                <option value="workshop" <?= set_select('event_type', 'workshop', isset($event) && $event && $event->event_type == 'workshop') ?>>Workshop</option>
                                <option value="seminar" <?= set_select('event_type', 'seminar', isset($event) && $event && $event->event_type == 'seminar') ?>>Seminar</option>
                                <option value="conference" <?= set_select('event_type', 'conference', isset($event) && $event && $event->event_type == 'conference') ?>>Conference</option>
                                <option value="social" <?= set_select('event_type', 'social', isset($event) && $event && $event->event_type == 'social') ?>>Social</option>
                                <option value="holiday" <?= set_select('event_type', 'holiday', isset($event) && $event && $event->event_type == 'holiday') ?>>Holiday</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-align-left me-2"></i>Description & Details
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Event Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control ckeditor" 
                                  rows="8"><?= set_value('description', isset($event) && $event ? $event->description : '') ?></textarea>
                        <small class="text-muted">Detailed information about the event.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publish -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-save me-2"></i>Publish
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="upcoming" <?= set_select('status', 'upcoming', !isset($event) || !$event || $event->status == 'upcoming') ?>>
                                Upcoming
                            </option>
                            <option value="cancelled" <?= set_select('status', 'cancelled', isset($event) && $event && $event->status == 'cancelled') ?>>
                                Cancelled
                            </option>
                        </select>
                        <small class="text-muted">Event status</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Visibility</label>
                        <select name="visibility" class="form-select">
                            <option value="public" <?= set_select('visibility', 'public', !isset($event) || !$event || $event->visibility == 'public') ?>>
                                Public
                            </option>
                            <option value="private" <?= set_select('visibility', 'private', isset($event) && $event && $event->visibility == 'private') ?>>
                                Private
                            </option>
                        </select>
                        <small class="text-muted">Who can see this event</small>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1"
                                <?= set_checkbox('is_featured', 1, isset($event) && $event && $event->is_featured) ?>>
                            <label class="form-check-label" for="is_featured">
                                Featured Event
                            </label>
                        </div>
                        <small class="text-muted d-block mt-1">Show on homepage</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="registration_required" id="registration_required" value="1"
                                <?= set_checkbox('registration_required', 1, isset($event) && $event && $event->registration_required) ?>>
                            <label class="form-check-label" for="registration_required">
                                Registration Required
                            </label>
                        </div>
                        <small class="text-muted d-block mt-1">Allow attendees to register</small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= isset($event) && $event ? 'Update Event' : 'Create Event' ?>
                        </button>
                        <a href="<?= base_url('admin/events') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Banner Image Upload -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-image me-2"></i>Banner Image
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="image-preview mb-3">
                            <?php if (isset($event) && $event && !empty($event->banner)): ?>
                                <img src="<?= base_url($event->banner) ?>" 
                                     alt="Current Image" 
                                     id="imagePreview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                     id="imagePreviewPlaceholder"
                                     style="height: 150px;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <p class="mb-0">No image uploaded</p>
                                    </div>
                                </div>
                                <img src="" 
                                     alt="Preview" 
                                     id="imagePreview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px; width: 100%; object-fit: cover; display: none;">
                            <?php endif; ?>
                        </div>

                        <input type="file" 
                               name="banner" 
                               id="banner" 
                               class="form-control" 
                               accept="image/*">
                        <small class="text-muted">Recommended: 1200x400px. Max 2MB. JPG, PNG, WebP</small>
                    </div>
                </div>
            </div>

            <!-- Event Info (Edit Mode) -->
            <?php if (isset($event) && $event): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Event Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $event->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Type:</td>
                            <td><?= ucfirst($event->event_type) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Registrations:</td>
                            <td><?= $this->Event_calendar_model->count_registrations($event->id) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= date('M d, Y', strtotime($event->created_at)) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= date('M d, Y H:i', strtotime($event->updated_at)) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Tips -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-lightbulb me-2"></i>Tips
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary small">Event Dates</h6>
                        <p class="small text-muted">Set accurate start and end dates to help attendees plan.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary small">Featured Events</h6>
                        <p class="small text-muted">Featured events appear on the homepage and in featured sections.</p>
                    </div>
                    <div>
                        <h6 class="text-primary small">Registration</h6>
                        <p class="small text-muted">Enable registration if attendees need to sign up.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= form_close() ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Banner image preview
    const bannerInput = document.getElementById('banner');
    if (bannerInput) {
        bannerInput.addEventListener('change', function() {
            const placeholder = document.getElementById('imagePreviewPlaceholder');
            const preview = document.getElementById('imagePreview');
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
</script>
