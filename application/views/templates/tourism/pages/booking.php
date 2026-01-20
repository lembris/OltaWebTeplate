<?php
/**
 * Safari Booking Page v3.0
 * Full booking form with interactive calendar, price calculator
 * Created: December 2025
 */

$form_data = $this->session->flashdata('form_data') ?? [];
?>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">

<!-- Page Hero -->
<?php include 'sections/page-hero-v3.php'; ?>

<!-- ============================================
     BOOKING SECTION
     ============================================ -->
<section class="booking-section-v3 py-6">
    <div class="container">
        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?php echo $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Booking Form Column -->
            <div class="col-lg-8">
                <div class="booking-form-card">
                    <div class="form-header">
                        <h2><i class="bi bi-calendar-check me-2"></i>Book Your Safari Adventure</h2>
                        <p>Fill out the form below to request a booking. Our team will confirm availability within 24 hours.</p>
                    </div>

                    <form action="<?php echo base_url('booking/process'); ?>" method="POST" id="bookingForm" class="booking-form">
                        <!-- CSRF Token -->
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        
                        <!-- Honeypot -->
                        <div style="position: absolute; left: -9999px;">
                            <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                        </div>

                        <!-- Step 1: Select Package -->
                        <div class="form-step" id="step1">
                            <div class="step-header">
                                <span class="step-number">1</span>
                                <h4>Select Your Safari Package</h4>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label required">Safari Package</label>
                                    <select name="package_id" id="packageSelect" class="form-select form-select-lg" required>
                                        <option value="">-- Choose a Package --</option>
                                        <?php foreach ($packages as $pkg): ?>
                                        <option value="<?php echo $pkg->id; ?>" 
                                                data-duration="<?php echo $pkg->duration_days; ?>"
                                                data-category="<?php echo $pkg->category; ?>"
                                                <?php echo (isset($pre_selected_package) && $pre_selected_package == $pkg->slug) ? 'selected' : ''; ?>
                                                <?php echo (isset($form_data['package_id']) && $form_data['package_id'] == $pkg->id) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($pkg->name); ?> (<?php echo $pkg->duration_days; ?> Days)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="package-info mt-2" id="packageInfo" style="display: none;">
                                        <span class="badge bg-primary me-2" id="packageDuration"></span>
                                        <span class="badge bg-secondary" id="packageCategory"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Date & Travelers -->
                        <div class="form-step" id="step2">
                            <div class="step-header">
                                <span class="step-number">2</span>
                                <h4>Travel Details</h4>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Travel Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                        <input type="text" name="travel_date" id="travelDate" 
                                               class="form-control form-control-lg" 
                                               placeholder="Select date"
                                               value="<?php echo $form_data['travel_date'] ?? ($pre_selected_date ?? ''); ?>"
                                               required readonly>
                                    </div>
                                    <small class="text-muted">
                                        <span class="text-success"><i class="bi bi-check-circle"></i> Available</span> |
                                        <span class="text-warning"><i class="bi bi-exclamation-circle"></i> Limited</span> |
                                        <span class="text-danger"><i class="bi bi-x-circle"></i> Fully Booked</span>
                                    </small>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label required">Adults (12+)</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="adjustTravelers('adults', -1)">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="number" name="adults" id="adultsInput" 
                                               class="form-control form-control-lg text-center" 
                                               value="<?php echo $form_data['adults'] ?? 2; ?>" 
                                               min="1" max="20" required readonly>
                                        <button type="button" class="btn btn-outline-secondary" onclick="adjustTravelers('adults', 1)">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Children (2-11)</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="adjustTravelers('children', -1)">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="number" name="children" id="childrenInput" 
                                               class="form-control form-control-lg text-center" 
                                               value="<?php echo $form_data['children'] ?? 0; ?>" 
                                               min="0" max="10" readonly>
                                        <button type="button" class="btn btn-outline-secondary" onclick="adjustTravelers('children', 1)">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">25% discount for children</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Accommodation Preference</label>
                                    <select name="accommodation" id="accommodationSelect" class="form-select form-select-lg">
                                        <option value="budget" <?php echo (isset($form_data['accommodation']) && $form_data['accommodation'] == 'budget') ? 'selected' : ''; ?>>
                                            🏕️ Budget (Camping/Basic Lodges) - Save 25%
                                        </option>
                                        <option value="mid-range" <?php echo (!isset($form_data['accommodation']) || $form_data['accommodation'] == 'mid-range') ? 'selected' : ''; ?>>
                                            🏨 Mid-Range (Comfortable Lodges) - Standard
                                        </option>
                                        <option value="luxury" <?php echo (isset($form_data['accommodation']) && $form_data['accommodation'] == 'luxury') ? 'selected' : ''; ?>>
                                            🏰 Luxury (Premium Lodges/Tented Camps) +40%
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Personal Details -->
                        <div class="form-step" id="step3">
                            <div class="step-header">
                                <span class="step-number">3</span>
                                <h4>Your Details</h4>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="customer_name" 
                                               class="form-control form-control-lg" 
                                               placeholder="John Smith"
                                               value="<?php echo $form_data['customer_name'] ?? ''; ?>"
                                               required minlength="2" maxlength="100">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="customer_email" 
                                               class="form-control form-control-lg" 
                                               placeholder="john@example.com"
                                               value="<?php echo $form_data['customer_email'] ?? ''; ?>"
                                               required maxlength="150">
                                    </div>
                                    <small class="text-muted">Booking confirmation will be sent here</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="tel" name="customer_phone" 
                                               class="form-control form-control-lg" 
                                               placeholder="+1 234 567 8900"
                                               value="<?php echo $form_data['customer_phone'] ?? ''; ?>"
                                               required minlength="6" maxlength="30">
                                    </div>
                                    <small class="text-muted">Include country code (e.g., +1, +44)</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Country</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                        <select name="customer_country" class="form-select form-select-lg" required>
                                            <option value="">Select your country</option>
                                            <option value="United States">United States</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Germany">Germany</option>
                                            <option value="France">France</option>
                                            <option value="Netherlands">Netherlands</option>
                                            <option value="Switzerland">Switzerland</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Spain">Spain</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Sweden">Sweden</option>
                                            <option value="Norway">Norway</option>
                                            <option value="Denmark">Denmark</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Ireland">Ireland</option>
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="South Africa">South Africa</option>
                                            <option value="Japan">Japan</option>
                                            <option value="Singapore">Singapore</option>
                                            <option value="China">China</option>
                                            <option value="India">India</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="Mexico">Mexico</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Special Requests <span class="text-muted">(Optional)</span></label>
                                    <textarea name="special_requests" class="form-control" rows="3" 
                                              placeholder="Dietary requirements, mobility needs, special occasions, preferences..."
                                              maxlength="1000"><?php echo $form_data['special_requests'] ?? ''; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Terms & Submit -->
                        <div class="form-step" id="step4">
                            <div class="terms-box">
                                <div class="form-check">
                                    <input type="checkbox" name="terms_agree" id="termsAgree" 
                                           class="form-check-input" required value="1">
                                    <label class="form-check-label" for="termsAgree">
                                        I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms & Conditions</a> 
                                        and <a href="#" data-bs-toggle="modal" data-bs-target="#cancellationModal">Cancellation Policy</a>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" name="submit" class="btn btn-book-now btn-lg w-100" id="submitBtn" disabled>
                                <i class="bi bi-calendar-check me-2"></i>
                                <span>Request Booking</span>
                                <i class="bi bi-arrow-right ms-2"></i>
                            </button>

                            <div class="secure-notice mt-3 text-center">
                                <i class="bi bi-shield-check text-success me-1"></i>
                                <small class="text-muted">Your information is secure and encrypted</small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Price Summary Sidebar -->
            <div class="col-lg-4">
                <div class="price-summary-card sticky-top" style="top: 100px;">
                    <div class="summary-header">
                        <h4><i class="bi bi-receipt me-2"></i>Price Summary</h4>
                    </div>

                    <div class="summary-body" id="priceSummaryContent">
                        <div class="empty-state text-center py-4">
                            <i class="bi bi-calculator" style="font-size: 3rem; color: #dee2e6;"></i>
                            <p class="text-muted mt-3">Select a package and date to see pricing</p>
                        </div>
                    </div>

                    <div class="summary-footer" id="priceSummaryFooter" style="display: none;">
                        <div class="total-row">
                            <span>Total Price</span>
                            <span class="total-amount" id="totalAmount">$0.00</span>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            30% deposit required to confirm booking
                        </small>
                    </div>

                    <!-- Trust Badges -->
                    <div class="trust-badges mt-4">
                        <div class="row g-2 text-center">
                            <div class="col-4">
                                <div class="trust-badge">
                                    <i class="bi bi-shield-check"></i>
                                    <small>Secure Booking</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="trust-badge">
                                    <i class="bi bi-star-fill"></i>
                                    <small>5-Star Reviews</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="trust-badge">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <small>Free Changes</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Help -->
                    <div class="help-box mt-4">
                        <h5><i class="bi bi-headset me-2"></i>Need Help?</h5>
                        <p class="small text-muted mb-3">Our safari experts are here to assist you</p>
                        <a href="https://wa.me/<?php echo $consult_number_call; ?>?text=Hi!%20I%20need%20help%20with%20booking" 
                           class="btn btn-success btn-sm w-100" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Chat on WhatsApp
                        </a>
                        <a href="tel:<?php echo $consult_number_call; ?>" class="btn btn-outline-primary btn-sm w-100 mt-2">
                            <i class="bi bi-telephone me-2"></i>Call Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms & Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>1. Booking Confirmation</h6>
                <p>All bookings are subject to availability. A 30% non-refundable deposit is required to confirm your booking.</p>
                
                <h6>2. Payment</h6>
                <p>Full payment is due 60 days before the safari start date. Late payments may result in cancellation.</p>
                
                <h6>3. Travel Insurance</h6>
                <p>We strongly recommend purchasing comprehensive travel insurance covering trip cancellation, medical emergencies, and evacuation.</p>
                
                <h6>4. Health & Safety</h6>
                <p>Clients must inform us of any medical conditions. Yellow fever vaccination may be required.</p>
                
                <h6>5. Liability</h6>
                <p>Osiram Safari Adventure acts as an agent and is not liable for any injury, damage, or loss during the safari.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>

