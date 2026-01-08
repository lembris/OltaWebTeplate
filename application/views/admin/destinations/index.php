<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Destinations</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Destinations</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/destinations/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Destination
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <?php
    $total = count($destinations ?? []);
    $active = count(array_filter($destinations ?? [], function($d) { return $d->is_active; }));
    $inactive = $total - $active;
    ?>
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Destinations</div>
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
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-ban"></i></div>
            <div class="stat-value"><?= $inactive ?></div>
            <div class="stat-label">Inactive</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-globe"></i></div>
            <div class="stat-value"><?php 
                if (!empty($destinations)) {
                    $countries = array_unique(array_column($destinations, 'country'));
                    echo count($countries);
                } else {
                    echo '0';
                }
            ?></div>
            <div class="stat-label">Countries</div>
        </div>
    </div>
</div>

<!-- Destinations Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Destinations</span>
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-secondary filter-btn active" data-filter="all">All</button>
            <button type="button" class="btn btn-outline-success filter-btn" data-filter="active">Active</button>
            <button type="button" class="btn btn-outline-warning filter-btn" data-filter="inactive">Inactive</button>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Search Box -->
        <form method="GET" class="mb-3 d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search destinations..." 
                   value="<?= isset($search_keyword) ? htmlspecialchars($search_keyword) : '' ?>">
            <button type="submit" class="btn btn-outline-primary">
                <i class="fas fa-search"></i> Search
            </button>
            <?php if (isset($search_keyword)): ?>
            <a href="<?= base_url('admin/destinations') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Clear
            </a>
            <?php endif; ?>
        </form>

        <div class="table-responsive">
            <table class="table table-hover" id="destinationsTable">
                <thead>
                    <tr>
                        <th width="60">Image</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Best Time</th>
                        <th width="100">Active</th>
                        <th width="120">Created</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($destinations)): ?>
                        <?php foreach ($destinations as $destination): ?>
                            <tr data-status="<?= $destination->is_active ? 'active' : 'inactive' ?>">
                                <td>
                                    <?php if (!empty($destination->featured_image)): ?>
                                        <img src="<?= base_url('assets/img/destinations/' . $destination->featured_image) ?>" 
                                             alt="<?= htmlspecialchars($destination->name) ?>" 
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
                                    <strong><?= htmlspecialchars($destination->name) ?></strong>
                                    <?php if (!empty($destination->seo_title)): ?>
                                        <br>
                                        <small class="text-muted"><?= htmlspecialchars(substr($destination->seo_title, 0, 50)) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= htmlspecialchars($destination->country) ?></span>
                                </td>
                                <td>
                                    <?= htmlspecialchars($destination->best_time ?? '-') ?>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input active-toggle" 
                                               type="checkbox" 
                                               data-uid="<?= $destination->uid ?>"
                                               <?= $destination->is_active ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <td>
                                    <?= isset($destination->created_at) ? date('M d, Y', strtotime($destination->created_at)) : 'N/A' ?>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('admin/destinations/edit/' . $destination->uid) ?>" 
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete('<?= base_url('admin/destinations/delete/' . $destination->uid) ?>', 'destination')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                                    <p>No destinations found. <a href="<?= base_url('admin/destinations/create') ?>">Create your first destination</a></p>
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
    const table = $('#destinationsTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[5, 'desc']],
        columnDefs: [
            { orderable: false, targets: [0, 4, 6] }
        ]
    });

    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            if (filter === 'all') {
                document.querySelectorAll('#destinationsTable tbody tr').forEach(row => {
                    row.style.display = '';
                });
            } else {
                document.querySelectorAll('#destinationsTable tbody tr').forEach(row => {
                    const status = row.dataset.status;
                    
                    if (filter === status) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });
    });

    // Active toggle
    document.querySelectorAll('.active-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const destinationUid = this.dataset.uid;
            const checkbox = this;
            
            fetch('<?= base_url('admin/destinations/toggle_active/') ?>' + destinationUid, {
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
                    checkbox.closest('tr').dataset.status = data.is_active ? 'active' : 'inactive';
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
