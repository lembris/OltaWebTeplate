<!-- Page hero Start -->
<?php $this->load->view('pages/sections/page-hero-v3'); ?>
<!-- Page Hero End -->

<!-- ============================================
     ENQUIRY SUCCESS PAGE - V3 Premium Design
     ============================================ -->
<section class="success-section-v3 py-6">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <!-- Success Card -->
                <div class="success-card">
                    <!-- Success Animation -->
                    <div class="success-animation">
                        <div class="checkmark-circle">
                            <div class="checkmark"></div>
                        </div>
                    </div>
                    
                    <!-- Success Message -->
                    <h1 class="success-title">Thank You!</h1>
                    <p class="success-subtitle">Your safari enquiry has been submitted successfully</p>
                    
                    <!-- Reference Number -->
                    <div class="reference-box">
                        <span class="reference-label">Your Reference Number</span>
                        <span class="reference-number"><?php echo htmlspecialchars($enquiry->reference_number); ?></span>
                        <button class="btn-copy" onclick="copyReference()" title="Copy to clipboard">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    
                    <p class="confirmation-email">
                        <i class="bi bi-envelope-check"></i>
                        A confirmation email has been sent to <strong><?php echo htmlspecialchars($enquiry->email); ?></strong>
                    </p>
                </div>
                
                <!-- Enquiry Summary -->
                <div class="summary-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="summary-header">
                        <i class="bi bi-clipboard-check"></i>
                        <h3>Your Enquiry Summary</h3>
                    </div>
                    
                    <div class="summary-content">
                        <div class="summary-row">
                            <span class="summary-label">Name</span>
                            <span class="summary-value"><?php echo htmlspecialchars($enquiry->full_name); ?></span>
                        </div>
                        
                        <?php 
                        $destinations = json_decode($enquiry->destinations, true);
                        if (!empty($destinations)): 
                        ?>
                        <div class="summary-row">
                            <span class="summary-label">Destinations</span>
                            <span class="summary-value"><?php echo htmlspecialchars(implode(', ', $destinations)); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="summary-row">
                            <span class="summary-label">Trip Type</span>
                            <span class="summary-value"><?php echo htmlspecialchars($enquiry->trip_type); ?></span>
                        </div>
                        
                        <div class="summary-row">
                            <span class="summary-label">Duration</span>
                            <span class="summary-value"><?php echo htmlspecialchars($enquiry->duration); ?></span>
                        </div>
                        
                        <div class="summary-row">
                            <span class="summary-label">Travelers</span>
                            <span class="summary-value">
                                <?php echo $enquiry->adults; ?> Adult(s)<?php echo $enquiry->children > 0 ? ', ' . $enquiry->children . ' Child(ren)' : ''; ?>
                            </span>
                        </div>
                        
                        <div class="summary-row">
                            <span class="summary-label">Accommodation</span>
                            <span class="summary-value"><?php echo htmlspecialchars($enquiry->accommodation); ?></span>
                        </div>
                        
                        <div class="summary-row">
                            <span class="summary-label">Budget</span>
                            <span class="summary-value highlight"><?php echo htmlspecialchars($enquiry->budget); ?></span>
                        </div>
                        
                        <?php if (!empty($enquiry->travel_date_from)): ?>
                        <div class="summary-row">
                            <span class="summary-label">Travel Dates</span>
                            <span class="summary-value">
                                <?php 
                                echo date('M j, Y', strtotime($enquiry->travel_date_from));
                                if (!empty($enquiry->travel_date_to)) {
                                    echo ' - ' . date('M j, Y', strtotime($enquiry->travel_date_to));
                                }
                                ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- What's Next -->
                <div class="next-steps-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="next-steps-header">
                        <h3>🚀 What Happens Next?</h3>
                    </div>
                    
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <span>1</span>
                            </div>
                            <div class="timeline-content">
                                <h4>Personal Consultation</h4>
                                <p>Our safari expert will review your requirements and contact you within <strong>24 hours</strong>.</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <span>2</span>
                            </div>
                            <div class="timeline-content">
                                <h4>Custom Itinerary</h4>
                                <p>We'll create a personalized safari itinerary tailored to your preferences and budget.</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <span>3</span>
                            </div>
                            <div class="timeline-content">
                                <h4>Detailed Quote</h4>
                                <p>Receive a transparent quote with all inclusions, accommodations, and activities.</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon active">
                                <span>4</span>
                            </div>
                            <div class="timeline-content">
                                <h4>Book & Adventure!</h4>
                                <p>Secure your safari with a deposit and get ready for the experience of a lifetime!</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Urgent Contact -->
                <div class="urgent-contact-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="urgent-icon">⏰</div>
                    <div class="urgent-content">
                        <h4>Need Urgent Assistance?</h4>
                        <p>Can't wait? We're here to help right now!</p>
                    </div>
                    <div class="urgent-actions">
                        <a href="tel:+<?php echo $consult_number_call; ?>" class="btn-urgent btn-call">
                            <i class="bi bi-telephone-fill"></i>
                            <span>Call Now</span>
                        </a>
                        <a href="https://wa.me/<?php echo $consult_number_call; ?>?text=Hi!%20My%20enquiry%20reference%20is%20<?php echo urlencode($enquiry->reference_number); ?>" class="btn-urgent btn-whatsapp" target="_blank">
                            <i class="bi bi-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons" data-aos="fade-up" data-aos-delay="400">
                    <a href="<?php echo base_url(); ?>" class="btn-action btn-home">
                        <i class="bi bi-house-door-fill"></i>
                        Back to Home
                    </a>
                    <a href="<?php echo base_url('packages'); ?>" class="btn-action btn-packages">
                        <i class="bi bi-compass-fill"></i>
                        Browse Packages
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ============ SUCCESS PAGE V3 ============ */

