<?php 
    $this->load->helper('template');
    $active_template = get_active_template();
    
    // Prepare data for nested views
    $header_data = array_merge(
        get_defined_vars(),
        isset($data) ? $data : []
    );
?>
<?php $this->load->view('templates/' . $active_template . '/header', $header_data); ?>
<?php $this->load->view('templates/' . $active_template . '/navigation', $header_data); ?>

<!-- Hero Section -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('<?php echo get_template_image('bg_2.jpg'); ?>');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="<?php echo base_url(); ?>">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span class="mr-2"><a href="<?php echo base_url('directory'); ?>">Directory <i class="fa fa-chevron-right"></i></a></span>
                    <span>Search Results <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Search Results</h1>
            </div>
        </div>
    </div>
</section>

<!-- Directory Section -->
<section class="ftco-section">
    <div class="container">
        <!-- Search Bar -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <form method="get" action="<?php echo base_url('directory/search'); ?>" class="form-inline">
                    <div class="input-group w-100">
                        <input type="text" name="q" class="form-control" placeholder="Search by name, email, phone..." required value="<?php echo htmlspecialchars($keyword); ?>">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
                <p class="text-muted small mt-2">
                    Search results for: <strong><?php echo htmlspecialchars($keyword); ?></strong>
                </p>
            </div>

            <?php if (!empty($types)): ?>
                <div class="col-lg-4">
                    <div class="btn-group d-flex flex-wrap gap-2" role="group">
                        <a href="<?php echo base_url('directory'); ?>" class="btn btn-sm btn-outline-secondary">All</a>
                        <?php foreach ($types as $t): ?>
                            <a href="<?php echo base_url('directory/by_type/' . $t->type); ?>" class="btn btn-sm btn-outline-secondary">
                                <?php echo ucfirst($t->type); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Search Results -->
        <?php if (!empty($results)): ?>
            <div class="results-count mb-4">
                <p class="text-muted">
                    Found <strong><?php echo count($results); ?></strong> result<?php echo count($results) != 1 ? 's' : ''; ?>
                </p>
            </div>

            <div class="directory-list">
                <?php foreach ($results as $entry): ?>
                    <div class="card mb-4 directory-entry h-100">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h5 class="card-title">
                                        <a href="<?php echo base_url('directory/view/' . $entry->id); ?>" class="text-dark">
                                            <?php echo htmlspecialchars($entry->name); ?>
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted small mb-2">
                                        <span class="badge bg-secondary"><?php echo ucfirst($entry->type); ?></span>
                                    </p>
                                    <?php if (!empty($entry->description)): ?>
                                        <p class="card-text small"><?php echo htmlspecialchars(substr($entry->description, 0, 150)); ?><?php echo strlen($entry->description) > 150 ? '...' : ''; ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-4">
                                    <dl class="small mb-0">
                                        <?php if (!empty($entry->email)): ?>
                                            <dt>Email:</dt>
                                            <dd><a href="mailto:<?php echo htmlspecialchars($entry->email); ?>"><?php echo htmlspecialchars($entry->email); ?></a></dd>
                                        <?php endif; ?>

                                        <?php if (!empty($entry->phone)): ?>
                                            <dt>Phone:</dt>
                                            <dd><a href="tel:<?php echo htmlspecialchars($entry->phone); ?>"><?php echo htmlspecialchars($entry->phone); ?></a></dd>
                                        <?php endif; ?>

                                        <?php if (!empty($entry->location)): ?>
                                            <dt>Location:</dt>
                                            <dd><?php echo htmlspecialchars($entry->location); ?></dd>
                                        <?php endif; ?>

                                        <?php if (!empty($entry->room_number)): ?>
                                            <dt>Room:</dt>
                                            <dd><?php echo htmlspecialchars($entry->room_number); ?></dd>
                                        <?php endif; ?>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if (isset($pagination)): ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php echo $pagination; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-search fa-2x mb-3"></i>
                <h5>No results found</h5>
                <p class="text-muted">No directory entries match your search for "<strong><?php echo htmlspecialchars($keyword); ?></strong>"</p>
                <a href="<?php echo base_url('directory'); ?>" class="btn btn-outline-secondary mt-3">
                    Back to Directory
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php $this->load->view('templates/' . $active_template . '/footer', $data); ?>
