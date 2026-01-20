<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Team Member Details</h5>
        <div>
            <a href="<?php echo base_url('admin/team_members/edit/' . $team_member->uid); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="<?php echo base_url('admin/team_members'); ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                <?php if ($team_member->photo): ?>
                    <img src="<?php echo base_url('assets/images/team/' . $team_member->photo); ?>" 
                         alt="<?php echo htmlspecialchars($team_member->first_name . ' ' . $team_member->last_name); ?>"
                         class="img-fluid rounded" style="max-width: 250px; max-height: 250px; object-fit: cover;">
                <?php else: ?>
                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 250px; height: 250px;">
                        <i class="fas fa-user fa-5x"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <h3><?php echo htmlspecialchars($team_member->first_name . ' ' . $team_member->last_name); ?></h3>
                
                <p class="lead text-muted"><?php echo htmlspecialchars($team_member->title); ?></p>
                
                <div class="mb-3">
                    <?php if ($team_member->is_featured): ?>
                        <span class="badge bg-warning text-dark mb-2">Featured Member</span>
                    <?php endif; ?>
                    <span class="badge <?php echo $team_member->status == 'active' ? 'bg-success' : 'bg-danger'; ?> mb-2">
                        <?php echo htmlspecialchars(ucfirst($team_member->status)); ?>
                    </span>
                    <span class="badge bg-info mb-2">
                        <?php echo htmlspecialchars($team_member->template ?: 'All Templates'); ?>
                    </span>
                </div>

                <?php if ($team_member->member_type): ?>
                    <p><strong>Type:</strong> <?php echo htmlspecialchars($team_member->member_type); ?></p>
                <?php endif; ?>

                <?php if ($team_member->specialization): ?>
                    <p><strong>Specialization:</strong> <?php echo htmlspecialchars($team_member->specialization); ?></p>
                <?php endif; ?>

                <?php if ($team_member->email): ?>
                    <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($team_member->email); ?>"><?php echo htmlspecialchars($team_member->email); ?></a></p>
                <?php endif; ?>

                <?php if ($team_member->phone): ?>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($team_member->phone); ?></p>
                <?php endif; ?>

                <?php if ($team_member->bio): ?>
                    <hr>
                    <h5>Bio</h5>
                    <p><?php echo nl2br(htmlspecialchars($team_member->bio)); ?></p>
                <?php endif; ?>

                <hr>
                <p class="text-muted small mb-0">
                    <strong>Created:</strong> <?php echo date('M d, Y H:i', strtotime($team_member->created_at)); ?>
                    | <strong>Last Updated:</strong> <?php echo date('M d, Y H:i', strtotime($team_member->updated_at)); ?>
                    | <strong>Display Order:</strong> <?php echo $team_member->display_order; ?>
                </p>
            </div>
        </div>
    </div>
</div>
