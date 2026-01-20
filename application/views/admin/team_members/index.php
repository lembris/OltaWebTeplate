<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Team Members</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Team Members</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/team_members/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Member
        </a>
    </div>
</div>

<!-- Active Theme Info -->
<div class="alert alert-info d-flex align-items-center mb-4" role="alert">
    <i class="fas fa-users me-3 fa-lg"></i>
    <div>
        <strong>Active Theme:</strong> <span class="badge bg-primary fs-6 ms-2"><?= ucfirst($active_template) ?></span>
        <span class="ms-3 text-muted">Showing team members for "<?= ucfirst($active_template) ?>" theme and universal members (template = "all")</span>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <?php
    $total = count($team_members);
    $active_count = count(array_filter($team_members, function($m) { return $m->status == 'active'; }));
    $featured_count = count(array_filter($team_members, function($m) { return $m->is_featured; }));
    ?>
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Members</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value"><?= $active_count ?></div>
            <div class="stat-label">Active</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-star"></i></div>
            <div class="stat-value"><?= $featured_count ?></div>
            <div class="stat-label">Featured</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-user-plus"></i></div>
            <div class="stat-value"><?= $total - $active_count ?></div>
            <div class="stat-label">Inactive</div>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Team Members Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>All Team Members</span>
        <form method="GET" class="d-flex" style="gap: 10px;">
            <input type="text" name="keyword" class="form-control form-control-sm" 
                   placeholder="Search members..." value="<?= htmlspecialchars($keyword ?? '') ?>" style="width: 200px;">
            <button type="submit" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-search"></i>
            </button>
            <?php if (!empty($keyword)): ?>
                <a href="<?= base_url('admin/team_members') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-times"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="60">Photo</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th width="80">Template</th>
                        <th width="80">Featured</th>
                        <th width="80">Status</th>
                        <th width="100">Order</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($team_members)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <p class="mb-0">No team members found.</p>
                                    <a href="<?= base_url('admin/team_members/create') ?>">Add your first team member</a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($team_members as $member): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($member->photo)): ?>
                                        <img src="<?= base_url('assets/images/team/' . $member->photo) ?>" 
                                             alt="<?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?>"
                                             class="img-thumbnail rounded-circle"
                                             style="width: 45px; height: 45px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 45px; height: 45px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($member->first_name . ' ' . $member->last_name) ?></strong>
                                    <?php if ($member->is_featured): ?>
                                        <span class="badge bg-warning text-dark ms-1">Featured</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($member->title) ?></td>
                                <td>
                                    <span class="badge bg-<?= $member->member_type == 'Leadership' ? 'primary' : 'secondary' ?>">
                                        <?= htmlspecialchars($member->member_type ?: 'General') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $member->template == 'all' ? 'bg-info' : 'bg-secondary' ?>">
                                        <?= htmlspecialchars($member->template ?: 'all') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($member->is_featured): ?>
                                        <i class="fas fa-star text-warning"></i>
                                    <?php else: ?>
                                        <i class="fas fa-star text-muted" style="opacity: 0.3;"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?= $member->status == 'active' ? 'bg-success' : 'bg-danger' ?>">
                                        <?= htmlspecialchars(ucfirst($member->status)) ?>
                                    </span>
                                </td>
                                <td><?= $member->display_order ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('admin/team_members/edit/' . $member->uid) ?>" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete('<?= base_url('admin/team_members/delete/' . $member->uid) ?>', 'team member')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