.success-section-v3 {
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    min-height: 60vh;
}

/* Success Card */
.success-card {
    background: white;
    border-radius: 24px;
    padding: 50px 40px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

/* Success Animation */
.success-animation {
    margin-bottom: 30px;
}

.checkmark-circle {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, var(--secondary, #90B3A7) 0%, #6a9488 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    animation: scaleIn 0.5s ease-out;
    box-shadow: 0 10px 40px rgba(144, 179, 167, 0.4);
}

@keyframes scaleIn {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.checkmark {
    width: 40px;
    height: 20px;
    border-left: 4px solid white;
    border-bottom: 4px solid white;
    transform: rotate(-45deg);
    animation: checkmark 0.3s ease-out 0.3s forwards;
    opacity: 0;
}

@keyframes checkmark {
    0% {
        opacity: 0;
        transform: rotate(-45deg) scale(0);
    }
    100% {
        opacity: 1;
        transform: rotate(-45deg) scale(1);
    }
}

.success-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 10px;
}

.success-subtitle {
    font-size: 1.15rem;
    color: #666;
    margin-bottom: 30px;
}

/* Reference Box */
.reference-box {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    background: linear-gradient(135deg, rgba(199, 128, 92, 0.1) 0%, rgba(199, 128, 92, 0.15) 100%);
    border: 2px solid var(--primary, #C7805C);
    border-radius: 16px;
    padding: 20px 40px;
    margin-bottom: 25px;
    position: relative;
}

.reference-label {
    font-size: 0.85rem;
    color: var(--primary, #C7805C);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.reference-number {
    font-size: 1.8rem;
    font-weight: 800;
    color: #1a1a2e;
    font-family: 'Courier New', monospace;
}

.btn-copy {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 35px;
    height: 35px;
    border: none;
    background: white;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-copy:hover {
    background: var(--primary, #C7805C);
    color: white;
}

.btn-copy.copied {
    background: var(--secondary, #90B3A7);
    color: white;
}

.confirmation-email {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-size: 0.95rem;
    color: #666;
}

.confirmation-email i {
    color: var(--secondary, #90B3A7);
    font-size: 1.2rem;
}

/* Summary Card */
.summary-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.06);
    margin-bottom: 30px;
}

.summary-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f5f9;
}

.summary-header i {
    font-size: 1.5rem;
    color: var(--primary, #C7805C);
}

.summary-header h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 700;
    color: #1a1a2e;
}

.summary-content {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
}

.summary-row:last-child {
    border-bottom: none;
}

.summary-label {
    font-weight: 600;
    color: #666;
    font-size: 0.95rem;
}

.summary-value {
    font-weight: 500;
    color: #1a1a2e;
    text-align: right;
}

.summary-value.highlight {
    background: linear-gradient(135deg, var(--secondary, #90B3A7) 0%, #6a9488 100%);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-weight: 600;
}

/* Next Steps Card */
.next-steps-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.06);
    margin-bottom: 30px;
}

.next-steps-header h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 25px;
    text-align: center;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 40px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, var(--primary, #C7805C) 0%, var(--secondary, #90B3A7) 100%);
}

.timeline-item {
    position: relative;
    padding-bottom: 25px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-icon {
    position: absolute;
    left: -40px;
    width: 32px;
    height: 32px;
    background: white;
    border: 2px solid var(--primary, #C7805C);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
}

.timeline-icon span {
    font-weight: 700;
    color: var(--primary, #C7805C);
    font-size: 0.9rem;
}

.timeline-icon.active {
    background: linear-gradient(135deg, var(--secondary, #90B3A7) 0%, #6a9488 100%);
    border-color: var(--secondary, #90B3A7);
}

.timeline-icon.active span {
    color: white;
}

.timeline-content h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 5px;
}

.timeline-content p {
    color: #666;
    font-size: 0.95rem;
    margin: 0;
}

/* Urgent Contact Card */
.urgent-contact-card {
    display: flex;
    align-items: center;
    gap: 20px;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 2px solid #f59e0b;
    border-radius: 16px;
    padding: 25px 30px;
    margin-bottom: 30px;
}

.urgent-icon {
    font-size: 2.5rem;
    flex-shrink: 0;
}

.urgent-content {
    flex: 1;
}

.urgent-content h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 3px;
}

.urgent-content p {
    color: #a16207;
    font-size: 0.9rem;
    margin: 0;
}

.urgent-actions {
    display: flex;
    gap: 12px;
    flex-shrink: 0;
}

.btn-urgent {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-call {
    background: white;
    color: #1a1a2e;
}

.btn-call:hover {
    background: #1a1a2e;
    color: white;
}

.btn-whatsapp {
    background: #25D366;
    color: white;
}

.btn-whatsapp:hover {
    background: #128C7E;
    transform: translateY(-2px);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 50px;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-home {
    background: #f1f5f9;
    color: #1a1a2e;
}

.btn-home:hover {
    background: #e2e8f0;
}

.btn-packages {
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    box-shadow: 0 10px 30px rgba(199, 128, 92, 0.3);
}

.btn-packages:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(199, 128, 92, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .success-card {
        padding: 35px 25px;
    }
    
    .success-title {
        font-size: 2rem;
    }
    
    .reference-box {
        padding: 15px 25px;
        width: 100%;
    }
    
    .reference-number {
        font-size: 1.4rem;
    }
    
    .urgent-contact-card {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }
    
    .urgent-actions {
        width: 100%;
        justify-content: center;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-action {
        justify-content: center;
    }
    
    .timeline {
        padding-left: 35px;
    }
    
    .timeline-icon {
        left: -35px;
        width: 28px;
        height: 28px;
    }
    
    .summary-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .summary-value {
        text-align: left;
    }
}
</style>

<script>
function copyReference() {
    const ref = '<?php echo $enquiry->reference_number; ?>';
    navigator.clipboard.writeText(ref).then(function() {
        const btn = document.querySelector('.btn-copy');
        btn.classList.add('copied');
        btn.innerHTML = '<i class="bi bi-check"></i>';
        
        setTimeout(function() {
            btn.classList.remove('copied');
            btn.innerHTML = '<i class="bi bi-clipboard"></i>';
        }, 2000);
    });
}
</script>
