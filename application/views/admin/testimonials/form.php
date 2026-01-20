<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= isset($testimonial) ? 'Edit Testimonial' : 'Create Testimonial' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/testimonials') ?>">Testimonials</a></li>
                <li class="breadcrumb-item active"><?= isset($testimonial) ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/testimonials') ?>" class="btn btn-outline-secondary">
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

<div class="row">
    <div class="col-lg-8">
        <form action="<?= $form_action ?>" method="POST" enctype="multipart/form-data" class="card">
            <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
            
            <div class="card-header">
                <span><i class="fas fa-quote-left me-2"></i>Testimonial Details</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" 
                                   id="name" name="name" value="<?= set_value('name', isset($testimonial) ? $testimonial->name : '') ?>" 
                                   placeholder="e.g., Dr. Sarah Johnson" required>
                            <?= form_error('name', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="role" class="form-label">Role / Title</label>
                            <input type="text" class="form-control" id="role" name="role" 
                                   value="<?= set_value('role', isset($testimonial) ? $testimonial->role : '') ?>" 
                                   placeholder="e.g., Cardiologist">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="company" class="form-label">Company / Organization</label>
                            <input type="text" class="form-control" id="company" name="company" 
                                   value="<?= set_value('company', isset($testimonial) ? $testimonial->company : '') ?>" 
                                   placeholder="e.g., National Hospital">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" 
                                   value="<?= set_value('location', isset($testimonial) ? $testimonial->location : '') ?>" 
                                   placeholder="e.g., Dar es Salaam, Tanzania">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Testimonial Content <span class="text-danger">*</span></label>
                    <textarea class="form-control <?= form_error('content') ? 'is-invalid' : '' ?>" 
                              id="content" name="content" rows="4" 
                              placeholder="What did this person say..." required><?= set_value('content', isset($testimonial) ? $testimonial->content : '') ?></textarea>
                    <?= form_error('content', '<div class="invalid-feedback">', '</div>') ?>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                            <select class="form-select <?= form_error('rating') ? 'is-invalid' : '' ?>" id="rating" name="rating" required>
                                <?php foreach ($rating_options as $value => $label): ?>
                                    <option value="<?= $value ?>" <?= set_select('rating', $value, isset($testimonial) && $testimonial->rating == $value) ?>>
                                        <?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('rating', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" 
                                   value="<?= set_value('display_order', isset($testimonial) ? $testimonial->display_order : 0) ?>" 
                                   min="0" placeholder="0">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Photo</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <small class="text-muted">Allowed: gif, jpg, jpeg, png, webp (max 2MB)</small>
                    
                    <?php if (isset($testimonial) && !empty($testimonial->image)): ?>
                        <div class="mt-2">
                            <img src="<?= base_url('assets/img/testimonials/' . $testimonial->image) ?>" 
                                 alt="Current photo" 
                                 class="rounded"
                                 style="max-width: 100px; max-height: 100px; object-fit: cover;">
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" id="delete_image" name="delete_image">
                                <label class="form-check-label text-danger" for="delete_image">Delete current photo</label>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="status" name="status" 
                               value="1" <?= set_checkbox('status', '1', isset($testimonial) ? $testimonial->status === 'active' : TRUE) ?>>
                        <label class="form-check-label" for="status">
                            Active (publish this testimonial)
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i><?= isset($testimonial) ? 'Update' : 'Create' ?> Testimonial
                </button>
                <a href="<?= base_url('admin/testimonials') ?>" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-info-circle me-2"></i>Information</span>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-3">
                    <i class="fas fa-palette me-1"></i> 
                    <strong>Theme:</strong> <?= ucfirst($active_template) ?>
                </p>
                <p class="small text-muted mb-3">
                    This testimonial will be automatically associated with the 
                    <strong><?= ucfirst($active_template) ?></strong> theme.
                </p>
                
                <hr>
                
                <h6>Rating Guide</h6>
                <ul class="small text-muted mb-0">
                    <li>5 Stars - Excellent</li>
                    <li>4 Stars - Very Good</li>
                    <li>3 Stars - Good</li>
                    <li>2 Stars - Fair</li>
                    <li>1 Star - Poor</li>
                </ul>
                
                <hr>
                
                <h6>Display Order</h6>
                <p class="small text-muted mb-0">Lower numbers appear first. Use 0 for default ordering.</p>
            </div>
        </div>
    </div>
</div>
