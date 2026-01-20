<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?= $team_member ? 'Edit Team Member' : 'Add Team Member' ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/team_members') ?>">Team Members</a></li>
                <li class="breadcrumb-item active"><?= $team_member ? 'Edit' : 'Create' ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/team_members') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>
</div>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= validation_errors() ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?= form_open_multipart($form_action, ['id' => 'teamMemberForm']) ?>
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user me-2"></i>Member Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="first_name" 
                                       id="first_name" 
                                       class="form-control" 
                                       value="<?= set_value('first_name', $team_member ? $team_member->first_name : '') ?>" 
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="last_name" 
                                       id="last_name" 
                                       class="form-control" 
                                       value="<?= set_value('last_name', $team_member ? $team_member->last_name : '') ?>" 
                                       required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title / Position <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="title" 
                               class="form-control" 
                               value="<?= set_value('title', $team_member ? $team_member->title : '') ?>" 
                               placeholder="e.g., Founder & CEO" 
                               required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control" 
                                       value="<?= set_value('email', $team_member ? $team_member->email : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" 
                                       name="phone" 
                                       class="form-control" 
                                       value="<?= set_value('phone', $team_member ? $team_member->phone : '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Member Type</label>
                                <select name="member_type" class="form-select">
                                    <option value="">Select Type</option>
                                    <option value="Leadership" <?= set_select('member_type', 'Leadership', ($team_member ? $team_member->member_type : '') === 'Leadership') ?>>Leadership</option>
                                    <option value="Management" <?= set_select('member_type', 'Management', ($team_member ? $team_member->member_type : '') === 'Management') ?>>Management</option>
                                    <option value="Medical" <?= set_select('member_type', 'Medical', ($team_member ? $team_member->member_type : '') === 'Medical') ?>>Medical Staff</option>
                                    <option value="Faculty" <?= set_select('member_type', 'Faculty', ($team_member ? $team_member->member_type : '') === 'Faculty') ?>>Faculty</option>
                                    <option value="Support" <?= set_select('member_type', 'Support', ($team_member ? $team_member->member_type : '') === 'Support') ?>>Support Staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Specialization</label>
                                <input type="text" 
                                       name="specialization" 
                                       class="form-control" 
                                       value="<?= set_value('specialization', $team_member ? $team_member->specialization : '') ?>"
                                       placeholder="e.g., Healthcare Management">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bio / Description</label>
                        <textarea name="bio" 
                                  class="form-control" 
                                  rows="4" 
                                  placeholder="Brief description about the team member..."><?= set_value('bio', $team_member ? $team_member->bio : '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-share-alt me-2"></i>Social Links
                </div>
                <div class="card-body">
                    <?php 
                        $social_links = json_decode($team_member ? $team_member->social_links : '{}', true);
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-facebook me-1"></i>Facebook</label>
                                <input type="url" 
                                       name="social_links[facebook]" 
                                       class="form-control" 
                                       value="<?= set_value('social_links[facebook]', $social_links['facebook'] ?? '') ?>"
                                       placeholder="https://facebook.com/...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-linkedin me-1"></i>LinkedIn</label>
                                <input type="url" 
                                       name="social_links[linkedin]" 
                                       class="form-control" 
                                       value="<?= set_value('social_links[linkedin]', $social_links['linkedin'] ?? '') ?>"
                                       placeholder="https://linkedin.com/in/...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-twitter me-1"></i>Twitter / X</label>
                                <input type="url" 
                                       name="social_links[twitter]" 
                                       class="form-control" 
                                       value="<?= set_value('social_links[twitter]', $social_links['twitter'] ?? '') ?>"
                                       placeholder="https://twitter.com/...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-instagram me-1"></i>Instagram</label>
                                <input type="url" 
                                       name="social_links[instagram]" 
                                       class="form-control" 
                                       value="<?= set_value('social_links[instagram]', $social_links['instagram'] ?? '') ?>"
                                       placeholder="https://instagram.com/...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publish -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-save me-2"></i>Status
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Visibility</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= set_select('status', 'active', ($team_member ? $team_member->status : 'active') === 'active') ?>>Active - Visible on website</option>
                            <option value="inactive" <?= set_select('status', 'inactive', ($team_member ? $team_member->status : '') === 'inactive') ?>>Inactive - Hidden from website</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_featured" 
                                   id="is_featured" 
                                   value="1" 
                                   <?= set_checkbox('is_featured', '1', ($team_member ? $team_member->is_featured : 0) == 1) ?>>
                            <label class="form-check-label" for="is_featured">
                                <strong>Featured Member</strong>
                                <br><small class="text-muted">Highlight on team page</small>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" 
                               name="display_order" 
                               class="form-control" 
                               value="<?= set_value('display_order', $team_member ? $team_member->display_order : 0) ?>" 
                               min="0">
                        <small class="text-muted">Lower numbers appear first</small>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i><?= $team_member ? 'Update Member' : 'Add Member' ?>
                        </button>
                        <a href="<?= base_url('admin/team_members') ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Photo Upload -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-camera me-2"></i>Profile Photo
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="image-preview mb-3">
                            <?php if (!empty($team_member->photo)): ?>
                                <img src="<?= base_url('assets/images/team/' . $team_member->photo) ?>" 
                                     alt="Current Photo" 
                                     id="imagePreview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                     id="imagePreviewPlaceholder"
                                     style="height: 150px;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-user fa-3x mb-2"></i>
                                        <p class="mb-0">No photo uploaded</p>
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
                               name="photo" 
                               id="photo" 
                               class="form-control" 
                               accept="image/*">
                        <small class="text-muted">Recommended: 400x400px. Max 2MB. JPG, PNG</small>
                    </div>
                </div>
            </div>

                    <!-- Member Info (Edit Mode) -->
                    <?php if ($team_member): ?>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info me-2"></i>Member Info
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">ID:</td>
                            <td><strong><?= $team_member->id ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">UID:</td>
                            <td><small><?= $team_member->uid ?></small></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td><?= isset($team_member->created_at) ? date('M d, Y', strtotime($team_member->created_at)) : 'N/A' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Updated:</td>
                            <td><?= isset($team_member->updated_at) ? date('M d, Y H:i', strtotime($team_member->updated_at)) : 'N/A' ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?= form_close() ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview with placeholder handling
    document.getElementById('photo').addEventListener('change', function() {
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
});
</script>
