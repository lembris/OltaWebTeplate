<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Itinerary</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/itineraries') ?>">Itineraries</a></li>
                <li class="breadcrumb-item active"><?= html_escape($package->name) ?></li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/itineraries') ?>" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
        <a href="<?= base_url('admin/itineraries/create/' . $package->uid) ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Day
        </a>
    </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Package Info -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="mb-1"><?= html_escape($package->name) ?></h4>
                <p class="text-muted mb-0">
                    <span class="me-3"><i class="fas fa-calendar-day me-1"></i>Duration: <?= $package->duration_days ?> Days</span>
                    <span class="me-3"><i class="fas fa-list-ol me-1"></i>Days Added: <?= count($days) ?></span>
                    <?php if ($package->is_active): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Inactive</span>
                    <?php endif; ?>
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <?php 
                $day_count = count($days);
                $duration = intval($package->duration_days);
                $remaining = $duration - $day_count;
                ?>
                <?php if ($remaining > 0): ?>
                    <span class="text-warning">
                        <i class="fas fa-exclamation-triangle me-1"></i><?= $remaining ?> days remaining
                    </span>
                <?php elseif ($remaining == 0): ?>
                    <span class="text-success">
                        <i class="fas fa-check-circle me-1"></i>Itinerary complete
                    </span>
                <?php else: ?>
                    <span class="text-info">
                        <i class="fas fa-info-circle me-1"></i><?= abs($remaining) ?> extra days
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-route me-2"></i>Itinerary Days</span>
        <small class="text-muted"><i class="fas fa-grip-vertical me-1"></i>Drag to reorder</small>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($days)): ?>
            <ul class="list-group list-group-flush" id="sortableDays">
                <?php foreach ($days as $day): ?>
                    <li class="list-group-item itinerary-day-item" data-id="<?= $day->uid ?>">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="drag-handle" style="cursor: grab; padding: 10px;">
                                    <i class="fas fa-grip-vertical text-muted"></i>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="day-number-badge">
                                    Day <?= $day->day_number ?>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="mb-1"><?= html_escape($day->title) ?></h6>
                                <div class="text-muted small">
                                    <?php if (!empty($day->accommodation)): ?>
                                        <span class="me-3"><i class="fas fa-bed me-1"></i><?= html_escape($day->accommodation) ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($day->meals)): ?>
                                        <span class="me-3"><i class="fas fa-utensils me-1"></i><?= html_escape($day->meals) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="action-btns">
                                    <a href="<?= base_url('admin/itineraries/edit/' . $day->uid) ?>" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-delete-day" 
                                            data-id="<?= $day->uid ?>" 
                                            data-title="<?= html_escape($day->title) ?>"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-route fa-4x mb-3 opacity-50"></i>
                    <h5>No itinerary days yet</h5>
                    <p>Start building the itinerary by adding the first day.</p>
                    <a href="<?= base_url('admin/itineraries/create/' . $package->uid) ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add First Day
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.day-number-badge {
    background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
    color: #fff;
    font-weight: 600;
    padding: 8px 15px;
    border-radius: 8px;
    font-size: 0.85rem;
    min-width: 80px;
    text-align: center;
}

.itinerary-day-item {
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
}

.itinerary-day-item:hover {
    background: #f8f9fa;
    border-left-color: var(--accent-color);
}

.itinerary-day-item.sortable-ghost {
    opacity: 0.4;
    background: #e9ecef;
}

.itinerary-day-item.sortable-chosen {
    background: #fff3cd;
}

.drag-handle:hover {
    color: var(--accent-color) !important;
}
</style>

<!-- Sortable.js -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function() {
    var csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    var csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    
    // Initialize sortable
    var sortableList = document.getElementById('sortableDays');
    if (sortableList) {
        new Sortable(sortableList, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                var order = [];
                $('#sortableDays .itinerary-day-item').each(function() {
                    order.push($(this).data('id'));
                });
                
                var postData = {
                    package_id: <?= $package->id ?>,
                    order: order
                };
                postData[csrfName] = csrfHash;
                
                $.ajax({
                    url: '<?= base_url('admin/itineraries/reorder') ?>',
                    type: 'POST',
                    data: postData,
                    dataType: 'json',
                    success: function(response) {
                        csrfHash = response.csrf_hash || csrfHash;
                        if (response.success) {
                            $('#sortableDays .itinerary-day-item').each(function(index) {
                                $(this).find('.day-number-badge').text('Day ' + index);
                            });
                            showToast('success', response.message);
                        } else {
                            showToast('error', response.message);
                            location.reload();
                        }
                    },
                    error: function() {
                        showToast('error', 'Failed to update order');
                        location.reload();
                    }
                });
            }
        });
    }
    
    // Delete day
    $('.btn-delete-day').on('click', function() {
        var id = $(this).data('id');
        var title = $(this).data('title');
        var $item = $(this).closest('.itinerary-day-item');
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete "' + title + '". This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                var postData = {};
                postData[csrfName] = csrfHash;
                
                $.ajax({
                    url: '<?= base_url('admin/itineraries/delete/') ?>' + id,
                    type: 'POST',
                    data: postData,
                    dataType: 'json',
                    success: function(response) {
                        csrfHash = response.csrf_hash || csrfHash;
                        if (response.success) {
                            $item.fadeOut(300, function() {
                                $(this).remove();
                                $('#sortableDays .itinerary-day-item').each(function(index) {
                                    $(this).find('.day-number-badge').text('Day ' + index);
                                });
                                if ($('#sortableDays .itinerary-day-item').length === 0) {
                                    location.reload();
                                }
                            });
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to delete day'
                        });
                    }
                });
            }
        });
    });
    
    function showToast(type, message) {
        var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        var $toast = $('<div class="alert ' + alertClass + ' alert-dismissible fade show position-fixed" style="top: 80px; right: 20px; z-index: 9999; min-width: 300px;">' +
            '<i class="fas ' + icon + ' me-2"></i>' + message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
            '</div>');
        $('body').append($toast);
        setTimeout(function() {
            $toast.fadeOut(300, function() { $(this).remove(); });
        }, 3000);
    }
});
</script>
