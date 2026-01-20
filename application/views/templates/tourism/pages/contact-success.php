<!-- Page hero Start -->
<?php $this->load->view('pages/sections/page-hero-v3'); ?>
<!-- Page Hero End -->

<!-- ============================================
     SUCCESS MESSAGE SECTION
     ============================================ -->
<section class="contact-success-section py-6">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-container" data-aos="zoom-in">
                    <!-- Success Icon -->
                    <div class="success-icon">
                        <div class="success-checkmark">
                            <svg viewBox="0 0 52 52">
                                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                                <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Success Title -->
                    <h2 class="success-title">Message Sent Successfully! 🦁</h2>
                    
                    <!-- Success Message -->
                    <p class="success-message">
                        Thank you for reaching out to us! We've received your message and will get back to you within <strong>24 hours</strong>.
                    </p>

                    <!-- Submission Details -->
                    <div class="submission-details">
                        <h4>Message Details</h4>
                        
                        <div class="detail-row">
                            <span class="detail-label">📧 From:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($contact->email_address); ?></span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">👤 Name:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($contact->full_name); ?></span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">📝 Subject:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($contact->subject); ?></span>
                        </div>
                        
                        <div class="detail-row">
                            <span class="detail-label">⏰ Submitted:</span>
                            <span class="detail-value"><?php echo date('F j, Y \a\t g:i A'); ?></span>
                        </div>
                    </div>

                    <!-- What Happens Next -->
                    <div class="next-steps">
                        <h4>What Happens Next?</h4>
                        <div class="steps-list">
                            <div class="step-item">
                                <span class="step-number">1</span>
                                <span class="step-text">Our team will review your message</span>
                            </div>
                            <div class="step-item">
                                <span class="step-number">2</span>
                                <span class="step-text">We'll contact you at the email provided</span>
                            </div>
                            <div class="step-item">
                                <span class="step-number">3</span>
                                <span class="step-text">Let's plan your perfect safari adventure!</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Options -->
                    <div class="contact-options">
                        <p><strong>💬 Need immediate assistance?</strong></p>
                        <div class="options-grid">
                            <a href="https://wa.me/<?php echo $consult_number_call; ?>" class="option-btn whatsapp" target="_blank">
                                <i class="bi bi-whatsapp"></i>
                                <span>WhatsApp Us</span>
                            </a>
                            <a href="tel:+255789356961" class="option-btn call">
                                <i class="bi bi-telephone-fill"></i>
                                <span>Call Us</span>
                            </a>
                            <a href="mailto:<?php echo $email_address; ?>" class="option-btn email">
                                <i class="bi bi-envelope-fill"></i>
                                <span>Email Us</span>
                            </a>
                        </div>
                    </div>

                    <!-- Return Button -->
                    <div class="action-buttons">
                        <a href="<?php echo base_url('contact'); ?>" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i>
                            Back to Contact
                        </a>
                        <a href="<?php echo base_url('enquiry'); ?>" class="btn btn-secondary">
                            <i class="bi bi-compass"></i>
                            Plan a Safari
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Success Section Styles */
.contact-success-section {
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    min-height: 80vh;
    display: flex;
    align-items: center;
    padding: 60px 20px;
}

.success-container {
    background: white;
    border-radius: 24px;
    padding: 60px 40px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Success Icon Styles */
.success-icon {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}

.success-checkmark {
    position: relative;
    width: 100px;
    height: 100px;
}

.success-checkmark svg {
    width: 100%;
    height: 100%;
}

.checkmark-circle {
    stroke: var(--primary, #C7805C);
    stroke-width: 2;
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) 0.3s forwards;
}

.checkmark-check {
    stroke: var(--primary, #C7805C);
    stroke-width: 3;
    stroke-linecap: round;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.9s forwards;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}

/* Success Title */
.success-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 15px;
}

.success-message {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 40px;
    line-height: 1.8;
}

/* Submission Details */
.submission-details {
    background: #f9fafb;
    border-radius: 16px;
    padding: 30px;
    margin-bottom: 40px;
    text-align: left;
    border-left: 4px solid var(--primary, #C7805C);
}

.submission-details h4 {
    color: #1a1a2e;
    font-size: 1.2rem;
    margin-bottom: 20px;
    text-align: center;
}

.detail-row {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #e5e7eb;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: #1a1a2e;
    min-width: 120px;
}

.detail-value {
    color: #666;
    word-break: break-word;
}

/* Next Steps */
.next-steps {
    background: linear-gradient(135deg, #fef9e7 0%, #fdebd0 100%);
    border: 2px solid #f5b041;
    border-radius: 16px;
    padding: 30px;
    margin-bottom: 40px;
}

.next-steps h4 {
    color: #b7950b;
    font-size: 1.1rem;
    margin-bottom: 20px;
    text-align: center;
}

.steps-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.step-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px;
    background: white;
    border-radius: 10px;
}

.step-number {
    width: 35px;
    height: 35px;
    background: var(--primary, #C7805C);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    flex-shrink: 0;
}

.step-text {
    color: #1a1a2e;
    font-weight: 500;
}

/* Contact Options */
.contact-options {
    background: linear-gradient(135deg, #e7f5ff 0%, #d0ebff 100%);
    border: 2px solid #0d6efd;
    border-radius: 16px;
    padding: 30px;
    margin-bottom: 40px;
}

.contact-options p {
    color: #1a1a2e;
    font-size: 1.1rem;
    margin-bottom: 20px;
}

.options-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 15px;
}

.option-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 20px 15px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.option-btn i {
    font-size: 1.5rem;
}

.option-btn.whatsapp {
    background: #25D366;
    color: white;
}

.option-btn.whatsapp:hover {
    background: #1fa855;
    transform: translateY(-3px);
}

.option-btn.call {
    background: #0d6efd;
    color: white;
}

.option-btn.call:hover {
    background: #0b5ed7;
    transform: translateY(-3px);
}

.option-btn.email {
    background: var(--primary, #C7805C);
    color: white;
}

.option-btn.email:hover {
    background: #a8684a;
    transform: translateY(-3px);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 35px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1rem;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    box-shadow: 0 10px 30px rgba(199, 128, 92, 0.3);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(199, 128, 92, 0.4);
}

.btn-secondary {
    background: white;
    color: var(--primary, #C7805C);
    border: 2px solid var(--primary, #C7805C);
}

.btn-secondary:hover {
    background: var(--primary, #C7805C);
    color: white;
    transform: translateY(-3px);
}

/* Responsive */
@media (max-width: 768px) {
    .success-container {
        padding: 40px 25px;
    }
    
    .success-title {
        font-size: 2rem;
    }
    
    .success-message {
        font-size: 1rem;
    }
    
    .submission-details,
    .next-steps,
    .contact-options {
        padding: 20px;
    }
    
    .detail-label {
        min-width: 100px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .contact-success-section {
        padding: 40px 15px;
    }
    
    .success-container {
        padding: 30px 20px;
    }
    
    .success-title {
        font-size: 1.5rem;
    }
    
    .success-message {
        font-size: 0.95rem;
    }
    
    .options-grid {
        grid-template-columns: 1fr;
    }
}
</style>
