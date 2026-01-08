<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Admission <?= htmlspecialchars($admission->reference_number) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/admissions') ?>">Admissions</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/admissions/view/' . $admission->uid) ?>"><?= htmlspecialchars($admission->reference_number) ?></a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/admissions/view/' . $admission->uid) ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to View
        </a>
    </div>
</div>

<?= form_open('admin/admissions/edit/' . $admission->uid, ['class' => 'needs-validation']) ?>

<div class="row">
    <div class="col-lg-8">
        <!-- Personal Information -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user me-2"></i>Personal Information
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control <?= form_error('full_name') ? 'is-invalid' : '' ?>" 
                               value="<?= set_value('full_name', $admission->full_name) ?>" required>
                        <div class="invalid-feedback"><?= form_error('full_name') ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" 
                               value="<?= set_value('email', $admission->email) ?>" required>
                        <div class="invalid-feedback"><?= form_error('email') ?></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" 
                               value="<?= set_value('phone', $admission->phone) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control" 
                               value="<?= set_value('date_of_birth', $admission->date_of_birth) ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="male" <?= set_select('gender', 'male', $admission->gender === 'male') ?>>Male</option>
                            <option value="female" <?= set_select('gender', 'female', $admission->gender === 'female') ?>>Female</option>
                            <option value="other" <?= set_select('gender', 'other', $admission->gender === 'other') ?>>Other</option>
                            <option value="prefer_not_to_say" <?= set_select('gender', 'prefer_not_to_say', $admission->gender === 'prefer_not_to_say') ?>>Prefer not to say</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nationality</label>
                        <input type="text" name="nationality" class="form-control" 
                               value="<?= set_value('nationality', $admission->nationality) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2"><?= set_value('address', $admission->address) ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" 
                               value="<?= set_value('city', $admission->city) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" 
                               value="<?= set_value('country', $admission->country) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="postal_code" class="form-control" 
                               value="<?= set_value('postal_code', $admission->postal_code) ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-graduation-cap me-2"></i>Academic Information
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Applied Program</label>
                        <select name="program_id" class="form-select">
                            <option value="">Select Program</option>
                            <?php if (!empty($programs)): ?>
                                <?php foreach ($programs as $program): ?>
                                    <option value="<?= $program->id ?>" <?= set_select('program_id', $program->id, $admission->program_id == $program->id) ?>>
                                        <?= htmlspecialchars($program->name) ?> (<?= htmlspecialchars($program->code ?? '') ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Intake Term</label>
                        <select name="intake_term" class="form-select">
                            <option value="">Select Term</option>
                            <option value="Fall" <?= set_select('intake_term', 'Fall', $admission->intake_term === 'Fall') ?>>Fall</option>
                            <option value="Spring" <?= set_select('intake_term', 'Spring', $admission->intake_term === 'Spring') ?>>Spring</option>
                            <option value="Summer" <?= set_select('intake_term', 'Summer', $admission->intake_term === 'Summer') ?>>Summer</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Intake Year</label>
                        <select name="intake_year" class="form-select">
                            <option value="">Select Year</option>
                            <?php for ($y = date('Y'); $y <= date('Y') + 3; $y++): ?>
                                <option value="<?= $y ?>" <?= set_select('intake_year', $y, $admission->intake_year == $y) ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Previous Qualification</label>
                        <input type="text" name="previous_qualification" class="form-control" 
                               value="<?= set_value('previous_qualification', $admission->previous_qualification) ?>"
                               placeholder="e.g., Bachelor's Degree, High School Diploma">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Institution Name</label>
                        <input type="text" name="institution_name" class="form-control" 
                               value="<?= set_value('institution_name', $admission->institution_name) ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Graduation Year</label>
                        <input type="text" name="graduation_year" class="form-control" maxlength="4"
                               value="<?= set_value('graduation_year', $admission->graduation_year) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">GPA/Score</label>
                        <input type="text" name="gpa_score" class="form-control" 
                               value="<?= set_value('gpa_score', $admission->gpa_score) ?>"
                               placeholder="e.g., 3.5/4.0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-phone-alt me-2"></i>Emergency Contact
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Contact Name</label>
                        <input type="text" name="emergency_contact_name" class="form-control" 
                               value="<?= set_value('emergency_contact_name', $admission->emergency_contact_name) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="emergency_contact_phone" class="form-control" 
                               value="<?= set_value('emergency_contact_phone', $admission->emergency_contact_phone) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Relationship</label>
                        <input type="text" name="emergency_contact_relation" class="form-control" 
                               value="<?= set_value('emergency_contact_relation', $admission->emergency_contact_relation) ?>"
                               placeholder="e.g., Parent, Spouse">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Status & Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-cog me-2"></i>Status & Actions
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Application Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select <?= form_error('status') ? 'is-invalid' : '' ?>" required>
                        <option value="pending" <?= set_select('status', 'pending', $admission->status === 'pending') ?>>🟡 Pending</option>
                        <option value="under_review" <?= set_select('status', 'under_review', $admission->status === 'under_review') ?>>🔵 Under Review</option>
                        <option value="accepted" <?= set_select('status', 'accepted', $admission->status === 'accepted') ?>>🟢 Accepted</option>
                        <option value="rejected" <?= set_select('status', 'rejected', $admission->status === 'rejected') ?>>🔴 Rejected</option>
                        <option value="waitlisted" <?= set_select('status', 'waitlisted', $admission->status === 'waitlisted') ?>>⚪ Waitlisted</option>
                        <option value="enrolled" <?= set_select('status', 'enrolled', $admission->status === 'enrolled') ?>>🎓 Enrolled</option>
                        <option value="withdrawn" <?= set_select('status', 'withdrawn', $admission->status === 'withdrawn') ?>>⚫ Withdrawn</option>
                    </select>
                    <div class="invalid-feedback"><?= form_error('status') ?></div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                    <a href="<?= base_url('admin/admissions/view/' . $admission->uid) ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </div>
        </div>

        <!-- Admin Notes -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-sticky-note me-2"></i>Admin Notes
            </div>
            <div class="card-body">
                <textarea name="admin_notes" class="form-control" rows="5" 
                          placeholder="Internal notes about this application..."><?= set_value('admin_notes', $admission->admin_notes) ?></textarea>
                <small class="text-muted">These notes are only visible to admins.</small>
            </div>
        </div>

        <!-- Application Info -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i>Application Info
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <strong>Reference:</strong><br>
                    <span class="badge bg-primary"><?= htmlspecialchars($admission->reference_number) ?></span>
                </p>
                <p class="mb-2">
                    <strong>Applied On:</strong><br>
                    <?= date('F d, Y \a\t H:i', strtotime($admission->created_at)) ?>
                </p>
                <?php if (!empty($admission->updated_at)): ?>
                    <p class="mb-2">
                        <strong>Last Updated:</strong><br>
                        <?= date('F d, Y \a\t H:i', strtotime($admission->updated_at)) ?>
                    </p>
                <?php endif; ?>
                <?php if (!empty($admission->reviewed_at)): ?>
                    <p class="mb-0">
                        <strong>Reviewed On:</strong><br>
                        <?= date('F d, Y \a\t H:i', strtotime($admission->reviewed_at)) ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= form_close() ?>