<!-- Cancellation Policy Modal -->
<div class="modal fade" id="cancellationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancellation Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="cancellation-timeline">
                    <div class="cancel-item">
                        <span class="cancel-time">60+ days before</span>
                        <span class="cancel-fee text-success">Full refund (minus deposit)</span>
                    </div>
                    <div class="cancel-item">
                        <span class="cancel-time">30-59 days before</span>
                        <span class="cancel-fee text-warning">50% refund</span>
                    </div>
                    <div class="cancel-item">
                        <span class="cancel-time">15-29 days before</span>
                        <span class="cancel-fee text-danger">25% refund</span>
                    </div>
                    <div class="cancel-item">
                        <span class="cancel-time">Less than 15 days</span>
                        <span class="cancel-fee text-danger">No refund</span>
                    </div>
                </div>
                <hr>
                <p class="small text-muted">Date changes are free up to 30 days before departure, subject to availability.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const BASE_URL = '<?php echo base_url(); ?>';
    const CSRF_TOKEN_NAME = '<?php echo $this->security->get_csrf_token_name(); ?>';
    const CSRF_HASH = '<?php echo $this->security->get_csrf_hash(); ?>';
    let currentPackageId = null;
    let datePicker = null;
    let availabilityData = {};
    let debounceTimer = null;

    // Initialize Flatpickr
    datePicker = flatpickr('#travelDate', {
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'F j, Y',
        minDate: 'today',
        maxDate: new Date().fp_incr(547), // 18 months
        disable: [],
        locale: {
            firstDayOfWeek: 1
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            if (currentPackageId) {
                fetchAvailability(currentPackageId, instance.currentMonth + 1, instance.currentYear);
            }
        },
        onDayCreate: function(dArr, dStr, fp, dayElem) {
            const dateStr = dayElem.dateObj.toISOString().split('T')[0];
            if (availabilityData[dateStr]) {
                const status = availabilityData[dateStr].status;
                dayElem.classList.add('availability-' + status);
                if (status === 'full') {
                    dayElem.classList.add('flatpickr-disabled');
                }
            }
        },
        onChange: function(selectedDates, dateStr) {
            calculatePrice();
        }
    });

    // Package selection handler
    document.getElementById('packageSelect').addEventListener('change', function() {
        currentPackageId = this.value;
        const selected = this.options[this.selectedIndex];
        
        if (currentPackageId) {
            document.getElementById('packageInfo').style.display = 'block';
            document.getElementById('packageDuration').textContent = selected.dataset.duration + ' Days';
            document.getElementById('packageCategory').textContent = ucfirst(selected.dataset.category);
            
            // Fetch availability for current month
            const now = new Date();
            fetchAvailability(currentPackageId, now.getMonth() + 1, now.getFullYear());
        } else {
            document.getElementById('packageInfo').style.display = 'none';
        }
        
        calculatePrice();
    });

    // Traveler adjustment
    window.adjustTravelers = function(type, delta) {
        const input = document.getElementById(type + 'Input');
        let val = parseInt(input.value) + delta;
        const min = parseInt(input.min);
        const max = parseInt(input.max);
        
        if (val >= min && val <= max) {
            input.value = val;
            calculatePrice();
        }
    };

    // Accommodation change
    document.getElementById('accommodationSelect').addEventListener('change', calculatePrice);

    // Terms checkbox
    document.getElementById('termsAgree').addEventListener('change', function() {
        document.getElementById('submitBtn').disabled = !this.checked;
    });

    // Fetch availability from server
    function fetchAvailability(packageId, month, year) {
        fetch(BASE_URL + 'booking/check_availability', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `package_id=${packageId}&month=${month}&year=${year}&${CSRF_TOKEN_NAME}=${CSRF_HASH}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                availabilityData = {...availabilityData, ...data.dates};
                datePicker.redraw();
            }
        })
        .catch(err => console.error('Availability fetch error:', err));
    }

    // Calculate price
    function calculatePrice() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(doCalculatePrice, 300);
    }

    function doCalculatePrice() {
        const packageId = document.getElementById('packageSelect').value;
        const travelDate = document.getElementById('travelDate').value;
        const adults = document.getElementById('adultsInput').value;
        const children = document.getElementById('childrenInput').value;
        const accommodation = document.getElementById('accommodationSelect').value;

        if (!packageId || !travelDate) {
            showEmptyPriceSummary();
            return;
        }

        // Show loading
        document.getElementById('priceSummaryContent').innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="text-muted mt-2">Calculating...</p>
            </div>
        `;

        fetch(BASE_URL + 'booking/calculate_price', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `package_id=${packageId}&travel_date=${travelDate}&adults=${adults}&children=${children}&accommodation=${accommodation}&${CSRF_TOKEN_NAME}=${CSRF_HASH}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updatePriceSummary(data);
            } else {
                showPriceError(data.message);
            }
        })
        .catch(err => {
            console.error('Price calculation error:', err);
            showPriceError('Unable to calculate price');
        });
    }

    function updatePriceSummary(data) {
        const pricing = data.pricing;
        const pkg = data.package;
        const availability = data.availability;
        
        let html = `
            <div class="selected-package mb-3">
                <h5 class="mb-1">${pkg.name}</h5>
                <span class="badge bg-primary">${pkg.duration} Days</span>
                <span class="badge bg-secondary">${ucfirst(pkg.category)}</span>
            </div>
            <hr>
            <div class="price-breakdown">
        `;

        if (!availability.available) {
            html += `
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    ${availability.message}
                </div>
            `;
        }

        html += `
            <div class="price-row">
                <span>Base Price</span>
                <span>$${formatNumber(pricing.base_price)}</span>
            </div>
        `;

        const adults = parseInt(document.getElementById('adultsInput').value);
        const children = parseInt(document.getElementById('childrenInput').value);

        if (adults > 1) {
            html += `
                <div class="price-row">
                    <span>${adults - 1} Additional Adult(s)</span>
                    <span>$${formatNumber(pricing.price_per_person * (adults - 1))}</span>
                </div>
            `;
        }

        if (children > 0) {
            html += `
                <div class="price-row">
                    <span>${children} Child(ren) <small class="text-success">(-${pricing.child_discount_percent}%)</small></span>
                    <span>$${formatNumber(pricing.children_total)}</span>
                </div>
            `;
        }

        if (pricing.single_supplement > 0) {
            html += `
                <div class="price-row">
                    <span>Solo Traveler Supplement</span>
                    <span>$${formatNumber(pricing.single_supplement)}</span>
                </div>
            `;
        }

        if (pricing.price_modifier > 1) {
            html += `
                <div class="price-row text-muted">
                    <span><small>Peak date surcharge</small></span>
                    <span><small>+${Math.round((pricing.price_modifier - 1) * 100)}%</small></span>
                </div>
            `;
        }

        const accLabel = document.getElementById('accommodationSelect').options[document.getElementById('accommodationSelect').selectedIndex].text;
        html += `
            <div class="price-row">
                <span>Accommodation</span>
                <span class="small">${accLabel.split(' - ')[0]}</span>
            </div>
        `;

        html += `
            <div class="price-row season-info">
                <span>Season</span>
                <span class="badge ${getSeasonBadge(pricing.season)}">${ucfirst(pricing.season)} Season</span>
            </div>
        </div>`;

        document.getElementById('priceSummaryContent').innerHTML = html;
        document.getElementById('priceSummaryFooter').style.display = 'block';
        document.getElementById('totalAmount').textContent = '$' + formatNumber(pricing.total);

        // Enable submit if available
        if (availability.available && document.getElementById('termsAgree').checked) {
            document.getElementById('submitBtn').disabled = false;
        }
    }

    function showEmptyPriceSummary() {
        document.getElementById('priceSummaryContent').innerHTML = `
            <div class="empty-state text-center py-4">
                <i class="bi bi-calculator" style="font-size: 3rem; color: #dee2e6;"></i>
                <p class="text-muted mt-3">Select a package and date to see pricing</p>
            </div>
        `;
        document.getElementById('priceSummaryFooter').style.display = 'none';
    }

    function showPriceError(message) {
        document.getElementById('priceSummaryContent').innerHTML = `
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-2"></i>
                ${message}
            </div>
        `;
        document.getElementById('priceSummaryFooter').style.display = 'none';
    }

    function formatNumber(num) {
        return parseFloat(num).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function getSeasonBadge(season) {
        switch(season) {
            case 'peak': return 'bg-danger';
            case 'high': return 'bg-warning text-dark';
            case 'mid': return 'bg-info';
            default: return 'bg-success';
        }
    }

    // Form validation on submit
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        const packageId = document.getElementById('packageSelect').value;
        const travelDate = document.getElementById('travelDate').value;
        
        if (!packageId || !travelDate) {
            e.preventDefault();
            alert('Please select a package and travel date');
            return false;
        }
    });

    // Trigger initial calculation if pre-selected
    if (document.getElementById('packageSelect').value) {
        document.getElementById('packageSelect').dispatchEvent(new Event('change'));
    }
});
</script>

<style>
    /* ============ BOOKING PAGE STYLES ============ */
    .booking-section-v3 {
        background: #f8f9fa;
        min-height: 80vh;
    }

    .booking-form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, var(--primary, #C7805C), var(--secondary, #90B3A7));
        color: white;
        padding: 30px;
    }

    .form-header h2 {
        margin: 0 0 10px;
        font-weight: 700;
    }

    .form-header p {
        margin: 0;
        opacity: 0.9;
    }

    .booking-form {
        padding: 30px;
    }

    .form-step {
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #e9ecef;
    }

    .form-step:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .step-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .step-number {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, var(--primary, #C7805C), var(--secondary, #90B3A7));
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .step-header h4 {
        margin: 0;
        font-weight: 600;
        color: #333;
    }

    .form-label.required::after {
        content: ' *';
        color: #dc3545;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary, #C7805C);
        box-shadow: 0 0 0 0.2rem rgba(199, 128, 92, 0.15);
    }

    .package-info .badge {
        font-size: 0.85rem;
        padding: 6px 12px;
    }

    .terms-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .btn-book-now {
        background: linear-gradient(135deg, var(--secondary, #90B3A7), var(--primary, #C7805C));
        color: white;
        border: none;
        padding: 16px 30px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn-book-now:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(199, 128, 92, 0.35);
        color: white;
    }

    .btn-book-now:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Price Summary Card */
    .price-summary-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .summary-header {
        background: #1a1a2e;
        color: white;
        padding: 20px;
    }

    .summary-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .summary-body {
        padding: 20px;
    }

    .selected-package h5 {
        font-weight: 600;
        color: #333;
    }

    .price-breakdown {
        margin-top: 15px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #e9ecef;
    }

    .price-row:last-child {
        border-bottom: none;
    }

    .summary-footer {
        background: #f8f9fa;
        padding: 20px;
        border-top: 2px solid #e9ecef;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
    }

    .total-amount {
        font-size: 1.75rem;
        color: var(--secondary, #90B3A7);
        font-weight: 700;
    }

    .trust-badges {
        padding: 0 20px;
    }

    .trust-badge {
        padding: 15px 10px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .trust-badge i {
        font-size: 1.5rem;
        color: var(--secondary, #90B3A7);
        display: block;
        margin-bottom: 5px;
    }

    .trust-badge small {
        font-size: 0.7rem;
        color: #666;
    }

    .help-box {
        background: #f8f9fa;
        padding: 20px;
        margin: 20px;
        border-radius: 12px;
    }

    .help-box h5 {
        margin: 0 0 5px;
        font-weight: 600;
    }

    /* Flatpickr Customization */
    .flatpickr-calendar {
        box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
        border-radius: 12px !important;
    }

    .flatpickr-day.availability-available {
        background: rgba(25,135,84,0.1);
    }

    .flatpickr-day.availability-limited {
        background: rgba(255,193,7,0.2);
        color: #856404;
    }

    .flatpickr-day.availability-full {
        background: rgba(220,53,69,0.1);
        color: #dc3545;
        text-decoration: line-through;
    }

    /* Cancellation Modal */
    .cancellation-timeline .cancel-item {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .cancellation-timeline .cancel-item:last-child {
        border-bottom: none;
    }

    .cancel-time {
        font-weight: 500;
    }

    /* Mobile Responsive */
    @media (max-width: 991px) {
        .price-summary-card {
            position: static !important;
            margin-top: 30px;
        }
    }

    @media (max-width: 576px) {
        .booking-form {
            padding: 20px;
        }
        
        .form-header {
            padding: 20px;
        }
        
        .step-header {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
