<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Gallery</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Gallery</li>
            </ol>
        </nav>
        <div class="mt-2">
            <strong>Active Theme:</strong> <span class="badge bg-primary fs-6 ms-2"><?= ucfirst($active_template) ?></span>
            <small class="text-muted ms-2">Showing gallery images for this theme</small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/gallery/bulk_upload') ?>" class="btn btn-outline-primary">
            <i class="fas fa-upload me-2"></i>Bulk Upload
        </a>
        <a href="<?= base_url('admin/gallery/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Image
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <?php
    $total = count($images ?? []);
    $active = count(array_filter($images ?? [], function($i) { return $i->is_active; }));
    $featured = count(array_filter($images ?? [], function($i) { return $i->is_featured; }));
    $inactive = $total - $active;
    ?>
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="fas fa-images"></i></div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Images</div>
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
            <div class="stat-icon"><i class="fas fa-star"></i></div>
            <div class="stat-value"><?= $featured ?></div>
            <div class="stat-label">Featured</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent">
            <div class="stat-icon"><i class="fas fa-folder"></i></div>
            <div class="stat-value"><?= count($categories) ?></div>
            <div class="stat-label">Categories</div>
        </div>
    </div>
</div>

<!-- Gallery Grid -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="fas fa-th me-2"></i>Gallery Images</span>
        <div class="d-flex gap-2 flex-wrap">
            <!-- Category Filter -->
            <select class="form-select form-select-sm" id="categoryFilter" style="width: auto;">
                <option value="all" <?= !isset($active_category) ? 'selected' : '' ?>>All Categories</option>
                <?php foreach ($categories as $key => $label): ?>
                <option value="<?= $key ?>" <?= isset($active_category) && $active_category === $key ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
                <?php endforeach; ?>
            </select>
            
            <!-- Status Filter -->
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary filter-btn active" data-filter="all">All</button>
                <button type="button" class="btn btn-outline-success filter-btn" data-filter="active">Active</button>
                <button type="button" class="btn btn-outline-warning filter-btn" data-filter="featured">Featured</button>
            </div>
            
            <!-- View Toggle -->
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary view-btn" data-view="grid" title="Grid View">
                    <i class="fas fa-th"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary view-btn" data-view="list" title="List View">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body" id="galleryContainer">
        <!-- Search Box -->
        <form method="GET" class="mb-4 d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search images..." 
                   value="<?= isset($search_keyword) ? htmlspecialchars($search_keyword) : '' ?>">
            <button type="submit" class="btn btn-outline-primary">
                <i class="fas fa-search"></i> Search
            </button>
            <?php if (isset($search_keyword) || isset($active_category)): ?>
            <a href="<?= base_url('admin/gallery') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Clear
            </a>
            <?php endif; ?>
        </form>

        <?php if (!empty($images)): ?>
        <!-- Reorder Notice -->
        <div class="reorder-notice" id="reorderNotice">
            <span><i class="fas fa-arrows-alt me-2"></i>Drag images to reorder. Changes are saved automatically.</span>
        </div>
        
        <!-- Gallery Grid View -->
        <div class="row g-4" id="galleryGrid">
            <?php foreach ($images as $image): ?>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 gallery-item" 
                 data-uid="<?= $image->uid ?>"
                 data-status="<?= $image->is_active ? 'active' : 'inactive' ?>"
                 data-featured="<?= $image->is_featured ? 'yes' : 'no' ?>"
                 data-category="<?= htmlspecialchars($image->category) ?>">
                <div class="gallery-card <?= !$image->is_active ? 'inactive' : '' ?>">
                    <div class="gallery-image">
                        <span class="drag-handle" title="Drag to reorder">
                            <i class="fas fa-grip-vertical"></i>
                        </span>
                        <img src="<?= base_url($image->src) ?>" 
                             alt="<?= htmlspecialchars($image->title) ?>"
                             loading="lazy">
                        
                        <!-- Badges -->
                        <div class="gallery-badges">
                            <?php if ($image->is_featured): ?>
                            <span class="badge bg-warning"><i class="fas fa-star"></i></span>
                            <?php endif; ?>
                            <?php if (!$image->is_active): ?>
                            <span class="badge bg-secondary">Hidden</span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Overlay Actions -->
                        <div class="gallery-overlay">
                            <div class="gallery-actions">
                                <a href="<?= base_url($image->src) ?>" 
                                   class="btn btn-sm btn-light" 
                                   target="_blank" 
                                   title="View Full">
                                    <i class="fas fa-expand"></i>
                                </a>
                                <a href="<?= base_url('admin/gallery/edit/' . $image->uid) ?>" 
                                   class="btn btn-sm btn-primary" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-danger" 
                                        onclick="confirmDelete('<?= base_url('admin/gallery/delete/' . $image->uid) ?>', 'image')"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="gallery-info">
                        <h6 class="gallery-title" title="<?= htmlspecialchars($image->title) ?>">
                            <?= htmlspecialchars(character_limiter($image->title, 25)) ?>
                        </h6>
                        <div class="gallery-meta">
                            <span class="badge bg-info"><?= htmlspecialchars(ucfirst($image->category)) ?></span>
                            <div class="gallery-toggles">
                                <div class="form-check form-switch" title="Active">
                                    <input class="form-check-input active-toggle" 
                                           type="checkbox" 
                                           data-uid="<?= $image->uid ?>"
                                           <?= $image->is_active ? 'checked' : '' ?>>
                                </div>
                                <div class="form-check form-switch" title="Featured">
                                    <input class="form-check-input featured-toggle text-warning" 
                                           type="checkbox" 
                                           data-uid="<?= $image->uid ?>"
                                           <?= $image->is_featured ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <div class="text-muted">
                <i class="fas fa-images fa-4x mb-3"></i>
                <h4>No images found for theme "<?= ucfirst($active_template) ?>"</h4>
                <p>Start by uploading some images to your gallery for this theme.</p>
                <a href="<?= base_url('admin/gallery/create') ?>" class="btn btn-primary mt-2">
                    <i class="fas fa-plus me-2"></i>Add First Image
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.gallery-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.gallery-card.inactive {
    opacity: 0.6;
}

