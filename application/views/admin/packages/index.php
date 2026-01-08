<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Packages</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Packages</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/packages/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Package
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <?php
    $total = count($packages);
    $active = count(array_filter($packages, function($p) { return $p->is_active; }));
    $featured = count(array_filter($packages, function($p) { return $p->is_featured; }));
    $inactive = $total - $active;
    ?>
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-box"></i></div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Packages</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value"><?= $active ?></div>
            <div class="stat-label">Active</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-star"></i></div>
            <div class="stat-value"><?= $featured ?></div>
            <div class="stat-label">Featured</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card danger">
            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
            <div class="stat-value"><?= $inactive ?></div>
            <div class="stat-label">Inactive</div>
        </div>
    </div>
</div>

<!-- Packages Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Packages</span>
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-secondary filter-btn active" data-filter="all">All</button>
            <button type="button" class="btn btn-outline-success filter-btn" data-filter="active">Active</button>
            <button type="button" class="btn btn-outline-warning filter-btn" data-filter="featured">Featured</button>
            <button type="button" class="btn btn-outline-danger filter-btn" data-filter="inactive">Inactive</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="packagesTable">
                <thead>
                    <tr>
                        <th width="60">Image</th>
                        <th>Package Name</th>
                        <th>Category</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th width="100">Featured</th>
                        <th width="100">Status</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($packages)): ?>
                        <?php foreach ($packages as $package): ?>
                            <tr data-status="<?= $package->is_active ? 'active' : 'inactive' ?>" 
                                data-featured="<?= $package->is_featured ? 'featured' : '' ?>">
                                <td>
                                    <?php if (!empty($package->image)): ?>
                                        <img src="<?= base_url('assets/img/packages/' . $package->image) ?>" 
                                             alt="<?= htmlspecialchars($package->name) ?>" 
                                             class="img-thumbnail" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-secondary d-flex align-items-center justify-content-center text-white" 
                                             style="width: 50px; height: 50px; border-radius: 5px;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($package->name) ?></strong>
                                    <br>
                                    <small class="text-muted"><?= htmlspecialchars($package->slug) ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= isset($categories[$package->category]) ? $categories[$package->category] : ucfirst($package->category) ?>
                                    </span>
                                </td>
                                <td><?= $package->duration_days ?> days</td>
                                <td>
                                    <?php if ($package->base_price): ?>
                                        <strong class="text-success">$<?= number_format($package->base_price) ?></strong>
                                    <?php else: ?>
                                        <span class="text-muted">Not set</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input featured-toggle" 
                                               type="checkbox" 
                                               data-uid="<?= htmlspecialchars($package->uid) ?>"
                                               data-id="<?= $package->id ?>"
                                               <?= $package->is_featured ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($package->is_active): ?>
                                        <span class="status-badge active">Active</span>
                                    <?php else: ?>
                                        <span class="status-badge inactive">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('admin/packages/edit/' . htmlspecialchars($package->uid)) ?>" 
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('safari/' . htmlspecialchars($package->slug)) ?>" 
                                           class="btn btn-sm btn-outline-info" title="View" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete('<?= base_url('admin/packages/delete/' . htmlspecialchars($package->uid)) ?>', 'package')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-box-open fa-3x mb-3"></i>
                                    <p>No packages found. <a href="<?= base_url('admin/packages/create') ?>">Create your first package</a></p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    const table = $('#packagesTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'desc']],
        columnDefs: [
            { orderable: false, targets: [0, 5, 7] }
        ]
    });

    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            if (filter === 'all') {
                table.search('').columns().search('').draw();
                document.querySelectorAll('#packagesTable tbody tr').forEach(row => {
                    row.style.display = '';
                });
            } else {
                document.querySelectorAll('#packagesTable tbody tr').forEach(row => {
                    const status = row.dataset.status;
                    const featured = row.dataset.featured;
                    
                    if (filter === 'active' && status === 'active') {
                        row.style.display = '';
                    } else if (filter === 'inactive' && status === 'inactive') {
                        row.style.display = '';
                    } else if (filter === 'featured' && featured === 'featured') {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });
    });

    // Featured toggle
    document.querySelectorAll('.featured-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const packageUid = this.dataset.uid;
            const packageId = this.dataset.id;
            const checkbox = this;
            
            fetch('<?= base_url('admin/packages/toggle_featured/') ?>' + packageUid, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
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
                    checkbox.closest('tr').dataset.featured = data.is_featured ? 'featured' : '';
                } else {
                    checkbox.checked = !checkbox.checked;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                checkbox.checked = !checkbox.checked;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again.'
                });
            });
        });
    });
});
</script>
