<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $page_title ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/destinations') ?>">Destinations</a></li>
                <li class="breadcrumb-item active"><?= $page_title ?></li>
            </ol>
        </nav>
    </div>
</div>

<!-- Destination Form -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-map-marker-alt me-2"></i><?= $page_title ?>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                    
                    <!-- Name & Country Row -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Destination Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" 
                                   id="name" name="name" 
                                   value="<?= $destination->name ?? set_value('name') ?>" required>
                            <?php if (form_error('name')): ?>
                                <div class="invalid-feedback d-block"><?= form_error('name') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('country') ? 'is-invalid' : '' ?>" 
                                   id="country" name="country" 
                                   value="<?= $destination->country ?? set_value('country') ?>" required>
                            <?php if (form_error('country')): ?>
                                <div class="invalid-feedback d-block"><?= form_error('country') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Featured Image</label>
                        <div class="card border-dashed p-3">
                            <div class="text-center">
                                <?php if (!empty($destination) && !empty($destination->featured_image)): ?>
                                    <img src="<?= base_url('assets/img/destinations/' . $destination->featured_image) ?>" 
                                         alt="Featured Image" class="img-thumbnail mb-3" style="max-width: 200px;">
                                    <br>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="featured_image" name="featured_image" 
                                       accept="image/*" onchange="previewImage(this)">
                                <small class="text-muted d-block mt-2">Max 2MB. Formats: JPG, PNG, WebP</small>
                            </div>
                            <img id="imagePreview" style="display: none; max-width: 200px;" class="mt-3">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control <?= form_error('description') ? 'is-invalid' : '' ?>" 
                                  id="description" name="description" rows="6" required><?= $destination->description ?? set_value('description') ?></textarea>
                        <small class="text-muted">Detailed information about the destination</small>
                        <?php if (form_error('description')): ?>
                            <div class="invalid-feedback d-block"><?= form_error('description') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Best Time -->
                    <div class="mb-3">
                        <label for="best_time" class="form-label">Best Time to Visit</label>
                        <input type="text" class="form-control" id="best_time" name="best_time" 
                               value="<?= $destination->best_time ?? set_value('best_time') ?>"
                               placeholder="e.g., June - October">
                        <small class="text-muted">Recommended visiting season</small>
                    </div>

                    <!-- Highlights (JSON) -->
                    <div class="mb-3">
                        <label for="highlights" class="form-label">Highlights (One per line)</label>
                        <textarea class="form-control" id="highlights" name="highlights" rows="4" 
                                  placeholder="Wildlife viewing&#10;Mountain hiking&#10;Cultural tours"><?php 
                            if (!empty($destination->highlights)) {
                                $h = is_array($destination->highlights) ? $destination->highlights : json_decode($destination->highlights, true);
                                echo implode("\n", $h ?? []);
                            } else {
                                echo set_value('highlights');
                            }
                        ?></textarea>
                        <small class="text-muted">Key attractions and activities at this destination</small>
                    </div>

                    <!-- Activities (JSON) -->
                    <div class="mb-3">
                        <label for="activities" class="form-label">Activities (One per line)</label>
                        <textarea class="form-control" id="activities" name="activities" rows="4"
                                  placeholder="Game drives&#10;Bird watching&#10;Photography safaris"><?php 
                            if (!empty($destination->activities)) {
                                $a = is_array($destination->activities) ? $destination->activities : json_decode($destination->activities, true);
                                echo implode("\n", $a ?? []);
                            } else {
                                echo set_value('activities');
                            }
                        ?></textarea>
                        <small class="text-muted">Available activities and experiences</small>
                    </div>

                    <hr class="my-4">

                    <!-- SEO Section -->
                    <div class="alert alert-info">
                        <i class="fas fa-search me-2"></i><strong>SEO Settings</strong>
                    </div>

                    <!-- SEO Title -->
                    <div class="mb-3">
                        <label for="seo_title" class="form-label">SEO Title</label>
                        <input type="text" class="form-control" id="seo_title" name="seo_title" 
                               value="<?= $destination->seo_title ?? set_value('seo_title') ?>"
                               placeholder="50-60 characters">
                        <small class="text-muted">Appears in search results (50-60 chars recommended)</small>
                    </div>

                    <!-- SEO Description -->
                    <div class="mb-3">
                        <label for="seo_description" class="form-label">SEO Description</label>
                        <textarea class="form-control" id="seo_description" name="seo_description" rows="3"
                                  placeholder="150-160 characters describing the destination"><?= $destination->seo_description ?? set_value('seo_description') ?></textarea>
                        <small class="text-muted">Appears in search results (150-160 chars recommended)</small>
                    </div>

                    <!-- Active Status -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   <?= (!empty($destination) && $destination->is_active) || set_value('is_active') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                Active (Published)
                            </label>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mb-0">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i><?= !empty($destination) ? 'Update Destination' : 'Create Destination' ?>
                        </button>
                        <a href="<?= base_url('admin/destinations') ?>" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-lg-4">
        <!-- Info Card -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i>Information
            </div>
            <div class="card-body">
                <p class="mb-0"><strong>Destinations</strong> are safari locations that can be featured in packages.</p>
            </div>
        </div>

        <!-- Quick Tips -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-lightbulb me-2"></i>Quick Tips
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Use clear, descriptive names</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Add high-quality featured images</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>List key highlights and activities</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Fill in SEO fields for better search visibility</small>
                    </li>
                    <li>
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Set as active to publish publicly</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Convert textarea to JSON array on submit
document.querySelector('form').addEventListener('submit', function(e) {
    // Convert highlights
    const highlightsText = document.getElementById('highlights').value;
    if (highlightsText) {
        const highlights = highlightsText.split('\n').filter(h => h.trim());
        document.getElementById('highlights').value = JSON.stringify(highlights);
    }
    
    // Convert activities
    const activitiesText = document.getElementById('activities').value;
    if (activitiesText) {
        const activities = activitiesText.split('\n').filter(a => a.trim());
        document.getElementById('activities').value = JSON.stringify(activities);
    }
});
</script>
