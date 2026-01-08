<!-- Page hero Start -->
<?php $this->load->view('pages/sections/page-hero-v3'); ?>
<!-- Page Hero End -->

<!-- ============================================
     SAFARI ENQUIRY FORM - V3 Premium Design
     ============================================ -->
<section class="enquiry-section-v3 py-6" id="enquiry">
    <div class="container">
        <!-- Section Header -->
        <div class="row mb-5">
            <div class="col-12 text-center" data-aos="fade-up">
                <span class="section-tag">🦁 START YOUR ADVENTURE</span>
                <h2 class="section-title-v3">
                    Plan Your <span class="text-gradient">Dream Safari</span>
                </h2>
                <p class="section-subtitle mx-auto">
                    Tell us about your ideal safari experience and we'll create a personalized itinerary just for you
                </p>
            </div>
        </div>
        
        <!-- Flash Messages -->
        <?php if($this->session->flashdata('error')): ?>
        <div class="row mb-4">
            <div class="col-lg-10 mx-auto" data-aos="fade-up">
                <div class="alert-v3 alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span><?php echo $this->session->flashdata('error'); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('success')): ?>
        <div class="row mb-4">
            <div class="col-lg-10 mx-auto" data-aos="fade-up">
                <div class="alert-v3 alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?php echo $this->session->flashdata('success'); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php $form_data = $this->session->flashdata('form_data') ?? []; ?>
        
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up">
                <div class="enquiry-form-wrapper">
                    <!-- Form Header -->
                    <div class="form-intro">
                        <div class="form-intro-icon">🌍</div>
                        <div class="form-intro-content">
                            <h3>Free Safari Consultation</h3>
                            <p>Fill out the form below and our safari experts will get back to you within 24 hours with a personalized quote.</p>
                        </div>
                    </div>
                    
                    <form action="<?php echo base_url('enquiry/submit'); ?>" method="POST" class="enquiry-form-v3" id="enquiryForm">
                        <!-- CSRF Token -->
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        
                        <!-- Honeypot field -->
                        <div class="hp-field" aria-hidden="true">
                            <label for="website_url">Leave this empty</label>
                            <input type="text" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
                        </div>
                        
                        <!-- ========== PERSONAL DETAILS ========== -->
                        <div class="form-section">
                            <div class="form-section-header">
                                <span class="form-section-icon">👤</span>
                                <h4>Personal Details</h4>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group-v3">
                                        <label for="full_name"><i class="bi bi-person"></i> Full Name <span class="required">*</span></label>
                                        <input type="text" class="form-control-v3" id="full_name" name="full_name" placeholder="John Doe" required minlength="2" maxlength="100" value="<?php echo isset($form_data['full_name']) ? htmlspecialchars($form_data['full_name']) : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-v3">
                                        <label for="email"><i class="bi bi-envelope"></i> Email Address <span class="required">*</span></label>
                                        <input type="email" class="form-control-v3" id="email" name="email" placeholder="john@example.com" required maxlength="150" value="<?php echo isset($form_data['email']) ? htmlspecialchars($form_data['email']) : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-v3">
                                        <label for="phone"><i class="bi bi-telephone"></i> Phone Number <span class="required">*</span></label>
                                        <input type="tel" class="form-control-v3" id="phone" name="phone" placeholder="+1 234 567 8900" required minlength="6" maxlength="30" value="<?php echo isset($form_data['phone']) ? htmlspecialchars($form_data['phone']) : ''; ?>">
                                        <small class="form-hint">Include country code for international calls</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-v3">
                                        <label for="country"><i class="bi bi-globe"></i> Country of Residence</label>
                                        <input type="text" class="form-control-v3" id="country" name="country" placeholder="United States" maxlength="100" value="<?php echo isset($form_data['country']) ? htmlspecialchars($form_data['country']) : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- ========== TRIP DETAILS ========== -->
                        <div class="form-section">
                            <div class="form-section-header">
                                <span class="form-section-icon">🗺️</span>
                                <h4>Trip Details</h4>
                            </div>
                            
                            <div class="row g-4">
                                <!-- Interested Destinations -->
                                <div class="col-12">
                                    <div class="form-group-v3">
                                        <label><i class="bi bi-geo-alt"></i> Interested Destinations</label>
                                        <p class="form-sublabel">Select all that interest you</p>
                                        <div class="checkbox-grid">
                                            <?php 
                                            $destinations = [
                                                'Serengeti' => '🦁 Serengeti National Park',
                                                'Ngorongoro' => '🌋 Ngorongoro Crater',
                                                'Kilimanjaro' => '🏔️ Mount Kilimanjaro',
                                                'Zanzibar' => '🏝️ Zanzibar Island',
                                                'Tarangire' => '🐘 Tarangire National Park',
                                                'Lake Manyara' => '🦩 Lake Manyara',
                                                'Ruaha' => '🦓 Ruaha National Park',
                                                'Selous/Nyerere' => '🐊 Selous/Nyerere Reserve'
                                            ];
                                            $selected_destinations = isset($form_data['destinations']) ? $form_data['destinations'] : [];
                                            foreach ($destinations as $value => $label): 
                                            ?>
                                            <label class="checkbox-card">
                                                <input type="checkbox" name="destinations[]" value="<?php echo $value; ?>" <?php echo in_array($value, $selected_destinations) ? 'checked' : ''; ?>>
                                                <span class="checkbox-card-content">
                                                    <?php echo $label; ?>
                                                </span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Trip Type -->
                                <div class="col-md-6">
                                    <div class="form-group-v3">
                                        <label for="trip_type"><i class="bi bi-compass"></i> Trip Type <span class="required">*</span></label>
                                        <select class="form-control-v3" id="trip_type" name="trip_type" required>
                                            <option value="">Select trip type...</option>
                                            <option value="Safari Only" <?php echo (isset($form_data['trip_type']) && $form_data['trip_type'] == 'Safari Only') ? 'selected' : ''; ?>>🦁 Safari Only</option>
                                            <option value="Beach Only" <?php echo (isset($form_data['trip_type']) && $form_data['trip_type'] == 'Beach Only') ? 'selected' : ''; ?>>🏖️ Beach Only</option>
                                            <option value="Safari + Beach" <?php echo (isset($form_data['trip_type']) && $form_data['trip_type'] == 'Safari + Beach') ? 'selected' : ''; ?>>🦁🏖️ Safari + Beach</option>
                                            <option value="Mountain Climbing" <?php echo (isset($form_data['trip_type']) && $form_data['trip_type'] == 'Mountain Climbing') ? 'selected' : ''; ?>>🏔️ Mountain Climbing</option>
                                            <option value="Cultural Tour" <?php echo (isset($form_data['trip_type']) && $form_data['trip_type'] == 'Cultural Tour') ? 'selected' : ''; ?>>🎭 Cultural Tour</option>
                                            <option value="Custom" <?php echo (isset($form_data['trip_type']) && $form_data['trip_type'] == 'Custom') ? 'selected' : ''; ?>>✨ Custom Experience</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Trip Duration -->
                                <div class="col-md-6">
                                    <div class="form-group-v3">
                                        <label for="duration"><i class="bi bi-calendar-range"></i> Trip Duration <span class="required">*</span></label>
                                        <select class="form-control-v3" id="duration" name="duration" required>
                                            <option value="">Select duration...</option>
                                            <option value="3-5 days" <?php echo (isset($form_data['duration']) && $form_data['duration'] == '3-5 days') ? 'selected' : ''; ?>>3-5 Days</option>
                                            <option value="6-8 days" <?php echo (isset($form_data['duration']) && $form_data['duration'] == '6-8 days') ? 'selected' : ''; ?>>6-8 Days</option>
                                            <option value="9-12 days" <?php echo (isset($form_data['duration']) && $form_data['duration'] == '9-12 days') ? 'selected' : ''; ?>>9-12 Days</option>
                                            <option value="2+ weeks" <?php echo (isset($form_data['duration']) && $form_data['duration'] == '2+ weeks') ? 'selected' : ''; ?>>2+ Weeks</option>
                                            <option value="Flexible" <?php echo (isset($form_data['duration']) && $form_data['duration'] == 'Flexible') ? 'selected' : ''; ?>>Flexible / Not Sure</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Travel Dates -->
                                <div class="col-md-6">
                                    <div class="form-group-v3">
                                        <label for="travel_date_from"><i class="bi bi-calendar-event"></i> Approximate Travel Dates</label>
                                        <div class="date-range-inputs">
                                            <input type="date" class="form-control-v3" id="travel_date_from" name="travel_date_from" min="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($form_data['travel_date_from']) ? $form_data['travel_date_from'] : ''; ?>">
                                            <span class="date-separator">to</span>
                                            <input type="date" class="form-control-v3" id="travel_date_to" name="travel_date_to" min="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($form_data['travel_date_to']) ? $form_data['travel_date_to'] : ''; ?>">
                                        </div>
                                        <small class="form-hint">Leave empty if dates are flexible</small>
                                    </div>
                                </div>
                                
                                <!-- Number of Travelers -->
                                <div class="col-md-6">
                                    <div class="form-group-v3">
                                        <label><i class="bi bi-people"></i> Number of Travelers <span class="required">*</span></label>
                                        <div class="travelers-inputs">
                                            <div class="traveler-input">
                                                <label for="adults">Adults</label>
                                                <select class="form-control-v3" id="adults" name="adults" required>
                                                    <?php for($i = 1; $i <= 20; $i++): ?>
                                                    <option value="<?php echo $i; ?>" <?php echo (isset($form_data['adults']) && $form_data['adults'] == $i) ? 'selected' : ($i == 2 && !isset($form_data['adults']) ? 'selected' : ''); ?>><?php echo $i; ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="traveler-input">
                                                <label for="children">Children</label>
                                                <select class="form-control-v3" id="children" name="children" onchange="toggleChildrenAges()">
                                                    <?php for($i = 0; $i <= 10; $i++): ?>
                                                    <option value="<?php echo $i; ?>" <?php echo (isset($form_data['children']) && $form_data['children'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Children Ages -->
                                <div class="col-12" id="children-ages-wrapper" style="display: none;">
                                    <div class="form-group-v3">
                                        <label for="children_ages"><i class="bi bi-person-badge"></i> Children's Ages</label>
                                        <input type="text" class="form-control-v3" id="children_ages" name="children_ages" placeholder="e.g., 5, 8, 12" maxlength="100" value="<?php echo isset($form_data['children_ages']) ? htmlspecialchars($form_data['children_ages']) : ''; ?>">
                                        <small class="form-hint">Enter ages separated by commas</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- ========== PREFERENCES ========== -->
                        <div class="form-section">
                            <div class="form-section-header">
                                <span class="form-section-icon">⭐</span>
                                <h4>Preferences</h4>
                            </div>
                            
                            <div class="row g-4">
                                <!-- Accommodation Level -->
                                <div class="col-md-6">
                                    <div class="form-group-v3">
                                        <label for="accommodation"><i class="bi bi-building"></i> Accommodation Level <span class="required">*</span></label>
                                        <select class="form-control-v3" id="accommodation" name="accommodation" required>
                                            <option value="">Select accommodation...</option>
                                            <option value="Budget/Camping" <?php echo (isset($form_data['accommodation']) && $form_data['accommodation'] == 'Budget/Camping') ? 'selected' : ''; ?>>🏕️ Budget / Camping</option>
                                            <option value="Mid-range Lodge" <?php echo (isset($form_data['accommodation']) && $form_data['accommodation'] == 'Mid-range Lodge') ? 'selected' : ''; ?>>🏨 Mid-range Lodge</option>
                                            <option value="Luxury Lodge" <?php echo (isset($form_data['accommodation']) && $form_data['accommodation'] == 'Luxury Lodge') ? 'selected' : ''; ?>>🏰 Luxury Lodge</option>
                                            <option value="Mixed" <?php echo (isset($form_data['accommodation']) && $form_data['accommodation'] == 'Mixed') ? 'selected' : ''; ?>>🎯 Mixed (Combination)</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Budget Range -->
                                <div class="col-md-6">
                                    <div class="form-group-v3">
                                        <label for="budget"><i class="bi bi-cash-stack"></i> Budget Range (per person) <span class="required">*</span></label>
                                        <select class="form-control-v3" id="budget" name="budget" required>
                                            <option value="">Select budget...</option>
                                            <option value="Under $1,500" <?php echo (isset($form_data['budget']) && $form_data['budget'] == 'Under $1,500') ? 'selected' : ''; ?>>Under $1,500</option>
                                            <option value="$1,500 - $3,000" <?php echo (isset($form_data['budget']) && $form_data['budget'] == '$1,500 - $3,000') ? 'selected' : ''; ?>>$1,500 - $3,000</option>
                                            <option value="$3,000 - $5,000" <?php echo (isset($form_data['budget']) && $form_data['budget'] == '$3,000 - $5,000') ? 'selected' : ''; ?>>$3,000 - $5,000</option>
                                            <option value="$5,000+" <?php echo (isset($form_data['budget']) && $form_data['budget'] == '$5,000+') ? 'selected' : ''; ?>>$5,000+</option>
                                            <option value="Not sure" <?php echo (isset($form_data['budget']) && $form_data['budget'] == 'Not sure') ? 'selected' : ''; ?>>Not sure / Flexible</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Special Interests -->
                                <div class="col-12">
                                    <div class="form-group-v3">
                                        <label><i class="bi bi-stars"></i> Special Interests</label>
                                        <p class="form-sublabel">What experiences interest you most?</p>
                                        <div class="checkbox-grid interests-grid">
                                            <?php 
                                            $interests = [
                                                'Big Five' => '🦁 Big Five Safari',
                                                'Great Migration' => '🦓 Great Migration',
                                                'Bird Watching' => '🦅 Bird Watching',
                                                'Photography' => '📷 Wildlife Photography',
                                                'Walking Safaris' => '🚶 Walking Safaris',
                                                'Night Game Drives' => '🌙 Night Game Drives',
                                                'Hot Air Balloon' => '🎈 Hot Air Balloon'
                                            ];
                                            $selected_interests = isset($form_data['interests']) ? $form_data['interests'] : [];
                                            foreach ($interests as $value => $label): 
                                            ?>
                                            <label class="checkbox-card">
                                                <input type="checkbox" name="interests[]" value="<?php echo $value; ?>" <?php echo in_array($value, $selected_interests) ? 'checked' : ''; ?>>
                                                <span class="checkbox-card-content">
                                                    <?php echo $label; ?>
                                                </span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- ========== ADDITIONAL INFORMATION ========== -->
                        <div class="form-section">
                            <div class="form-section-header">
                                <span class="form-section-icon">📝</span>
                                <h4>Additional Information</h4>
                            </div>
                            
                            <div class="row g-4">
                                <!-- Special Requirements -->
                                <div class="col-12">
                                    <div class="form-group-v3">
                                        <label for="special_requirements"><i class="bi bi-chat-left-text"></i> Special Requirements / Questions</label>
                                        <textarea class="form-control-v3" id="special_requirements" name="special_requirements" rows="4" placeholder="Tell us about any special requirements, dietary needs, mobility considerations, or questions you have..." maxlength="2000"><?php echo isset($form_data['special_requirements']) ? htmlspecialchars($form_data['special_requirements']) : ''; ?></textarea>
                                    </div>
                                </div>
                                
                                <!-- How did you hear about us -->
                                <div class="col-md-6">
                                    <div class="form-group-v3">
                                        <label for="hear_about_us"><i class="bi bi-megaphone"></i> How did you hear about us?</label>
                                        <select class="form-control-v3" id="hear_about_us" name="hear_about_us">
                                            <option value="">Select an option...</option>
                                            <option value="Google Search" <?php echo (isset($form_data['hear_about_us']) && $form_data['hear_about_us'] == 'Google Search') ? 'selected' : ''; ?>>Google Search</option>
                                            <option value="Social Media" <?php echo (isset($form_data['hear_about_us']) && $form_data['hear_about_us'] == 'Social Media') ? 'selected' : ''; ?>>Social Media</option>
                                            <option value="TripAdvisor" <?php echo (isset($form_data['hear_about_us']) && $form_data['hear_about_us'] == 'TripAdvisor') ? 'selected' : ''; ?>>TripAdvisor</option>
                                            <option value="Friend/Family" <?php echo (isset($form_data['hear_about_us']) && $form_data['hear_about_us'] == 'Friend/Family') ? 'selected' : ''; ?>>Friend / Family Recommendation</option>
                                            <option value="Travel Agent" <?php echo (isset($form_data['hear_about_us']) && $form_data['hear_about_us'] == 'Travel Agent') ? 'selected' : ''; ?>>Travel Agent</option>
                                            <option value="Returning Customer" <?php echo (isset($form_data['hear_about_us']) && $form_data['hear_about_us'] == 'Returning Customer') ? 'selected' : ''; ?>>Returning Customer</option>
                                            <option value="Other" <?php echo (isset($form_data['hear_about_us']) && $form_data['hear_about_us'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Newsletter -->
                                <div class="col-md-6">
                                    <div class="form-group-v3">
                                        <label class="checkbox-label-standalone">
                                            <input type="checkbox" name="newsletter" value="1" <?php echo (isset($form_data['newsletter']) && $form_data['newsletter']) ? 'checked' : ''; ?>>
                                            <span>
                                                <i class="bi bi-envelope-heart"></i>
                                                Subscribe to our newsletter for safari tips, special offers, and travel inspiration
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- ========== SAFARI CAPTCHA ========== -->
                        <div class="form-section">
                            <div class="safari-captcha" id="safari-captcha-enquiry">
                                <div class="captcha-header">
                                    <span class="captcha-icon">🦁</span>
                                    <span class="captcha-title">Safari Check</span>
                                    <span class="captcha-subtitle">Prove you're not a sneaky hyena bot!</span>
                                </div>
                                <?php
                                $safari_questions = [
                                    ['q' => '🦓 What color are a zebra\'s stripes?', 'a' => 'black', 'hint' => 'Not white...'],
                                    ['q' => '🦁 Who is the "King of the Jungle"?', 'a' => 'lion', 'hint' => 'Starts with L...'],
                                    ['q' => '🐘 Which animal never forgets?', 'a' => 'elephant', 'hint' => 'Has a trunk...'],
                                    ['q' => '🦒 Which animal has the longest neck?', 'a' => 'giraffe', 'hint' => 'Reaches treetops...'],
                                    ['q' => '🦛 What\'s the most dangerous animal in Africa?', 'a' => 'hippo', 'hint' => 'Lives in water...'],
                                    ['q' => '🐆 Spots or stripes: What does a leopard have?', 'a' => 'spots', 'hint' => 'Not stripes...'],
                                    ['q' => '🌍 Mount Kilimanjaro is in which country?', 'a' => 'tanzania', 'hint' => 'You\'re booking with us!'],
                                    ['q' => '🦩 What color is a flamingo?', 'a' => 'pink', 'hint' => 'Think about it...'],
                                    ['q' => '🐆 Is a cheetah fast or slow?', 'a' => 'fast', 'hint' => 'Fastest land animal!'],
                                    ['q' => '🦁 The Big 5: Lion, Leopard, Elephant, Buffalo and...?', 'a' => 'rhino', 'hint' => 'Has a horn...'],
                                ];
                                $random_key = array_rand($safari_questions);
                                $captcha = $safari_questions[$random_key];
                                $this->session->set_userdata('safari_captcha_enquiry', strtolower($captcha['a']));
                                ?>
                                <div class="captcha-question" id="captcha-question-enquiry">
                                    <?php echo $captcha['q']; ?>
                                </div>
                                <div class="captcha-input-wrapper">
                                    <input type="text" class="form-control-v3 captcha-input" name="safari_answer" id="safari-answer-enquiry" placeholder="Your answer..." required autocomplete="off">
                                    <span class="captcha-hint" id="captcha-hint-enquiry" title="<?php echo $captcha['hint']; ?>">💡 Hint</span>
                                </div>
                                <div class="captcha-refresh">
                                    <button type="button" class="btn-refresh-captcha" id="refresh-captcha-enquiry" data-type="enquiry">
                                        <i class="bi bi-arrow-clockwise"></i>
                                        <span>Too hard? Try another question</span>
                                        <span class="refresh-count">(3 left)</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="form-submit-wrapper">
                            <button type="submit" name="submit" class="btn-submit-v3">
                                <span>Submit Enquiry</span>
                                <i class="bi bi-send-fill"></i>
                            </button>
                            <p class="submit-note">
                                <i class="bi bi-shield-check"></i>
                                Your information is secure. We'll respond within 24 hours.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Contact Quick Info -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="quick-contact-bar" data-aos="fade-up">
                    <div class="quick-contact-item">
                        <i class="bi bi-telephone-fill"></i>
                        <div>
                            <span>Call Us</span>
                            <a href="tel:+<?php echo $consult_number_call; ?>">+255 787 033 777</a>
                        </div>
                    </div>
                    <div class="quick-contact-item">
                        <i class="bi bi-whatsapp"></i>
                        <div>
                            <span>WhatsApp</span>
                            <a href="https://wa.me/<?php echo $consult_number_call; ?>?text=Hi!%20I'd%20like%20to%20enquire%20about%20a%20safari" target="_blank">Chat Now</a>
                        </div>
                    </div>
                    <div class="quick-contact-item">
                        <i class="bi bi-envelope-fill"></i>
                        <div>
                            <span>Email</span>
                            <a href="mailto:<?php echo $email_address; ?>"><?php echo $email_address; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ============ ENQUIRY SECTION V3 ============ */

.enquiry-section-v3 {
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 50%, #ffffff 100%);
    position: relative;
    margin-top: -2px;
}

/* Remove any HR lines that might appear */
.enquiry-section-v3 hr,
.enquiry-section-v3::before {
    display: none !important;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #666;
    max-width: 600px;
}

/* Honeypot - Hidden from users */
.hp-field {
    position: absolute;
    left: -9999px;
    top: -9999px;
    opacity: 0;
    pointer-events: none;
    height: 0;
    width: 0;
    overflow: hidden;
}

/* Alerts */
.alert-v3 {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 18px 25px;
    border-radius: 12px;
    font-weight: 500;
}

.alert-v3 i {
    font-size: 1.3rem;
}

.alert-error {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    color: #dc2626;
    border: 1px solid #fecaca;
}

.alert-success {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    color: #16a34a;
    border: 1px solid #bbf7d0;
}

/* Form Wrapper */
.enquiry-form-wrapper {
    background: white;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    overflow: hidden;
}

/* Form Intro */
.form-intro {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 30px 40px;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    color: white;
}

.form-intro-icon {
    font-size: 3rem;
    flex-shrink: 0;
}

.form-intro-content h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.form-intro-content p {
    margin: 0;
    opacity: 0.85;
    font-size: 0.95rem;
}

/* Form Sections */
.enquiry-form-v3 {
    padding: 40px;
}

.form-section {
    margin-bottom: 35px;
    padding-bottom: 35px;
    border-bottom: 1px solid #e5e7eb;
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 20px;
    padding-bottom: 0;
}

.form-section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 25px;
}

.form-section-icon {
    font-size: 1.5rem;
}

.form-section-header h4 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
}

/* Form Groups */
.form-group-v3 {
    position: relative;
}

.form-group-v3 label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.95rem;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 10px;
}

.form-group-v3 label i {
    color: #0d6efd;
}

.form-group-v3 .required {
    color: #dc2626;
}

.form-sublabel {
    font-size: 0.85rem;
    color: #666;
    margin: -5px 0 12px;
}

.form-hint {
    display: block;
    font-size: 0.8rem;
    color: #888;
    margin-top: 6px;
}

.form-control-v3 {
    width: 100%;
    padding: 14px 18px;
    font-size: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    background: #f9fafb;
    transition: all 0.3s ease;
    outline: none;
}

.form-control-v3:focus {
    border-color: #0d6efd;
    background: white;
    box-shadow: 0 0 0 4px rgba(13,110,253,0.1);
}

.form-control-v3::placeholder {
    color: #9ca3af;
}

textarea.form-control-v3 {
    resize: vertical;
    min-height: 120px;
}

select.form-control-v3 {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 15px center;
    padding-right: 45px;
}

/* Checkbox Grid */
.checkbox-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 12px;
}

