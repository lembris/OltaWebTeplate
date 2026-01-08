<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Enquiry <?= htmlspecialchars($enquiry->reference_number) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/enquiries') ?>">Enquiries</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/enquiries/view/' . $enquiry->uid) ?>"><?= htmlspecialchars($enquiry->reference_number) ?></a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/enquiries/view/' . $enquiry->uid) ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to View
        </a>
    </div>
</div>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= validation_errors() ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?= form_open('admin/enquiries/edit/' . $enquiry->uid, ['class' => 'needs-validation']) ?>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Customer Information -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user me-2"></i>Customer Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" 
                               value="<?= set_value('full_name', $enquiry->full_name) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" 
                               value="<?= set_value('email', $enquiry->email) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" 
                               value="<?= set_value('phone', $enquiry->phone ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" 
                               value="<?= set_value('country', $enquiry->country ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Trip Details -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-map-marked-alt me-2"></i>Trip Details
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trip Type</label>
                        <?php $trip_types = ['Safari', 'Beach Holiday', 'Mountain Climbing', 'Cultural Tour', 'Honeymoon', 'Family Vacation', 'Wildlife Photography', 'Combined Safari & Beach']; ?>
                        <select name="trip_type" class="form-select">
                            <option value="">Select Trip Type</option>
                            <?php foreach ($trip_types as $type): ?>
                                <option value="<?= $type ?>" <?= set_select('trip_type', $type, ($enquiry->trip_type ?? '') === $type) ?>><?= $type ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Duration</label>
                        <?php $durations = ['3-5 days', '6-7 days', '8-10 days', '11-14 days', '15+ days']; ?>
                        <select name="duration" class="form-select">
                            <option value="">Select Duration</option>
                            <?php foreach ($durations as $dur): ?>
                                <option value="<?= $dur ?>" <?= set_select('duration', $dur, ($enquiry->duration ?? '') === $dur) ?>><?= $dur ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Travel Date From</label>
                        <input type="date" name="travel_date_from" class="form-control" 
                               value="<?= set_value('travel_date_from', $enquiry->travel_date_from ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Travel Date To</label>
                        <input type="date" name="travel_date_to" class="form-control" 
                               value="<?= set_value('travel_date_to', $enquiry->travel_date_to ?? '') ?>">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Destinations</label>
                        <?php 
                        $all_destinations = ['Serengeti', 'Ngorongoro', 'Tarangire', 'Lake Manyara', 'Zanzibar', 'Kilimanjaro', 'Arusha', 'Selous', 'Ruaha', 'Mikumi'];
                        $selected_destinations = json_decode($enquiry->destinations ?? '[]', true) ?: [];
                        ?>
                        <div class="row">
                            <?php foreach ($all_destinations as $dest): ?>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="destinations[]" 
                                               value="<?= $dest ?>" id="dest_<?= strtolower(str_replace(' ', '_', $dest)) ?>"
                                               <?= in_array($dest, $selected_destinations) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="dest_<?= strtolower(str_replace(' ', '_', $dest)) ?>">
                                            <?= $dest ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Travelers -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-users me-2"></i>Travelers
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Adults</label>
                        <input type="number" name="adults" class="form-control" min="1" max="20"
                               value="<?= set_value('adults', $enquiry->adults ?? 1) ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Children</label>
                        <input type="number" name="children" class="form-control" min="0" max="10"
                               value="<?= set_value('children', $enquiry->children ?? 0) ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Children Ages</label>
                        <input type="text" name="children_ages" class="form-control" placeholder="e.g., 5, 8, 12"
                               value="<?= set_value('children_ages', $enquiry->children_ages ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Preferences -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-star me-2"></i>Preferences
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Accommodation</label>
                        <?php $accommodations = ['Budget', 'Mid-Range', 'Luxury', 'Ultra-Luxury']; ?>
                        <select name="accommodation" class="form-select">
                            <option value="">Select Accommodation</option>
                            <?php foreach ($accommodations as $acc): ?>
                                <option value="<?= $acc ?>" <?= set_select('accommodation', $acc, ($enquiry->accommodation ?? '') === $acc) ?>><?= $acc ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Budget</label>
                        <?php $budgets = ['$1,000 - $2,000', '$2,000 - $3,500', '$3,500 - $5,000', '$5,000 - $7,500', '$7,500 - $10,000', '$10,000+']; ?>
                        <select name="budget" class="form-select">
                            <option value="">Select Budget</option>
                            <?php foreach ($budgets as $bud): ?>
                                <option value="<?= $bud ?>" <?= set_select('budget', $bud, ($enquiry->budget ?? '') === $bud) ?>><?= $bud ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Interests</label>
                        <?php 
                        $all_interests = ['Big Five', 'Bird Watching', 'Photography', 'Cultural Experiences', 'Walking Safaris', 'Hot Air Balloon', 'Beach Relaxation', 'Mountain Climbing', 'Water Sports'];
                        $selected_interests = json_decode($enquiry->interests ?? '[]', true) ?: [];
                        ?>
                        <div class="row">
                            <?php foreach ($all_interests as $interest): ?>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="interests[]" 
                                               value="<?= $interest ?>" id="int_<?= strtolower(str_replace(' ', '_', $interest)) ?>"
                                               <?= in_array($interest, $selected_interests) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="int_<?= strtolower(str_replace(' ', '_', $interest)) ?>">
                                            <?= $interest ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Special Requirements -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-comment-alt me-2"></i>Special Requirements
            </div>
            <div class="card-body">
                <textarea name="special_requirements" class="form-control" rows="5" 
                          placeholder="Any special requirements, dietary needs, medical conditions, etc."><?= set_value('special_requirements', $enquiry->special_requirements ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Status Card -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-tag me-2"></i>Status
            </div>
            <div class="card-body">
                <select name="status" class="form-select mb-3">
                    <option value="new" <?= set_select('status', 'new', ($enquiry->status ?? '') === 'new') ?>>🔴 New</option>
                    <option value="read" <?= set_select('status', 'read', ($enquiry->status ?? '') === 'read') ?>>🔵 Read</option>
                    <option value="replied" <?= set_select('status', 'replied', ($enquiry->status ?? '') === 'replied') ?>>🟢 Replied</option>
                    <option value="closed" <?= set_select('status', 'closed', ($enquiry->status ?? '') === 'closed') ?>>⚫ Closed</option>
                </select>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i>Enquiry Info
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <strong>Reference:</strong><br>
                    <span class="badge bg-primary fs-6"><?= htmlspecialchars($enquiry->reference_number) ?></span>
                </p>
                <p class="mb-2">
                    <strong>Created:</strong><br>
                    <?= date('F d, Y \a\t H:i', strtotime($enquiry->created_at)) ?>
                </p>
                <?php if (!empty($enquiry->updated_at)): ?>
                    <p class="mb-2">
                        <strong>Last Updated:</strong><br>
                        <?= date('F d, Y \a\t H:i', strtotime($enquiry->updated_at)) ?>
                    </p>
                <?php endif; ?>
                <?php if (!empty($enquiry->ip_address)): ?>
                    <p class="mb-0">
                        <strong>IP Address:</strong><br>
                        <small class="text-muted"><?= htmlspecialchars($enquiry->ip_address) ?></small>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Save Changes
                    </button>
                    <a href="<?= base_url('admin/enquiries/view/' . $enquiry->uid) ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>
