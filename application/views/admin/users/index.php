<!-- Users Management -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Users Management</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Display Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="card-text text-muted mb-2">Total Users</h6>
                                <h5 class="card-title mb-0"><?= isset($statistics) ? $statistics->total : 0 ?></h5>
                            </div>
                            <div class="text-primary" style="font-size: 2rem;">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="card-text text-muted mb-2">Active Users</h6>
                                <h5 class="card-title mb-0"><?= isset($statistics) ? $statistics->active : 0 ?></h5>
                            </div>
                            <div class="text-success" style="font-size: 2rem;">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="card-text text-muted mb-2">Inactive Users</h6>
                                <h5 class="card-title mb-0"><?= isset($statistics) ? $statistics->inactive : 0 ?></h5>
                            </div>
                            <div class="text-warning" style="font-size: 2rem;">
                                <i class="fas fa-user-slash"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="card-text text-muted mb-2">Administrators</h6>
                                <h5 class="card-title mb-0">
                                    <?php 
                                    $admin_count = 0;
                                    if (isset($statistics->by_role)) {
                                        foreach ($statistics->by_role as $role) {
                                            if ($role->role === 'Administrator') {
                                                $admin_count = $role->count;
                                                break;
                                            }
                                        }
                                    }
                                    echo $admin_count;
                                    ?>
                                </h5>
                            </div>
                            <div class="text-danger" style="font-size: 2rem;">
                                <i class="fas fa-user-shield"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Users</h5>
                <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add User
                </a>
            </div>
            <div class="card-body">
                <!-- Search and Filters -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <form method="GET" class="d-flex gap-2">
                            <input type="text" name="keyword" class="form-control form-control-sm" 
                                   placeholder="Search by name, email, or username..." 
                                   value="<?= isset($keyword) ? $keyword : '' ?>">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <?php if ($keyword || $status_filter || $role_filter): ?>
                                <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select form-select-sm" onchange="filterByStatus(this.value)">
                            <option value="">All Statuses</option>
                            <option value="active" <?= (isset($status_filter) && $status_filter === 'active') ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= (isset($status_filter) && $status_filter === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Table -->
                <?php if (!empty($users)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($user->full_name) ?></strong>
                                </td>
                                <td>
                                    <small><?= htmlspecialchars($user->email) ?></small>
                                </td>
                                <td>
                                    <code><?= htmlspecialchars($user->username) ?></code>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= htmlspecialchars($user->role_name ?? 'Unknown') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user->status === 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small>
                                        <?= $user->last_login ? date('M d, Y H:i', strtotime($user->last_login)) : 'Never' ?>
                                    </small>
                                </td>
                                <td>
                                    <small><?= date('M d, Y', strtotime($user->created_at)) ?></small>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/users/view/' . $user->uid) ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/users/edit/' . $user->uid) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger" 
                                       onclick="confirmDelete('<?= base_url('admin/users/delete/' . $user->uid) ?>', 'user')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> No users found.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function filterByStatus(status) {
    const url = new URL(window.location.href);
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    window.location.href = url.toString();
}
</script>
