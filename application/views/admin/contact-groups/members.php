<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas <?= $group->icon ?> me-2" style="color: <?= $group->color ?>;"></i>
            <?= htmlspecialchars($group->name) ?>
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/contact-groups') ?>">Contact Groups</a></li>
                <li class="breadcrumb-item active">Members</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="fas fa-file-import me-2"></i>Import CSV
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
            <i class="fas fa-user-plus me-2"></i>Add Member
        </button>
    </div>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-users fa-2x me-3"></i>
                <div>
                    <div class="h3 mb-0"><?= count($members) ?></div>
                    <div>Total Members</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-envelope fa-2x me-3"></i>
                <div>
                    <div class="h3 mb-0"><?= count(array_filter($members, function($m) { return !empty($m->email) && $m->is_active; })) ?></div>
                    <div>With Email (Active)</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-phone fa-2x me-3"></i>
                <div>
                    <div class="h3 mb-0"><?= count(array_filter($members, function($m) { return !empty($m->phone) && $m->is_active; })) ?></div>
                    <div>With Phone (Active)</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Members Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>Group Members</span>
    </div>
    <div class="card-body">
        <?php if (!empty($members)): ?>
        <div class="table-responsive">
            <table class="table table-hover" id="membersTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th width="80">Status</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $member): ?>
                        <tr class="<?= $member->is_active ? '' : 'table-secondary' ?>" data-status="<?= $member->is_active ? 'active' : 'inactive' ?>">
                            <td>
                                <strong><?= htmlspecialchars($member->name) ?></strong>
                                <?php if ($member->notes): ?>
                                    <i class="fas fa-sticky-note text-warning ms-1" 
                                       title="<?= htmlspecialchars($member->notes) ?>"></i>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($member->email): ?>
                                    <a href="mailto:<?= $member->email ?>"><?= htmlspecialchars($member->email) ?></a>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($member->phone): ?>
                                    <a href="tel:<?= $member->phone ?>"><?= htmlspecialchars($member->phone) ?></a>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $member->designation ? htmlspecialchars($member->designation) : '<span class="text-muted">—</span>' ?></td>
                            <td><?= $member->department ? htmlspecialchars($member->department) : '<span class="text-muted">—</span>' ?></td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input member-status-toggle" 
                                           type="checkbox" 
                                           data-uid="<?= $member->uid ?>"
                                           <?= $member->is_active ? 'checked' : '' ?>>
                                </div>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button type="button" class="btn btn-sm btn-outline-primary edit-member-btn" 
                                            data-uid="<?= $member->uid ?>"
                                            data-bs-toggle="modal" data-bs-target="#editMemberModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="confirmDelete('<?= base_url('admin/contact-groups/delete-member/' . $member->uid) ?>', 'member')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-user-slash fa-4x text-muted mb-4"></i>
            <h4>No Members Yet</h4>
            <p class="text-muted">No members in this group yet.</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                <i class="fas fa-user-plus me-2"></i>Add First Member
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open('admin/contact-groups/add-member/' . $group->uid) ?>
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Add Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Designation</label>
                                <input type="text" name="designation" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Department</label>
                                <input type="text" name="department" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Member</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Edit Member Modal -->
<div class="modal fade" id="editMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editMemberForm" method="post">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="editEmail" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" id="editPhone" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Designation</label>
                                <input type="text" name="designation" id="editDesignation" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Department</label>
                                <input type="text" name="department" id="editDepartment" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" id="editNotes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import CSV Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open_multipart('admin/contact-groups/import-members/' . $group->uid) ?>
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-file-import me-2"></i>Import from CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>CSV Format:</strong> Your CSV should have headers including: 
                        <code>name</code>, <code>email</code>, <code>phone</code>, <code>designation</code>, <code>department</code>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select CSV File</label>
                        <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if (!empty($members)): ?>
    // Initialize DataTable
    const table = $('#membersTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [5, 6] }
        ]
    });

    // Edit member button
    document.querySelectorAll('.edit-member-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const memberUid = this.dataset.uid;
            
            fetch('<?= base_url('admin/contact-groups/get-member-json/') ?>' + memberUid)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editName').value = data.name || '';
                    document.getElementById('editEmail').value = data.email || '';
                    document.getElementById('editPhone').value = data.phone || '';
                    document.getElementById('editDesignation').value = data.designation || '';
                    document.getElementById('editDepartment').value = data.department || '';
                    document.getElementById('editNotes').value = data.notes || '';
                    document.getElementById('editMemberForm').action = '<?= base_url('admin/contact-groups/edit-member/') ?>' + memberUid;
                });
        });
    });

    // Member status toggle
    document.querySelectorAll('.member-status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const memberUid = this.dataset.uid;
            const checkbox = this;
            
            fetch('<?= base_url('admin/contact-groups/toggle-member-status/') ?>' + memberUid, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    checkbox.checked = !checkbox.checked;
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                checkbox.checked = !checkbox.checked;
                Swal.fire('Error', 'An error occurred. Please try again.', 'error');
            });
        });
    });
    <?php endif; ?>
});
</script>