.gallery-image {
    position: relative;
    height: 150px;
    overflow: hidden;
}

.gallery-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-card:hover .gallery-image img {
    transform: scale(1.05);
}

.gallery-badges {
    position: absolute;
    top: 8px;
    left: 8px;
    display: flex;
    gap: 5px;
    z-index: 2;
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.gallery-actions {
    display: flex;
    gap: 8px;
}

.gallery-info {
    padding: 12px;
}

.gallery-title {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.gallery-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.gallery-toggles {
    display: flex;
    gap: 10px;
}

.gallery-toggles .form-check {
    margin: 0;
    padding: 0;
}

.gallery-toggles .form-check-input {
    margin: 0;
    cursor: pointer;
}

.featured-toggle:checked {
    background-color: #ffc107;
    border-color: #ffc107;
}

/* Drag and Drop Styles */
.gallery-item {
    cursor: grab;
}

.gallery-item:active {
    cursor: grabbing;
}

.gallery-item.sortable-ghost {
    opacity: 0.4;
}

.gallery-item.sortable-chosen {
    opacity: 0.9;
}

.gallery-item.sortable-drag {
    opacity: 1;
}

.drag-handle {
    position: absolute;
    top: 8px;
    right: 8px;
    z-index: 3;
    background: rgba(255,255,255,0.9);
    border-radius: 4px;
    padding: 4px 8px;
    cursor: grab;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-card:hover .drag-handle {
    opacity: 1;
}

.drag-handle:active {
    cursor: grabbing;
}

.reorder-notice {
    display: none;
    background: #d4edda;
    border: 1px solid #c3e6cb;
    border-radius: 6px;
    padding: 10px 15px;
    margin-bottom: 15px;
    color: #155724;
}

.reorder-notice.show {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* List View Styles */
#galleryContainer.list-view #galleryGrid {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

#galleryContainer.list-view .gallery-item {
    width: 100%;
    max-width: 100%;
    flex: 0 0 100%;
}

#galleryContainer.list-view .gallery-card {
    display: flex;
    flex-direction: row;
    align-items: center;
}

#galleryContainer.list-view .gallery-image {
    width: 120px;
    min-width: 120px;
    height: 80px;
    border-radius: 8px 0 0 8px;
}

#galleryContainer.list-view .gallery-info {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
}

#galleryContainer.list-view .gallery-title {
    margin-bottom: 0;
    font-size: 1rem;
}

#galleryContainer.list-view .gallery-meta {
    gap: 20px;
}

#galleryContainer.list-view .gallery-overlay {
    border-radius: 8px 0 0 8px;
}

#galleryContainer.list-view .drag-handle {
    position: relative;
    top: auto;
    right: auto;
    opacity: 1;
    margin-right: 15px;
}

