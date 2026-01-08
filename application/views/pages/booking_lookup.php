<?php
/**
 * Booking Lookup Page
 * Allows customers to look up their booking by reference number
 * Created: December 2025
 */
?>

<!-- Page Hero -->
<?php include 'sections/page-hero-v3.php'; ?>

<!-- ============================================
     BOOKING LOOKUP SECTION
     ============================================ -->
<section class="booking-lookup-section py-6">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- Lookup Form Card -->
                <div class="lookup-card">
                    <div class="lookup-header text-center">
                        <div class="lookup-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h2>Find Your Booking</h2>
                        <p class="text-muted">Enter your booking reference to view your booking details</p>
                    </div>

                    <form action="<?php echo base_url('booking/lookup'); ?>" method="POST" class="lookup-form">
                        <div class="mb-4">
                            <label class="form-label">Booking Reference</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text"><i class="bi bi-ticket-perforated"></i></span>
                                <input type="text" name="booking_ref" class="form-control" 
                                       placeholder="e.g., OSA-2025-12345"
                                       pattern="[A-Z]{3}-[0-9]{4}-[0-9]{5}"
                                       title="Format: OSA-2025-12345"
                                       required
                                       value="<?php echo isset($_POST['booking_ref']) ? htmlspecialchars($_POST['booking_ref']) : ''; ?>">
                            </div>
                            <small class="text-muted">Format: OSA-YYYY-XXXXX (found in your confirmation email)</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search me-2"></i>Find My Booking
                        </button>
                    </form>

                    <?php if (isset($lookup_error)): ?>
                    <div class="alert alert-warning mt-4">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <?php echo $lookup_error; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if (isset($booking) && $booking): ?>
                <!-- Booking Result -->
                <div class="booking-result-card mt-4">
                    <div class="result-header">
                        <span class="status-badge status-<?php echo $booking->status; ?>">
                            <?php echo ucfirst($booking->status); ?>
                        </span>
                        <h3><?php echo $booking->booking_ref; ?></h3>
                    </div>

                    <div class="result-body">
                        <div class="detail-row">
                            <span class="label"><i class="bi bi-box-seam me-2"></i>Package</span>
                            <span class="value"><?php echo htmlspecialchars($booking->package_name); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="label"><i class="bi bi-calendar3 me-2"></i>Travel Date</span>
                            <span class="value"><?php echo date('F j, Y', strtotime($booking->travel_date)); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="label"><i class="bi bi-people me-2"></i>Travelers</span>
                            <span class="value">
                                <?php echo $booking->travelers_adults; ?> Adult(s)
                                <?php if ($booking->travelers_children > 0): ?>
                                , <?php echo $booking->travelers_children; ?> Child(ren)
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="label"><i class="bi bi-currency-dollar me-2"></i>Total</span>
                            <span class="value price">$<?php echo number_format($booking->total_price, 2); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="label"><i class="bi bi-clock me-2"></i>Booked On</span>
                            <span class="value"><?php echo date('F j, Y \a\t g:i A', strtotime($booking->created_at)); ?></span>
                        </div>
                    </div>

                    <div class="result-footer">
                        <a href="https://wa.me/<?php echo $consult_number_call; ?>?text=Hi!%20My%20booking%20ref%20is%20<?php echo $booking->booking_ref; ?>" 
                           class="btn btn-success" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Contact Us
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-primary">
                            <i class="bi bi-printer me-2"></i>Print
                        </button>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Help Box -->
                <div class="help-box mt-4">
                    <h5><i class="bi bi-question-circle me-2"></i>Can't find your reference?</h5>
                    <p>Your booking reference was sent to your email when you submitted your booking request. Check your spam folder or contact us.</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="mailto:<?php echo $email_address; ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-envelope me-1"></i>Email Us
                        </a>
                        <a href="tel:<?php echo $consult_number_call; ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-telephone me-1"></i>Call Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ============ BOOKING LOOKUP STYLES ============ */
.booking-lookup-section {
    background: #f8f9fa;
    min-height: 60vh;
}

.lookup-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 40px;
}

.lookup-header {
    margin-bottom: 30px;
}

.lookup-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary, #C7805C), var(--secondary, #90B3A7));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.lookup-icon i {
    font-size: 2rem;
    color: white;
}

.lookup-header h2 {
    font-weight: 700;
    margin-bottom: 5px;
}

.booking-result-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.result-header {
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: white;
    padding: 25px;
    text-align: center;
}

.result-header h3 {
    margin: 10px 0 0;
    font-family: monospace;
    font-size: 1.5rem;
    letter-spacing: 2px;
}

.status-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending { background: #ffc107; color: #333; }
.status-confirmed { background: var(--secondary, #90B3A7); color: white; }
.status-deposit_paid { background: #0dcaf0; color: #333; }
.status-paid { background: var(--secondary, #90B3A7); color: white; }
.status-cancelled { background: #dc3545; color: white; }
.status-completed { background: #6c757d; color: white; }

.result-body {
    padding: 25px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px dashed #e9ecef;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row .label {
    color: #666;
}

.detail-row .value {
    font-weight: 600;
}

.detail-row .value.price {
    color: var(--secondary, #90B3A7);
    font-size: 1.1rem;
}

.result-footer {
    display: flex;
    gap: 10px;
    padding: 20px 25px;
    background: #f8f9fa;
    justify-content: center;
}

.help-box {
    background: white;
    padding: 25px;
    border-radius: 12px;
    border: 1px solid #e9ecef;
}

.help-box h5 {
    margin-bottom: 10px;
}

.help-box p {
    color: #666;
    margin-bottom: 15px;
}
</style>