.interests-grid {
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
}

.checkbox-card {
    display: block;
    cursor: pointer;
}

.checkbox-card input {
    display: none;
}

.checkbox-card-content {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 14px 18px;
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.checkbox-card input:checked + .checkbox-card-content {
    background: linear-gradient(135deg, rgba(199, 128, 92, 0.1) 0%, rgba(199, 128, 92, 0.15) 100%);
    border-color: var(--primary, #C7805C);
    color: var(--primary, #C7805C);
}

.checkbox-card:hover .checkbox-card-content {
    border-color: var(--primary, #C7805C);
}

/* Date Range Inputs */
.date-range-inputs {
    display: flex;
    align-items: center;
    gap: 12px;
}

.date-range-inputs .form-control-v3 {
    flex: 1;
}

.date-separator {
    font-weight: 600;
    color: #666;
}

/* Travelers Inputs */
.travelers-inputs {
    display: flex;
    gap: 20px;
}

.traveler-input {
    flex: 1;
}

.traveler-input label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: #666;
    margin-bottom: 8px;
}

/* Standalone Checkbox */
.checkbox-label-standalone {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    cursor: pointer;
    padding: 20px;
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.checkbox-label-standalone:hover {
    border-color: var(--primary, #C7805C);
}

.checkbox-label-standalone input {
    width: 20px;
    height: 20px;
    margin-top: 2px;
    accent-color: var(--primary, #C7805C);
}

.checkbox-label-standalone span {
    font-size: 0.95rem;
    color: #1a1a2e;
}

.checkbox-label-standalone span i {
    color: var(--primary, #C7805C);
    margin-right: 6px;
}

/* Safari Fun CAPTCHA */
.safari-captcha {
    background: linear-gradient(135deg, #fef9e7 0%, #fdebd0 100%);
    border: 2px solid #f5b041;
    border-radius: 16px;
    padding: 25px;
    position: relative;
    overflow: hidden;
}

.safari-captcha::before {
    content: '🌿';
    position: absolute;
    right: -10px;
    top: -10px;
    font-size: 4rem;
    opacity: 0.15;
    transform: rotate(15deg);
}

.captcha-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    flex-wrap: wrap;
}

.captcha-icon {
    font-size: 1.8rem;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

.captcha-title {
    font-weight: 700;
    font-size: 1.1rem;
    color: #b7950b;
}

.captcha-subtitle {
    font-size: 0.85rem;
    color: #7d6608;
    font-style: italic;
}

.captcha-question {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 12px;
    padding: 12px 18px;
    background: white;
    border-radius: 10px;
    border-left: 4px solid #f5b041;
    transition: opacity 0.2s ease;
}

.captcha-input-wrapper {
    display: flex;
    gap: 10px;
    align-items: center;
}

.captcha-input {
    flex: 1;
    text-transform: lowercase;
}

.captcha-hint {
    cursor: help;
    padding: 10px 15px;
    background: #f5b041;
    border-radius: 8px;
    font-size: 0.9rem;
    white-space: nowrap;
    transition: all 0.3s ease;
    font-weight: 500;
}

.captcha-hint:hover {
    background: #d4ac0d;
    transform: scale(1.05);
}

.captcha-refresh {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px dashed #f5b041;
}

.btn-refresh-captcha {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    border: none;
    color: #7d6608;
    font-size: 0.9rem;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-refresh-captcha:hover {
    background: rgba(245, 176, 65, 0.3);
    color: #5d4e06;
}

.btn-refresh-captcha:hover i {
    animation: spin 0.5s ease;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.btn-refresh-captcha.loading i {
    animation: spin 1s linear infinite;
}

.btn-refresh-captcha:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.refresh-count {
    font-weight: 600;
    color: #b7950b;
}

.btn-refresh-captcha.no-refreshes {
    color: #dc3545;
}

.btn-refresh-captcha.no-refreshes .refresh-count {
    color: #dc3545;
}

/* Submit Wrapper */
.form-submit-wrapper {
    text-align: center;
    margin-top: 30px;
}

.btn-submit-v3 {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 18px 50px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 1.15rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(199, 128, 92, 0.3);
}

.btn-submit-v3:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(199, 128, 92, 0.4);
}

.btn-submit-v3 i {
    transition: transform 0.3s ease;
}

.btn-submit-v3:hover i {
    transform: translateX(5px);
}

.submit-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 15px;
    font-size: 0.9rem;
    color: #666;
}

.submit-note i {
    color: #198754;
}

/* Quick Contact Bar */
.quick-contact-bar {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 30px;
    padding: 30px 40px;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    border-radius: 20px;
}

.quick-contact-item {
    display: flex;
    align-items: center;
    gap: 15px;
    color: white;
}

.quick-contact-item i {
    font-size: 1.8rem;
    color: var(--primary, #C7805C);
}

.quick-contact-item span {
    display: block;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.7);
}

.quick-contact-item a {
    color: white;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: color 0.3s ease;
}

.quick-contact-item a:hover {
    color: var(--primary, #C7805C);
}

/* Responsive */
@media (max-width: 991px) {
    .form-intro {
        flex-direction: column;
        text-align: center;
        padding: 25px 30px;
    }
    
    .enquiry-form-v3 {
        padding: 30px;
    }
}

@media (max-width: 768px) {
    .enquiry-form-v3 {
        padding: 25px 20px;
    }
    
    .form-intro {
        padding: 20px;
    }
    
    .form-intro-icon {
        font-size: 2.5rem;
    }
    
    .form-intro-content h3 {
        font-size: 1.3rem;
    }
    
    .checkbox-grid {
        grid-template-columns: 1fr;
    }
    
    .date-range-inputs {
        flex-direction: column;
    }
    
    .date-separator {
        display: none;
    }
    
    .travelers-inputs {
        flex-direction: column;
        gap: 15px;
    }
    
    .captcha-input-wrapper {
        flex-direction: column;
    }
    
    .captcha-hint {
        align-self: flex-start;
    }
    
    .quick-contact-bar {
        flex-direction: column;
        align-items: center;
        gap: 20px;
        padding: 25px 20px;
    }
    
    .btn-submit-v3 {
        width: 100%;
        padding: 16px 30px;
    }
}

@media (max-width: 576px) {
    .captcha-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .btn-refresh-captcha {
        font-size: 0.8rem;
        flex-wrap: wrap;
    }
    
    .form-section-header h4 {
        font-size: 1.1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle children ages input
    window.toggleChildrenAges = function() {
        const childrenSelect = document.getElementById('children');
        const agesWrapper = document.getElementById('children-ages-wrapper');
        
        if (parseInt(childrenSelect.value) > 0) {
            agesWrapper.style.display = 'block';
        } else {
            agesWrapper.style.display = 'none';
        }
    };
    
    // Initialize on load
    toggleChildrenAges();
    
    // Safari CAPTCHA Refresh Handler
    const refreshBtn = document.getElementById('refresh-captcha-enquiry');
    
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            const btn = this;
            const type = btn.dataset.type;
            const questionEl = document.getElementById('captcha-question-enquiry');
            const hintEl = document.getElementById('captcha-hint-enquiry');
            const inputEl = document.getElementById('safari-answer-enquiry');
            const countEl = btn.querySelector('.refresh-count');
            
            btn.disabled = true;
            btn.classList.add('loading');
            
            fetch('<?php echo base_url("enquiry/refresh_captcha"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'type=' + type + '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>'
            })
            .then(response => response.json())
            .then(data => {
                btn.classList.remove('loading');
                
                if (data.success) {
                    questionEl.style.opacity = '0';
                    setTimeout(() => {
                        questionEl.textContent = data.question;
                        questionEl.style.opacity = '1';
                    }, 200);
                    
                    hintEl.title = data.hint;
                    inputEl.value = '';
                    inputEl.focus();
                    countEl.textContent = '(' + data.remaining + ' left)';
                    
                    if (data.remaining === 0) {
                        btn.disabled = true;
                        btn.classList.add('no-refreshes');
                        btn.querySelector('span:not(.refresh-count)').textContent = 'No more refreshes!';
                    } else {
                        btn.disabled = false;
                    }
                } else {
                    btn.disabled = true;
                    btn.classList.add('no-refreshes');
                    countEl.textContent = '(0 left)';
                    btn.querySelector('span:not(.refresh-count)').textContent = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.classList.remove('loading');
                btn.disabled = false;
            });
        });
    }
    
    // Date validation - ensure end date is after start date
    const dateFrom = document.getElementById('travel_date_from');
    const dateTo = document.getElementById('travel_date_to');
    
    if (dateFrom && dateTo) {
        dateFrom.addEventListener('change', function() {
            dateTo.min = this.value;
            if (dateTo.value && dateTo.value < this.value) {
                dateTo.value = this.value;
            }
        });
    }
});
</script>
