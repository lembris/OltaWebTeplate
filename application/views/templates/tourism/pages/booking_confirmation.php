<?php
/**
 * Booking Confirmation Page
 * Displays booking details after successful submission
 * Created: December 2025
 */
?>

<!-- Page Hero -->
<?php include 'sections/page-hero-v3.php'; ?>

<!-- ============================================
     BOOKING CONFIRMATION
     ============================================ -->
<section class="confirmation-section py-6">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Success Card -->
                <div class="confirmation-card">
                    <!-- Success Header -->
                    <div class="success-header text-center">
                        <div class="success-icon-wrapper">
                            <div class="success-icon">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div class="success-circle"></div>
                        </div>
                        <h1>Booking Request Received!</h1>
                        <p class="lead">Thank you for choosing Osiram Safari Adventure</p>
                    </div>

                    <!-- Booking Reference -->
                    <div class="booking-ref-box">
                        <span class="ref-label">Your Booking Reference</span>
                        <span class="ref-number" id="bookingRef"><?php echo $booking->booking_ref; ?></span>
                        <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('<?php echo $booking->booking_ref; ?>')">
                            <i class="bi bi-clipboard me-1"></i>Copy
                        </button>
                    </div>

                    <!-- Booking Details -->
                    <div class="booking-details">
                        <h4><i class="bi bi-calendar-event me-2"></i>Booking Summary</h4>
                        
                        <div class="details-grid">
                            <div class="detail-item">
                                <span class="detail-label">Safari Package</span>
                                <span class="detail-value"><?php echo htmlspecialchars($booking->package_name); ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Duration</span>
                                <span class="detail-value"><?php echo $booking->duration_days; ?> Days</span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Travel Date</span>
                                <span class="detail-value">
                                    <i class="bi bi-calendar3 me-1 text-primary"></i>
                                    <?php echo date('l, F j, Y', strtotime($booking->travel_date)); ?>
                                </span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">End Date</span>
                                <span class="detail-value">
                                    <?php echo date('l, F j, Y', strtotime($booking->end_date)); ?>
                                </span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Travelers</span>
                                <span class="detail-value">
                                    <i class="bi bi-people me-1 text-primary"></i>
                                    <?php echo $booking->travelers_adults; ?> Adult<?php echo $booking->travelers_adults > 1 ? 's' : ''; ?>
                                    <?php if ($booking->travelers_children > 0): ?>
                                    , <?php echo $booking->travelers_children; ?> Child<?php echo $booking->travelers_children > 1 ? 'ren' : ''; ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Accommodation</span>
                                <span class="detail-value"><?php echo ucfirst($booking->accommodation_preference); ?></span>
                            </div>
                        </div>

                        <!-- Customer Details -->
                        <h4 class="mt-4"><i class="bi bi-person me-2"></i>Contact Information</h4>
                        
                        <div class="details-grid">
                            <div class="detail-item">
                                <span class="detail-label">Name</span>
                                <span class="detail-value"><?php echo htmlspecialchars($booking->customer_name); ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Email</span>
                                <span class="detail-value"><?php echo htmlspecialchars($booking->customer_email); ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Phone</span>
                                <span class="detail-value"><?php echo htmlspecialchars($booking->customer_phone); ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Country</span>
                                <span class="detail-value"><?php echo htmlspecialchars($booking->customer_country); ?></span>
                            </div>
                        </div>

                        <?php if (!empty($booking->special_requests)): ?>
                        <div class="special-requests mt-4">
                            <h5><i class="bi bi-chat-text me-2"></i>Special Requests</h5>
                            <p class="mb-0"><?php echo nl2br(htmlspecialchars($booking->special_requests)); ?></p>
                        </div>
                        <?php endif; ?>

                        <!-- Price Summary -->
                        <div class="price-summary mt-4">
                            <div class="price-row">
                                <span>Status</span>
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-hourglass-split me-1"></i>Pending Confirmation
                                </span>
                            </div>
                            <div class="price-row total">
                                <span>Total Amount</span>
                                <span class="amount">$<?php echo number_format($booking->total_price, 2); ?> USD</span>
                            </div>
                            <div class="price-row deposit">
                                <span>Deposit Required (30%)</span>
                                <span>$<?php echo number_format($booking->total_price * 0.3, 2); ?> USD</span>
                            </div>
                        </div>
                    </div>

                    <!-- What Happens Next -->
                    <div class="next-steps">
                        <h4><i class="bi bi-signpost-2 me-2"></i>What Happens Next?</h4>
                        
                        <div class="steps-timeline">
                            <div class="step-item">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h5>Confirmation Email</h5>
                                    <p>Check your inbox at <strong><?php echo htmlspecialchars($booking->customer_email); ?></strong> for your booking confirmation.</p>
                                </div>
                            </div>
                            
                            <div class="step-item">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <h5>Our Team Will Contact You</h5>
                                    <p>Within 24 hours, our safari expert will call or email you to confirm availability and discuss your trip.</p>
                                </div>
                            </div>
                            
                            <div class="step-item">
                                <div class="step-number">3</div>
                                <div class="step-content">
                                    <h5>Secure Your Booking</h5>
                                    <p>Pay a 30% deposit to confirm your safari. We'll send secure payment options.</p>
                                </div>
                            </div>
                            
                            <div class="step-item">
                                <div class="step-number">4</div>
                                <div class="step-content">
                                    <h5>Receive Your Itinerary</h5>
                                    <p>Get your detailed day-by-day safari itinerary, packing list, and pre-trip information.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact & Actions -->
                    <div class="confirmation-actions">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <button onclick="window.print()" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-printer me-2"></i>Print Confirmation
                                </button>
                            </div>
                            <div class="col-md-4">
                                <a href="https://wa.me/<?php echo $consult_number_call; ?>?text=Hi!%20My%20booking%20ref%20is%20<?php echo $booking->booking_ref; ?>" 
                                   class="btn btn-success w-100" target="_blank">
                                    <i class="bi bi-whatsapp me-2"></i>WhatsApp Us
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="<?php echo base_url(); ?>" class="btn btn-primary w-100">
                                    <i class="bi bi-house me-2"></i>Back to Home
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Questions Box -->
                    <div class="questions-box">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5><i class="bi bi-question-circle me-2"></i>Have Questions?</h5>
                                <p class="mb-0">Our team is available 24/7 to assist you with any questions about your booking.</p>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <a href="tel:<?php echo $consult_number_call; ?>" class="btn btn-outline-dark">
                                    <i class="bi bi-telephone me-2"></i>Call Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show feedback
        const btn = event.target.closest('button');
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check me-1"></i>Copied!';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-primary');
        }, 2000);
    });
}
</script>

