<!-- Program Details View -->
<style>
    .detail-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 40px;
        border-radius: 10px;
        margin-bottom: 30px;
    }
    
    .detail-header h1 {
        font-size: 2rem;
        margin-bottom: 10px;
    }
    
    .detail-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 15px;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }
    
    .meta-item i {
        font-size: 1.2rem;
    }
    
    .info-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        border-left: 4px solid #f5576c;
    }
    
    .info-label {
        font-weight: 700;
        color: #f5576c;
        font-size: 0.9rem;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    
    .info-value {
        font-size: 1rem;
        color: #333;
        word-break: break-word;
    }
    
    .course-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .course-table table {
        margin-bottom: 0;
    }
    
    .course-table thead {
        background: #f5576c;
        color: white;
    }
    
    .course-table tbody tr:hover {
        background: #f8f9fa;
    }
    
    .course-code {
        font-weight: 600;
        color: #f5576c;
    }
    
    .semester-badge {
        display: inline-block;
        background: rgba(245, 87, 108, 0.15);
        color: #f5576c;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .btn-group-sm .btn {
        padding: 4px 8px;
        font-size: 0.75rem;
    }
    
    .add-course-btn {
        background: #f5576c;
        color: white;
        border: none;
    }
    
    .add-course-btn:hover {
        background: #e74558;
        color: white;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Program Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/programs') ?>">Academic Programs</a></li>
                <li class="breadcrumb-item active"><?= $page_title ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <div class="btn-group">
            <a href="<?= base_url('admin/programs/edit/' . $program->uid) ?>" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i> Edit Program
            </a>
            <a href="<?= base_url('admin/programs') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>
</div>

<!-- Program Header -->
<div class="detail-header">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h1><?= htmlspecialchars($program->name) ?></h1>
            <p class="text-white-50 mb-0">
                Program Code: <strong><?= htmlspecialchars($program->code) ?></strong>
            </p>
        </div>
        <div class="dropdown">
            <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?= base_url('admin/programs/edit/' . $program->uid) ?>">
                    <i class="fas fa-edit me-2"></i> Edit
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#"
                    onclick="confirmDelete('<?= base_url('admin/programs/delete/' . $program->uid) ?>', 'program'); return false;">
                    <i class="fas fa-trash me-2"></i> Delete
                </a></li>
            </ul>
        </div>
    </div>
    
    <div class="detail-meta">
        <div class="meta-item">
            <i class="fas fa-sitemap"></i>
            <span><?= htmlspecialchars($program->department_name) ?></span>
        </div>
        <div class="meta-item">
            <i class="fas fa-book"></i>
            <span><?= htmlspecialchars($program->level) ?></span>
        </div>
        <div class="meta-item">
            <i class="fas fa-hourglass-half"></i>
            <span><?= $program->duration_months ?> months</span>
        </div>
        <div class="meta-item">
            <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
            <span style="text-transform: capitalize;">
                <?= $program->status == 'active' ? '<span style="color: #27ae60;">Active</span>' : '<span style="color: #e74c3c;">Inactive</span>' ?>
            </span>
        </div>
    </div>
</div>

<!-- Program Information -->
<div class="row mb-30">
    <div class="col-lg-8">
        <!-- Description -->
        <?php if ($program->description): ?>
        <div class="info-section">
            <div class="info-label">Program Description</div>
            <div class="info-value">
                <?= $program->description ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Courses Section -->
        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="fas fa-list-check me-2"></i> Program Courses (<?= count($courses) ?>)
                </h6>
                <button class="btn btn-sm add-course-btn" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                    <i class="fas fa-plus me-2"></i> Add Course
                </button>
            </div>
            
            <?php if (empty($courses)): ?>
            <div class="card-body text-center py-5">
                <i class="fas fa-book-open mb-3" style="font-size: 2rem; color: #ccc;"></i>
                <p class="text-muted mb-0">No courses added yet for this program</p>
            </div>
            <?php else: ?>
            <div class="table-responsive course-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Semester</th>
                            <th>Credits</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                        <tr>
                            <td>
                                <span class="course-code"><?= htmlspecialchars($course->course_code) ?></span>
                            </td>
                            <td><?= htmlspecialchars($course->course_name) ?></td>
                            <td>
                                <span class="semester-badge">Semester <?= $course->semester ?></span>
                            </td>
                            <td><?= $course->credits ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" 
                                            data-bs-target="#editCourseModal" 
                                            onclick="loadCourseEdit(<?= $course->id ?>, '<?= htmlspecialchars($course->course_code) ?>', '<?= htmlspecialchars($course->course_name) ?>', <?= $course->semester ?>, <?= $course->credits ?>, '<?= htmlspecialchars($course->description ?? '') ?>')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="deleteCourse(<?= $course->id ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Sidebar Info -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="fas fa-information-circle me-2"></i> Program Information
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="info-label">Program Code</div>
                    <div class="info-value"><?= htmlspecialchars($program->code) ?></div>
                </div>
                
                <div class="mb-3">
                    <div class="info-label">Department</div>
                    <div class="info-value"><?= htmlspecialchars($program->department_name) ?></div>
                </div>
                
                <div class="mb-3">
                    <div class="info-label">Level</div>
                    <div class="info-value"><?= htmlspecialchars($program->level) ?></div>
                </div>
                
                <div class="mb-3">
                    <div class="info-label">Duration</div>
                    <div class="info-value"><?= $program->duration_months ?> months</div>
                </div>
                
                <div class="mb-3">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="badge bg-<?= $program->status == 'active' ? 'success' : 'danger' ?>">
                            <?= ucfirst($program->status) ?>
                        </span>
                    </div>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <div class="info-label">Total Courses</div>
                    <div class="info-value"><?= count($courses) ?></div>
                </div>
                
                <div class="mb-3">
                    <div class="info-label">Created</div>
                    <div class="info-value">
                        <?php 
                            $created_date = new DateTime($program->created_at);
                            echo $created_date->format('M d, Y');
                        ?>
                    </div>
                </div>
                
                <div>
                    <div class="info-label">Last Updated</div>
                    <div class="info-value">
                        <?php 
                            $updated_date = new DateTime($program->updated_at);
                            echo $updated_date->format('M d, Y H:i');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Course to Program</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addCourseForm" method="post">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="course_code" class="form-label">Course Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="course_code" name="course_code" required placeholder="e.g., CS101">
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="course_name" class="form-label">Course Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="course_name" name="course_name" required placeholder="e.g., Introduction to Programming">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="semester" name="semester" required min="1" max="8" placeholder="e.g., 1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="credits" class="form-label">Credits <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="credits" name="credits" required min="1" step="0.5" placeholder="e.g., 3">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Course description (optional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCourseForm" method="post">
                <input type="hidden" id="edit_course_id" name="course_id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="edit_course_code" class="form-label">Course Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_course_code" name="course_code" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_course_name" class="form-label">Course Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_course_name" name="course_name" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="edit_semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_semester" name="semester" required min="1" max="8">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="edit_credits" class="form-label">Credits <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_credits" name="credits" required min="1" step="0.5">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function loadCourseEdit(courseId, code, name, semester, credits, description) {
    document.getElementById('edit_course_id').value = courseId;
    document.getElementById('edit_course_code').value = code;
    document.getElementById('edit_course_name').value = name;
    document.getElementById('edit_semester').value = semester;
    document.getElementById('edit_credits').value = credits;
    document.getElementById('edit_description').value = description;
}

// Add Course Form Submit
document.getElementById('addCourseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Add CSRF token
    const csrfMeta = document.querySelector('meta[name*="csrf"]');
    if (csrfMeta) {
        const csrfName = csrfMeta.getAttribute('name');
        const csrfValue = csrfMeta.getAttribute('content');
        formData.append(csrfName, csrfValue);
    }
    
    $.ajax({
        url: '<?= base_url("admin/programs/add_course/" . $program->id) ?>',
        type: 'POST',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.status === 'success') {
                location.reload();
            } else {
                alert(response.message || 'Failed to add course');
            }
        },
        error: function(xhr) {
            let errorMsg = 'An error occurred. Please try again.';
            try {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
            } catch(e) {
                if (xhr.responseText) {
                    errorMsg = xhr.responseText;
                }
            }
            alert(errorMsg);
        }
    });
});

