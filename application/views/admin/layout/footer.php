    </div><!-- End .admin-content -->
    
    <!-- Admin Footer -->
    <footer class="admin-footer text-center py-3 bg-white border-top">
        <p class="mb-0 text-muted small">
            &copy; <?= date('Y') ?> <?= isset($site_name) ? $site_name : 'Safari Tours' ?>. All Rights Reserved.
            <span class="d-none d-md-inline">| Powered by CodeIgniter 3</span>
        </p>
    </footer>
</main><!-- End .admin-main -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- CKEditor 5 (for content editing) -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<script>
    // Set BASE_URL for SEO generator
    const BASE_URL = '<?= base_url() ?>';
</script>

<!-- SEO Generator -->
<script src="<?= base_url('assets/js/seo-generator.js') ?>"></script>

<script>
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const adminSidebar = document.getElementById('adminSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            adminSidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            adminSidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    }
    
    // Submenu Toggle
    document.querySelectorAll('.sidebar-menu li:has(> .submenu)').forEach(function(li) {
        li.classList.add('has-submenu');
        const mainLink = li.querySelector(':scope > a');
        if (mainLink) {
            // Add expand icon
            const expandIcon = document.createElement('i');
            expandIcon.className = 'fas fa-chevron-down submenu-toggle ms-auto';
            mainLink.appendChild(expandIcon);
            
            // Toggle submenu on click
            mainLink.addEventListener('click', function(e) {
                e.preventDefault();
                li.classList.toggle('expanded');
            });
        }
    });
    
    // Auto-expand submenu if active item is inside
    document.querySelectorAll('.sidebar-menu .submenu li a').forEach(function(link) {
        if (link.classList.contains('active')) {
            link.closest('li.has-submenu').classList.add('expanded');
        }
    });
    
    // Initialize DataTables
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('.datatable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records..."
                }
            });
        }
    });
    
    // Delete Confirmation
    function confirmDelete(url, itemName = 'item') {
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete this ${itemName}. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                submitFormWithCSRF(url);
            }
        });
    }

    // Action Confirmation (for approve, reject, etc)
    function confirmAction(url, action = 'proceed', itemName = 'item') {
        const messages = {
            approve: { title: 'Approve Review?', text: `Approve this ${itemName}?`, color: '#27ae60' },
            reject: { title: 'Reject Review?', text: `Reject this ${itemName}?`, color: '#e74c3c' },
            delete: { title: 'Delete?', text: `Delete this ${itemName}?`, color: '#e74c3c' }
        };
        
        const config = messages[action] || { title: 'Confirm Action', text: `${action} this ${itemName}?`, color: '#3498db' };
        
        Swal.fire({
            title: config.title,
            text: config.text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: config.color,
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                submitFormWithCSRF(url);
            }
        });
    }

    // Helper function to submit form with CSRF token
    function submitFormWithCSRF(url) {
        // Get CSRF token from meta tag
        let csrfName = '';
        let csrfValue = '';
        
        // Look for CSRF meta tag
        const csrfMeta = document.querySelector('meta[name*="csrf"]');
        if (csrfMeta) {
            csrfName = csrfMeta.getAttribute('name');
            csrfValue = csrfMeta.getAttribute('content');
        } else {
            // Fallback: try to find CSRF input
            const csrfInput = document.querySelector('input[name*="csrf"]');
            if (csrfInput) {
                csrfName = csrfInput.name;
                csrfValue = csrfInput.value;
            }
        }
        
        // Create and submit form with POST method
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.style.display = 'none';
        
        if (csrfName && csrfValue) {
            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = csrfName;
            token.value = csrfValue;
            form.appendChild(token);
        }
        
        document.body.appendChild(form);
        form.submit();
    }
    
    // Status Toggle Confirmation
    function confirmStatusChange(url, action = 'change status of') {
        Swal.fire({
            title: 'Confirm Action',
            text: `Are you sure you want to ${action} this item?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#e67e22',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
    
    // Show Success Message
    function showSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            timer: 2000,
            showConfirmButton: false
        });
    }
    
    // Show Error Message
    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: message
        });
    }
    
    // Flash Messages from Session
    <?php if ($this->session->flashdata('success')): ?>
        showSuccess('<?= addslashes($this->session->flashdata('success')) ?>');
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('error')): ?>
        showError('<?= addslashes($this->session->flashdata('error')) ?>');
    <?php endif; ?>
    
    // Image Preview
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
                document.getElementById(previewId).style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Initialize CKEditor on textareas with class 'ckeditor'
    document.querySelectorAll('.ckeditor').forEach(function(element) {
        ClassicEditor.create(element, {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', '|', 'undo', 'redo']
        }).catch(error => {
            console.error(error);
        });
    });
    
    // Auto-generate slug from title
    function generateSlug(source, target) {
        const sourceEl = document.getElementById(source);
        const targetEl = document.getElementById(target);
        
        if (sourceEl && targetEl) {
            sourceEl.addEventListener('keyup', function() {
                let slug = this.value.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim();
                targetEl.value = slug;
            });
        }
    }
    
    // Admin Search Functionality
    (function() {
        const searchInput = document.getElementById('adminSearch');
        const searchResults = document.getElementById('searchResults');
        
        if (!searchInput || !searchResults) return;
        
        // Define searchable pages
        const adminPages = [
            { title: 'Operations Dashboard', url: BASE_URL + 'admin/dashboard/operations', icon: 'fas fa-briefcase', category: 'Dashboards' },
            { title: 'Analytics Dashboard', url: BASE_URL + 'admin/dashboard/analytics', icon: 'fas fa-chart-line', category: 'Dashboards' },
            { title: 'Admissions', url: BASE_URL + 'admin/admissions', icon: 'fas fa-user-graduate', category: 'Admissions' },
            { title: 'Departments', url: BASE_URL + 'admin/departments', icon: 'fas fa-sitemap', category: 'Academic' },
            { title: 'Add Department', url: BASE_URL + 'admin/departments/create', icon: 'fas fa-plus', category: 'Academic' },
            { title: 'Faculty & Staff', url: BASE_URL + 'admin/faculty', icon: 'fas fa-chalkboard-user', category: 'Academic' },
            { title: 'Add Faculty', url: BASE_URL + 'admin/faculty/create', icon: 'fas fa-plus', category: 'Academic' },
            { title: 'Academic Programs', url: BASE_URL + 'admin/programs', icon: 'fas fa-graduation-cap', category: 'Academic' },
            { title: 'Add Program', url: BASE_URL + 'admin/programs/create', icon: 'fas fa-plus', category: 'Academic' },
            { title: 'Events Calendar', url: BASE_URL + 'admin/events', icon: 'fas fa-calendar-days', category: 'Events' },
            { title: 'Add Event', url: BASE_URL + 'admin/events/create', icon: 'fas fa-plus', category: 'Events' },
            { title: 'Notices', url: BASE_URL + 'admin/notices', icon: 'fas fa-clipboard-list', category: 'Communications' },
            { title: 'Add Notice', url: BASE_URL + 'admin/notices/create', icon: 'fas fa-plus', category: 'Communications' },
            { title: 'All Enquiries', url: BASE_URL + 'admin/enquiries', icon: 'fas fa-envelope', category: 'Enquiries' },
            { title: 'Contact Messages', url: BASE_URL + 'admin/contacts', icon: 'fas fa-envelope', category: 'Communications' },
            { title: 'Bulk Notifications', url: BASE_URL + 'admin/bulk-notifications', icon: 'fas fa-paper-plane', category: 'Communications' },
            { title: 'Gallery', url: BASE_URL + 'admin/gallery', icon: 'fas fa-images', category: 'Media' },
            { title: 'Upload Images', url: BASE_URL + 'admin/gallery/upload', icon: 'fas fa-upload', category: 'Media' },
            { title: 'Blog Posts', url: BASE_URL + 'admin/blog', icon: 'fas fa-newspaper', category: 'Blog' },
            { title: 'Add Blog Post', url: BASE_URL + 'admin/blog/create', icon: 'fas fa-plus', category: 'Blog' },
            { title: 'Pages', url: BASE_URL + 'admin/pages', icon: 'fas fa-file-alt', category: 'Content' },
            { title: 'Settings', url: BASE_URL + 'admin/settings', icon: 'fas fa-cog', category: 'Settings' },
            { title: 'My Profile', url: BASE_URL + 'admin/profile', icon: 'fas fa-user', category: 'Account' },
            { title: 'Change Password', url: BASE_URL + 'admin/profile/change_password', icon: 'fas fa-key', category: 'Account' }
        ];
        
        let debounceTimer;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const query = this.value.trim().toLowerCase();
            
            if (query.length < 2) {
                searchResults.classList.remove('show');
                return;
            }
            
            debounceTimer = setTimeout(() => {
                const results = adminPages.filter(page => 
                    page.title.toLowerCase().includes(query) || 
                    page.category.toLowerCase().includes(query)
                );
                
                renderResults(results);
            }, 150);
        });
        
        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2) {
                searchResults.classList.add('show');
            }
        });
        
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.remove('show');
            }
        });
        
        function renderResults(results) {
            if (results.length === 0) {
                searchResults.innerHTML = '<div class="no-results"><i class="fas fa-search me-2"></i>No results found</div>';
            } else {
                searchResults.innerHTML = results.map(item => `
                    <a href="${item.url}" class="search-item">
                        <i class="${item.icon}"></i>
                        <div class="search-info">
                            <div class="search-title">${item.title}</div>
                            <div class="search-category">${item.category}</div>
                        </div>
                    </a>
                `).join('');
            }
            searchResults.classList.add('show');
        }
        
        // Keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            const items = searchResults.querySelectorAll('.search-item');
            const active = searchResults.querySelector('.search-item:focus');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (!active && items.length) items[0].focus();
                else if (active && active.nextElementSibling) active.nextElementSibling.focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (active && active.previousElementSibling) active.previousElementSibling.focus();
            } else if (e.key === 'Escape') {
                searchResults.classList.remove('show');
                searchInput.blur();
            }
        });
    })();
</script>

<?php if (isset($extra_js)): ?>
    <?= $extra_js ?>
<?php endif; ?>

</body>
</html>
