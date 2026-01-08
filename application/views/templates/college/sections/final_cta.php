<?php
// Load theme colors dynamically from database
$primary_color = get_primary_color();
$secondary_color = get_secondary_color();
$darkened_primary = darken_color($primary_color, 15);
?>

<!-- ============================================
     FINAL CTA - Urgency Section
     ============================================ -->
<section class="ftco-section" style="background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $darkened_primary; ?> 100%); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 mb-4 mb-md-0">
                <h2 class="text-white mb-3">Begin Your Journey With Us</h2>
                <p class="text-white lead">Take the first step towards a brighter future. Apply now for our upcoming intake and join thousands of successful graduates.</p>
            </div>
            <div class="col-md-4 text-md-right">
                <p class="mb-0">
                    <a href="<?php echo base_url('contact'); ?>" class="btn btn-light px-5 py-3 font-weight-bold">Apply Now</a>
                </p>
            </div>
        </div>
    </div>
</section>