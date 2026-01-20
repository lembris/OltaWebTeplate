<!-- ============================================
     CONSULTATION SUCCESS PAGE
     ============================================ -->
<style>
.success-section {
    padding: 150px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    min-height: 70vh;
}

.success-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(var(--theme-primary-rgb), 0.1);
    overflow: hidden;
}

.success-header {
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    color: white;
    padding: 50px 30px;
    text-align: center;
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
    font-size: 50px;
    color: #22c55e;
}

.success-circle {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 120px;
    height: 120px;
    border: 3px dashed rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    animation: spin 20s linear infinite;
}

@keyframes spin {
    from { transform: translate(-50%, -50%) rotate(0deg); }
    to { transform: translate(-50%, -50%) rotate(360deg); }
}

.success-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.booking-ref-box {
    background: #f8fafc;
    padding: 25px;
    text-align: center;
    border-bottom: 1px solid #e2e8f0;
}

.ref-label {
    display: block;
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ref-number {
    display: block;
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--theme-primary);
    margin-bottom: 10px;
}

.booking-details {
    padding: 30px;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-top: 20px;
}

.detail-item {
    background: #f8fafc;
    padding: 15px;
    border-radius: 10px;
}

.detail-label {
    display: block;
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    margin-bottom: 5px;
}

.detail-value {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
}

.next-steps {
    background: #f0f9ff;
    padding: 30px;
    border-top: 1px solid #e2e8f0;
}

.next-steps h4 {
    color: var(--theme-primary);
    margin-bottom: 20px;
}

.step-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.step-number {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, var(--theme-primary), var(--primary-dark));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    flex-shrink: 0;
}

.step-content h5 {
    font-size: 1rem;
    color: #1e293b;
    margin-bottom: 5px;
}

.step-content p {
    font-size: 0.875rem;
    color: #64748b;
    margin: 0;
}

.action-buttons {
    padding: 30px;
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.action-buttons .btn {
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
}

@media (max-width: 576px) {
    .details-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<section class="success-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-card">
                    <!-- Success Header -->
                    <div class="success-header">
                        <div class="success-icon-wrapper">
                            <div class="success-icon">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div class="success-circle"></div>
                        </div>
                        <h1>Consultation Request Received!</h1>
                        <p class="mb-0">Thank you for choosing TNA CARE</p>
                    </div>

                    <!-- Booking Reference -->
                    <div class="booking-ref-box">
                        <span class="ref-label">Your Reference Number</span>
                        <span class="ref-number"><?= htmlspecialchars($appointment->booking_ref ?? 'N/A') ?></span>
                        <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('<?= htmlspecialchars($appointment->booking_ref) ?>')">
                            <i class="bi bi-clipboard me-1"></i>Copy
                        </button>
                    </div>

                    <!-- Appointment Details -->
                    <div class="booking-details">
                        <h4><i class="bi bi-calendar-event me-2"></i>Consultation Details</h4>
                        
                        <div class="details-grid">
                            <div class="detail-item">
                                <span class="detail-label">Patient Name</span>
                                <span class="detail-value"><?= htmlspecialchars($appointment->patient_name) ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Email</span>
                                <span class="detail-value"><?= htmlspecialchars($appointment->patient_email) ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Phone</span>
                                <span class="detail-value"><?= htmlspecialchars($appointment->patient_phone) ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Country</span>
                                <span class="detail-value"><?= htmlspecialchars($appointment->country ?? 'Not specified') ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Medical Specialty</span>
                                <span class="detail-value"><?= htmlspecialchars($appointment->medical_specialty) ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Preferred Timeline</span>
                                <span class="detail-value"><?= htmlspecialchars($appointment->treatment_timeline) ?></span>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        <?php if (!empty($appointment->additional_notes)): ?>
                        <div class="mt-4">
                            <h5><i class="bi bi-chat-text me-2"></i>Your Notes</h5>
                            <p class="mb-0 text-muted"><?= nl2br(htmlspecialchars($appointment->additional_notes)) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- What Happens Next -->
                    <div class="next-steps">
                        <h4><i class="bi bi-signpost-2 me-2"></i>What Happens Next?</h4>
                        
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h5>Review</h5>
                                <p>Our medical coordinator will review your consultation request within 24 hours.</p>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h5>Contact</h5>
                                <p>We will contact you at <strong><?= htmlspecialchars($appointment->patient_phone) ?></strong> to schedule your consultation.</p>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h5>Confirmation</h5>
                                <p>Receive your confirmed appointment details via email at <strong><?= htmlspecialchars($appointment->patient_email) ?></strong></p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="<?= base_url() ?>" class="btn btn-primary">
                            <i class="bi bi-house me-2"></i>Back to Home
                        </a>
                        <a href="<?= base_url('contact') ?>" class="btn btn-outline-primary">
                            <i class="bi bi-envelope me-2"></i>Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Reference number copied to clipboard!');
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}
</script>