<style>
/* ============ CONFIRMATION PAGE STYLES ============ */
.confirmation-section {
    background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 80vh;
}

.confirmation-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

/* Success Header */
.success-header {
    background: linear-gradient(135deg, var(--secondary, #90B3A7), var(--primary, #C7805C));
    color: white;
    padding: 50px 30px;
    position: relative;
}

.success-icon-wrapper {
    position: relative;
    width: 100px;
    height: 100px;
    margin: 0 auto 25px;
}

.success-icon {
    width: 100px;
    height: 100px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 2;
}

.success-icon i {
    font-size: 3rem;
    color: var(--secondary, #90B3A7);
}

.success-circle {
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    border: 3px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    animation: pulse-ring 2s infinite;
}

@keyframes pulse-ring {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(1.3); opacity: 0; }
}

.success-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.success-header .lead {
    opacity: 0.9;
    margin: 0;
}

/* Booking Reference Box */
.booking-ref-box {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    background: #1a1a2e;
    padding: 25px;
    flex-wrap: wrap;
}

.ref-label {
    color: rgba(255,255,255,0.7);
    font-size: 0.9rem;
}

.ref-number {
    font-size: 1.75rem;
    font-weight: 700;
    color: #20c997;
    font-family: monospace;
    letter-spacing: 2px;
}

/* Booking Details */
.booking-details {
    padding: 30px;
}

.booking-details h4 {
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e9ecef;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
}

.detail-label {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 5px;
}

.detail-value {
    font-weight: 600;
    color: #333;
}

.special-requests {
    background: #fff3cd;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid #ffc107;
}

.special-requests h5 {
    color: #856404;
    margin-bottom: 10px;
}

/* Price Summary */
.price-summary {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
}

.price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px dashed #dee2e6;
}

.price-row:last-child {
    border-bottom: none;
}

.price-row.total {
    font-size: 1.25rem;
    font-weight: 700;
    padding-top: 15px;
    border-top: 2px solid var(--secondary, #90B3A7);
    margin-top: 10px;
}

.price-row.total .amount {
    color: var(--secondary, #90B3A7);
}

.price-row.deposit {
    color: var(--primary, #C7805C);
}

/* Next Steps Timeline */
.next-steps {
    background: #e8f5e9;
    padding: 30px;
}

.next-steps h4 {
    color: #2e7d32;
    margin-bottom: 25px;
}

.steps-timeline {
    position: relative;
    padding-left: 40px;
}

.steps-timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #a5d6a7;
}

.step-item {
    position: relative;
    padding-bottom: 25px;
}

.step-item:last-child {
    padding-bottom: 0;
}

.step-number {
    position: absolute;
    left: -40px;
    width: 30px;
    height: 30px;
    background: var(--secondary, #90B3A7);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
}

.step-content h5 {
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
}

.step-content p {
    margin: 0;
    color: #666;
    font-size: 0.95rem;
}

/* Actions */
.confirmation-actions {
    padding: 30px;
    background: #f8f9fa;
}

/* Questions Box */
.questions-box {
    margin: 0 30px 30px;
    padding: 25px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 12px;
    border: 1px solid #dee2e6;
}

.questions-box h5 {
    margin-bottom: 5px;
    color: #333;
}

.questions-box p {
    color: #666;
}

/* Print Styles */
@media print {
    .sticky-cta-bar,
    .confirmation-actions,
    .questions-box,
    nav,
    footer {
        display: none !important;
    }
    
    .confirmation-card {
        box-shadow: none;
        border: 1px solid #dee2e6;
    }
    
    .success-header {
        background: #f8f9fa !important;
        color: #333 !important;
        -webkit-print-color-adjust: exact;
    }
    
    .success-icon {
        border: 2px solid var(--secondary, #90B3A7);
    }
    
    .booking-ref-box {
        background: #f8f9fa !important;
        color: #333 !important;
        border: 2px solid #333;
    }
    
    .ref-number {
        color: #333 !important;
    }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .details-grid {
        grid-template-columns: 1fr;
    }
    
    .booking-ref-box {
        flex-direction: column;
        text-align: center;
    }
    
    .ref-number {
        font-size: 1.5rem;
    }
    
    .success-header h1 {
        font-size: 1.5rem;
    }
}
</style>