// Edit Course Form Submit
document.getElementById('editCourseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const courseId = document.getElementById('edit_course_id').value;
    const formData = new FormData(this);
    
    // Add CSRF token
    const csrfMeta = document.querySelector('meta[name*="csrf"]');
    if (csrfMeta) {
        const csrfName = csrfMeta.getAttribute('name');
        const csrfValue = csrfMeta.getAttribute('content');
        formData.append(csrfName, csrfValue);
    }
    
    $.ajax({
        url: '<?= base_url("admin/programs/update_course") ?>/' + courseId,
        type: 'POST',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.status === 'success') {
                location.reload();
            } else {
                alert(response.message || 'Failed to update course');
            }
        },
        error: function(xhr) {
            let errorMsg = 'An error occurred. Please try again.';
            try {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
            } catch(e) {
                if (xhr.responseText) {
                    errorMsg = xhr.responseText;
                }
            }
            alert(errorMsg);
        }
    });
});

function deleteCourse(courseId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete this course. This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Build form data with CSRF token
            const formData = new FormData();
            
            // Add CSRF token from meta tag
            const csrfMeta = document.querySelector('meta[name*="csrf"]');
            if (csrfMeta) {
                const csrfName = csrfMeta.getAttribute('name');
                const csrfValue = csrfMeta.getAttribute('content');
                if (csrfName && csrfValue) {
                    formData.append(csrfName, csrfValue);
                }
            }
            
            $.ajax({
                url: '<?= base_url("admin/programs/delete_course") ?>/' + courseId,
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Course has been deleted successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error!', response.message || 'Failed to delete course', 'error');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.status, xhr.responseText);
                    let errorMsg = 'An error occurred. Please try again.';
                    try {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                    } catch(e) {
                        if (xhr.responseText) {
                            errorMsg = xhr.responseText;
                        }
                    }
                    Swal.fire('Error!', errorMsg, 'error');
                }
            });
        }
    });
}

</script>
