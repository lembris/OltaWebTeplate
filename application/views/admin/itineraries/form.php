<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $day ? 'Edit Day ' . $day->day_number : 'Add Itinerary Day' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/itineraries') ?>">Itineraries</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/itineraries/manage/' . $package->uid) ?>"><?= html_escape($package->name) ?></a></li>
                <li class="breadcrumb-item active"><?= $day ? 'Edit' : 'Add' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/itineraries/manage/' . $package->uid) ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Itinerary
        </a>
    </div>
</div>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= validation_errors() ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('warning')): ?>
    <div class="alert alert-warning alert-dismissible fade show">
        <i class="fas fa-exclamation-triangle me-2"></i><?= $this->session->flashdata('warning') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?= form_open($form_action, ['id' => 'itineraryForm']) ?>
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>Day Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Day Number <span class="text-danger">*</span></label>
                                <input type="number" 
                                       name="day_number" 
                                       class="form-control" 
                                       value="<?= set_value('day_number', $day->day_number ?? $next_day_number) ?>" 
                                       min="0" 
                                       required>
                                <small class="text-muted">Use 0 for Arrival Day</small>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="title" 
                                       class="form-control" 
                                       value="<?= set_value('title', $day->title ?? '') ?>" 
                                       placeholder="e.g., Serengeti Game Drives & Sunset"
                                       required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control" 
                                  rows="8"
                                  placeholder="Describe the day's activities, highlights, and experiences..."><?= set_value('description', $day->description ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Activities -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-hiking me-2"></i>Activities
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Activities (JSON format or text)</label>
                        <textarea name="activities" 
                                  class="form-control" 
                                  rows="4" 
                                  placeholder='["Morning game drive", "Visit Maasai village", "Sunset safari"]'><?= set_value('activities', $day->activities ?? '') ?></textarea>
                        <small class="text-muted">Enter as JSON array or plain text</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Save Button -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-save me-2"></i>Save
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= $day ? 'Update Day' : 'Add Day' ?>
                        </button>
                        <a href="<?= base_url('admin/itineraries/manage/' . $package->uid) ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Meals -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-utensils me-2"></i>Meals Included
                </div>
                <div class="card-body">
                    <?php 
                    $saved_meals = [];
                    if (!empty($day->meals)) {
                        $saved_meals = explode(',', $day->meals);
                    }
                    ?>
                    <div class="form-check mb-2">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="meals[]" 
                               value="B" 
                               id="mealBreakfast"
                               <?= in_array('B', $saved_meals) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="mealBreakfast">
                            <i class="fas fa-coffee me-1 text-warning"></i> Breakfast (B)
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="meals[]" 
                               value="L" 
                               id="mealLunch"
                               <?= in_array('L', $saved_meals) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="mealLunch">
                            <i class="fas fa-hamburger me-1 text-warning"></i> Lunch (L)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="meals[]" 
                               value="D" 
                               id="mealDinner"
                               <?= in_array('D', $saved_meals) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="mealDinner">
                            <i class="fas fa-utensils me-1 text-warning"></i> Dinner (D)
                        </label>
                    </div>
                </div>
            </div>

            <!-- Accommodation -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bed me-2"></i>Accommodation
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Accommodation</label>
                        <input type="text" 
                               name="accommodation_type" 
                               class="form-control" 
                               value="<?= set_value('accommodation_type', $day->accommodation ?? '') ?>" 
                               placeholder="e.g., Serengeti Camp, Ngorongoro Lodge">
                        <small class="text-muted">Enter lodge/camp name or type</small>
                    </div>
                </div>
            </div>

            <!-- Package Info -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-box me-2"></i>Package Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Package:</td>
                            <td><strong><?= html_escape($package->name) ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Duration:</td>
                            <td><?= $package->duration_days ?> Days</td>
                        </tr>
                        <?php if ($day): ?>
                        <tr>
                            <td class="text-muted">UID:</td>
                            <td><code><?= $day->uid ?></code></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?= form_close() ?>