.view-btn.active {
    background-color: var(--primary-color, #0d6efd);
    border-color: var(--primary-color, #0d6efd);
    color: #fff;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View Toggle (Grid/List)
    const galleryContainer = document.getElementById('galleryContainer');
    const viewButtons = document.querySelectorAll('.view-btn');
    const storageKey = 'gallery_view_preference';
    
    function setView(view) {
        if (galleryContainer) {
            if (view === 'list') {
                galleryContainer.classList.add('list-view');
            } else {
                galleryContainer.classList.remove('list-view');
            }
        }
        
        viewButtons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.view === view);
        });
        
        localStorage.setItem(storageKey, view);
    }
    
    // Load saved preference or default to grid
    const savedView = localStorage.getItem(storageKey) || 'grid';
    setView(savedView);
    
    // Handle view button clicks
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            setView(this.dataset.view);
        });
    });
    
    // Initialize Sortable for drag-and-drop reordering
    const galleryGrid = document.getElementById('galleryGrid');
    if (galleryGrid) {
        const sortable = new Sortable(galleryGrid, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onStart: function() {
                document.getElementById('reorderNotice').classList.add('show');
            },
            onEnd: function(evt) {
                // Build the new order array
                const items = galleryGrid.querySelectorAll('.gallery-item');
                const orders = [];
                items.forEach((item, index) => {
                    orders.push({
                        uid: item.dataset.uid,
                        position: index + 1
                    });
                });
                
                // Send AJAX request to update order
                fetch('<?= base_url('admin/gallery/update_order') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: '<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>&orders=' + encodeURIComponent(JSON.stringify(orders))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('success', 'Order updated successfully');
                    } else {
                        showToast('error', data.message || 'Failed to update order');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'An error occurred while saving order');
                });
            }
        });
    }
    
    // Category filter
    document.getElementById('categoryFilter').addEventListener('change', function() {
        const category = this.value;
        if (category === 'all') {
            window.location.href = '<?= base_url('admin/gallery') ?>';
        } else {
            window.location.href = '<?= base_url('admin/gallery') ?>?category=' + category;
        }
    });

    // Status filter buttons
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            document.querySelectorAll('.gallery-item').forEach(item => {
                const status = item.dataset.status;
                const featured = item.dataset.featured;
                
                if (filter === 'all') {
                    item.style.display = '';
                } else if (filter === 'active') {
                    item.style.display = status === 'active' ? '' : 'none';
                } else if (filter === 'featured') {
                    item.style.display = featured === 'yes' ? '' : 'none';
                }
            });
        });
    });

    // Active toggle
    document.querySelectorAll('.active-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const uid = this.dataset.uid;
            const checkbox = this;
            const card = checkbox.closest('.gallery-card');
            
            fetch('<?= base_url('admin/gallery/toggle_active/') ?>' + uid, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.is_active) {
                        card.classList.remove('inactive');
                    } else {
                        card.classList.add('inactive');
                    }
                    checkbox.closest('.gallery-item').dataset.status = data.is_active ? 'active' : 'inactive';
                    showToast('success', data.message);
                } else {
                    checkbox.checked = !checkbox.checked;
                    showToast('error', data.message);
                }
            })
            .catch(error => {
                checkbox.checked = !checkbox.checked;
                showToast('error', 'An error occurred');
            });
        });
    });

    // Featured toggle
    document.querySelectorAll('.featured-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const uid = this.dataset.uid;
            const checkbox = this;
            
            fetch('<?= base_url('admin/gallery/toggle_featured/') ?>' + uid, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    checkbox.closest('.gallery-item').dataset.featured = data.is_featured ? 'yes' : 'no';
                    showToast('success', data.message);
                    // Update badge
                    const badges = checkbox.closest('.gallery-card').querySelector('.gallery-badges');
                    const starBadge = badges.querySelector('.bg-warning');
                    if (data.is_featured && !starBadge) {
                        badges.innerHTML = '<span class="badge bg-warning"><i class="fas fa-star"></i></span>' + badges.innerHTML;
                    } else if (!data.is_featured && starBadge) {
                        starBadge.remove();
                    }
                } else {
                    checkbox.checked = !checkbox.checked;
                    showToast('error', data.message);
                }
            })
            .catch(error => {
                checkbox.checked = !checkbox.checked;
                showToast('error', 'An error occurred');
            });
        });
    });

    function showToast(type, message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: type === 'success' ? 'Updated!' : 'Error',
                text: message,
                timer: 1500,
                showConfirmButton: false
            });
        }
    }
});
</script>
