<!-- Page hero Start -->
<?php $this->load->view('pages/sections/page-hero-v3'); ?>
<!-- Page Hero End -->

<!-- ============================================
     CONTACT SECTION - V3 Premium Design
     ============================================ -->
<section class="contact-section-v3 py-6" id="contact">
    <div class="container">
        <!-- Section Header -->
        <div class="row mb-5">
            <div class="col-12 text-center" data-aos="fade-up">
                <span class="section-tag">📬 GET IN TOUCH</span>
                <h2 class="section-title-v3">
                    Contact <span class="text-gradient">Us</span>
                </h2>
                <p class="section-subtitle mx-auto">
                    Ready to start your Tanzanian adventure? We're here to help plan your perfect safari
                </p>
            </div>
        </div>
        
        <!-- Flash Messages -->
        <?php if($this->session->flashdata('error')): ?>
        <div class="row mb-4">
            <div class="col-12" data-aos="fade-up">
                <div class="alert-v3 alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span><?php echo $this->session->flashdata('error'); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('success')): ?>
        <div class="row mb-4">
            <div class="col-12" data-aos="fade-up">
                <div class="alert-v3 alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?php echo $this->session->flashdata('success'); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="row g-4">
            <!-- Contact Info Cards -->
            <div class="col-lg-5" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-info-wrapper">
                    <div class="contact-intro">
                        <h3>Let's Start Planning</h3>
                        <p>Your Tanzanian adventure begins with a simple message. Don't hesitate to reach out; we're just a click away.</p>
                    </div>
                    
                    <!-- Contact Cards -->
                    <div class="contact-cards">
                        <div class="contact-card-v3">
                            <div class="contact-icon">
                                📍
                            </div>
                            <div class="contact-details">
                                <h5>Our Office</h5>
                                <p><?php echo $physical_address; ?></p>
                            </div>
                        </div>
                        
                        <div class="contact-card-v3">
                            <div class="contact-icon">
                                📞
                            </div>
                            <div class="contact-details">
                                <h5>Phone Number</h5>
                                <p><a href="tel:<?php echo $phone_number; ?>"><?php echo $phone_number; ?></a></p>
                            </div>
                        </div>
                        
                        <div class="contact-card-v3">
                            <div class="contact-icon">
                                ✉️
                            </div>
                            <div class="contact-details">
                                <h5>Email Address</h5>
                                <p><a href="mailto:<?php echo $email_address; ?>"><?php echo $email_address; ?></a></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Links -->
                    <div class="contact-social">
                        <span>Follow Us:</span>
                        <div class="social-links">
                            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-form-wrapper">
                    <div class="form-header">
                        <h3>Send Us a Message</h3>
                        <p>Fill out the form below and we'll get back to you within 24 hours</p>
                    </div>
                    
                    <form action="<?php echo base_url('contact/contact_query'); ?>" method="POST" class="contact-form-v3">
                        <!-- CSRF Token -->
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        
                        <!-- Honeypot field - hidden from users, bots will fill it -->
                        <div class="hp-field" aria-hidden="true">
                            <label for="website_url">Leave this empty</label>
                            <input type="text" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group-v3">
                                    <label for="name"><i class="bi bi-person"></i> Your Name</label>
                                    <input type="text" class="form-control-v3" id="name" name="full_name" placeholder="John Doe" required minlength="2" maxlength="100">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-v3">
                                    <label for="email"><i class="bi bi-envelope"></i> Your Email</label>
                                    <input type="email" class="form-control-v3" id="email" name="email_address" placeholder="john@example.com" required maxlength="150">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group-v3">
                                    <label for="subject"><i class="bi bi-chat-left-text"></i> Subject</label>
                                    <input type="text" class="form-control-v3" id="subject" name="subject" placeholder="How can we help you?" required minlength="3" maxlength="200">
                                </div>
                            </div>
                            <div class="col-12">
                                                                            <div class="form-group-v3">
                                                                                <label for="message"><i class="bi bi-pencil-square"></i> Message</label>
                                                                                <textarea class="form-control-v3" id="message" name="message" rows="5" placeholder="Tell us about your dream safari..." required minlength="10" maxlength="2000"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <!-- Safari Fun CAPTCHA -->
                                                                                                                    <div class="col-12">
                                                                                                                        <div class="safari-captcha" id="safari-captcha-contact">
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
                                                                                                                                ['q' => '🦏 How many horns does a rhino have?', 'a' => '2', 'hint' => 'More than 1...'],
                                                                                                                                ['q' => '🌍 Mount Kilimanjaro is in which country?', 'a' => 'tanzania', 'hint' => 'You\'re booking with us!'],
                                                                                                                                ['q' => '🦩 What color is a flamingo?', 'a' => 'pink', 'hint' => 'Think about it...'],
                                                                                                                                ['q' => '🐆 Is a cheetah fast or slow?', 'a' => 'fast', 'hint' => 'Fastest land animal!'],
                                                                                                                                // ADDED QUESTIONS:
                                                                                                                                ['q' => '🦜 Which bird can mimic human speech?', 'a' => 'parrot', 'hint' => 'Colorful bird...'],
                                                                                                                                ['q' => '🐊 What animal has the strongest bite?', 'a' => 'crocodile', 'hint' => 'Lives in rivers...'],
                                                                                                                                ['q' => '🦘 Which animal carries its baby in a pouch?', 'a' => 'kangaroo', 'hint' => 'Hops around...'],
                                                                                                                                ['q' => '🐘 What does an elephant use to drink water?', 'a' => 'trunk', 'hint' => 'Long nose...'],
                                                                                                                                ['q' => '🦓 Where do zebras live?', 'a' => 'africa', 'hint' => 'A continent...'],
                                                                                                                                ['q' => '🦁 What is a group of lions called?', 'a' => 'pride', 'hint' => 'Like "pride of lions"...'],
                                                                                                                                ['q' => '🦒 What do giraffes eat?', 'a' => 'leaves', 'hint' => 'From trees...'],
                                                                                                                                ['q' => '🐆 What is the fastest land animal?', 'a' => 'cheetah', 'hint' => 'Spotted cat...'],
                                                                                                                                ['q' => '🦏 What is rhino horn made of?', 'a' => 'keratin', 'hint' => 'Like fingernails...'],
                                                                                                                                ['q' => '🦛 How much time do hippos spend in water?', 'a' => 'day', 'hint' => 'During the...'],
                                                                                                                                ['q' => '🦉 Which bird hunts at night?', 'a' => 'owl', 'hint' => 'Wise bird...'],
                                                                                                                                ['q' => '🐍 Which reptile has no legs?', 'a' => 'snake', 'hint' => 'Slithers...'],
                                                                                                                                ['q' => '🦩 What makes flamingos pink?', 'a' => 'shrimp', 'hint' => 'Their diet...'],
                                                                                                                                ['q' => '🐵 Which primate is known for climbing?', 'a' => 'monkey', 'hint' => 'Loves bananas...'],
                                                                                                                                ['q' => '🦌 Which animal has antlers?', 'a' => 'deer', 'hint' => 'Or stag...'],
                                                                                                                                ['q' => '🐅 What big cat has stripes?', 'a' => 'tiger', 'hint' => 'Orange and black...'],
                                                                                                                                ['q' => '🦓 Are zebras black with white stripes or white with black stripes?', 'a' => 'black', 'hint' => 'The background color...'],
                                                                                                                                ['q' => '🦁 What do lions primarily hunt?', 'a' => 'zebra', 'hint' => 'Or wildebeest...'],
                                                                                                                                ['q' => '🐘 How do elephants communicate?', 'a' => 'trumpet', 'hint' => 'Loud sound...'],
                                                                                                                                ['q' => '🦒 How tall can a giraffe grow?', 'a' => '18', 'hint' => 'In feet...'],
                                                                                                                                ['q' => '🦛 What is a hippo\'s closest relative?', 'a' => 'whale', 'hint' => 'Marine mammal...'],
                                                                                                                                ['q' => '🐆 Can leopards climb trees?', 'a' => 'yes', 'hint' => 'They drag prey up...'],
                                                                                                                                ['q' => '🦏 What does "rhinoceros" mean?', 'a' => 'nose', 'hint' => 'Greek word...'],
                                                                                                                                ['q' => '🌍 What is the largest desert in Africa?', 'a' => 'sahara', 'hint' => 'Very hot...'],
                                                                                                                                ['q' => '🦩 Where do flamingos sleep?', 'a' => 'water', 'hint' => 'Standing up...'],
                                                                                                                                ['q' => '🦜 What do parrots eat?', 'a' => 'nuts', 'hint' => 'And seeds...'],
                                                                                                                                ['q' => '🐊 How long can crocodiles hold their breath?', 'a' => 'hours', 'hint' => 'Multiple...'],
                                                                                                                                ['q' => '🦘 What is a baby kangaroo called?', 'a' => 'joey', 'hint' => 'Cute name...'],
                                                                                                                                ['q' => '🦉 What can owls do with their heads?', 'a' => 'turn', 'hint' => 'Almost all the way...'],
                                                                                                                                ['q' => '🐍 How do snakes move?', 'a' => 'slither', 'hint' => 'No legs...'],
                                                                                                                                ['q' => '🐵 What is a monkey\'s favorite fruit?', 'a' => 'banana', 'hint' => 'Yellow fruit...'],
                                                                                                                                ['q' => '🦌 When do deer shed antlers?', 'a' => 'winter', 'hint' => 'Cold season...'],
                                                                                                                                ['q' => '🐅 Where do tigers live?', 'a' => 'asia', 'hint' => 'Not Africa...'],
                                                                                                                                ['q' => '🦓 Can zebras be ridden?', 'a' => 'no', 'hint' => 'Unlike horses...'],
                                                                                                                                ['q' => '🦁 How many hours do lions sleep?', 'a' => '20', 'hint' => 'Per day...'],
                                                                                                                                ['q' => '🐘 What protects elephant skin?', 'a' => 'mud', 'hint' => 'They roll in it...'],
                                                                                                                                ['q' => '🦒 How many neck bones does a giraffe have?', 'a' => '7', 'hint' => 'Same as humans...'],
                                                                                                                                ['q' => '🦛 Can hippos swim?', 'a' => 'no', 'hint' => 'They walk underwater...'],
                                                                                                                                ['q' => '🐆 What is a leopard\'s favorite tree?', 'a' => 'acacia', 'hint' => 'African tree...']
                                                                                                                            ];
                                                                                                                            // Only generate new question if we don't already have one stored
                                                                                                                            $stored_key = $this->session->userdata('safari_captcha_contact_key');
                                                                                                                            $stored_answer = $this->session->userdata('safari_captcha_contact');
                                                                                                                            if (empty($stored_answer) || !isset($safari_questions[$stored_key])) {
                                                                                                                                $random_key = array_rand($safari_questions);
                                                                                                                                $captcha = $safari_questions[$random_key];
                                                                                                                                $this->session->set_userdata('safari_captcha_contact', strtolower($captcha['a']));
                                                                                                                                $this->session->set_userdata('safari_captcha_contact_key', $random_key);
                                                                                                                            } else {
                                                                                                                                // Use stored key to get the exact original question
                                                                                                                                $captcha = $safari_questions[$stored_key];
                                                                                                                            }
                                                                                                                            ?>
                                                                                                                            <div class="captcha-question" id="captcha-question-contact">
                                                                                                                                <?php echo $captcha['q']; ?>
                                                                                                                            </div>
                                                                                                                            <div class="captcha-input-wrapper">
                                                                                                                                <input type="text" class="form-control-v3 captcha-input" name="safari_answer" id="safari-answer-contact" placeholder="Your answer..." required autocomplete="off">
                                                                                                                                <span class="captcha-hint" id="captcha-hint-contact" title="<?php echo $captcha['hint']; ?>">💡 Hint</span>
                                                                                                                            </div>
                                                                                                                            <div class="captcha-refresh">
                                                                                                                                <button type="button" class="btn-refresh-captcha" id="refresh-captcha-contact" data-type="contact">
                                                                                                                                    <i class="bi bi-arrow-clockwise"></i>
                                                                                                                                    <span>Too hard? Try another question</span>
                                                                                                                                    <span class="refresh-count">(3 left)</span>
                                                                                                                                </button>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                        
                                                                        <div class="col-12">
                                                                            <button type="submit" name="submit" class="btn-submit-v3">
                                    <span>Send Message</span>
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="row mt-5">
            <div class="col-12" data-aos="fade-up">
                <div class="map-wrapper-v3">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d254899.40590343546!2d36.37234219453126!3d-3.3981437999999984!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6a781df6658ee3f5%3A0xef749c62032cd82!2sOsiram%20Safari%20Adventure!5e0!3m2!1sen!2stz!4v1699819560329!5m2!1sen!2stz" 
                        frameborder="0" 
                        allowfullscreen="" 
                        aria-hidden="false"
                        tabindex="0"
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ============ CONTACT SECTION V3 ============ */

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

/* Safari Fun CAPTCHA */
.safari-captcha {
    background: linear-gradient(135deg, #fef9e7 0%, #fdebd0 100%);
    border: 2px solid #f5b041;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 10px;
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
    padding: 10px 15px;
    background: white;
    border-radius: 10px;
    border-left: 4px solid #f5b041;
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
    padding: 8px 12px;
    background: #f5b041;
    border-radius: 8px;
    font-size: 0.85rem;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.captcha-hint:hover {
    background: #d4ac0d;
    transform: scale(1.05);
}

/* Refresh Button */
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

@media (max-width: 576px) {
    .captcha-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .captcha-input-wrapper {
        flex-direction: column;
    }
    
    .captcha-hint {
        align-self: flex-start;
    }
    
    .btn-refresh-captcha {
        font-size: 0.8rem;
        flex-wrap: wrap;
    }
}

.contact-section-v3 {
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #666;
    max-width: 500px;
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

/* Contact Info Wrapper */
.contact-info-wrapper {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    padding: 40px;
    border-radius: 24px;
    height: 100%;
    color: white;
}

.contact-intro h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.contact-intro p {
    color: rgba(255,255,255,0.8);
    line-height: 1.7;
    margin-bottom: 30px;
}

/* Contact Cards */
.contact-cards {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 30px;
}

.contact-card-v3 {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background: rgba(255,255,255,0.08);
    border-radius: 16px;
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.1);
}

.contact-card-v3:hover {
    background: rgba(255,255,255,0.12);
    transform: translateX(10px);
}

.contact-icon {
    width: 55px;
    height: 55px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.contact-details h5 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: rgba(255,255,255,0.7);
}

.contact-details p {
    margin: 0;
    font-size: 1rem;
    color: white;
}

.contact-details a {
    color: white;
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-details a:hover {
    color: var(--primary, #C7805C);
}

/* Social Links */
.contact-social {
    display: flex;
    align-items: center;
    gap: 15px;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.1);
}

.contact-social span {
    color: rgba(255,255,255,0.7);
    font-weight: 500;
}

.social-links {
    display: flex;
    gap: 10px;
}

.social-links a {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-links a:hover {
    background: var(--primary, #C7805C);
    transform: translateY(-3px);
}

/* Contact Form Wrapper */
.contact-form-wrapper {
    background: white;
    padding: 40px;
    border-radius: 24px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.1);
    border: 1px solid rgba(0,0,0,0.05);
}

.form-header {
    margin-bottom: 30px;
}

.form-header h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.form-header p {
    color: #666;
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
    font-size: 0.9rem;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 10px;
}

.form-group-v3 label i {
    color: var(--primary, #C7805C);
}

.form-control-v3 {
    width: 100%;
    padding: 15px 20px;
    font-size: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    background: #f9fafb;
    transition: all 0.3s ease;
    outline: none;
}

.form-control-v3:focus {
    border-color: var(--primary, #C7805C);
    background: white;
    box-shadow: 0 0 0 4px rgba(199, 128, 92, 0.1);
}

.form-control-v3::placeholder {
    color: #9ca3af;
}

textarea.form-control-v3 {
    resize: none;
    min-height: 140px;
}

/* Submit Button */
.btn-submit-v3 {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    width: 100%;
    padding: 18px 35px;
    background: linear-gradient(135deg, var(--primary, #C7805C) 0%, var(--primary-dark, #A8684A) 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
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

/* Map Wrapper */
.map-wrapper-v3 {
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0,0,0,0.1);
    border: 4px solid white;
}

.map-wrapper-v3 iframe {
    width: 100%;
    height: 400px;
    display: block;
}

/* Responsive */
@media (max-width: 991px) {
    .contact-info-wrapper {
        margin-bottom: 30px;
    }
}

@media (max-width: 768px) {
    .contact-info-wrapper,
    .contact-form-wrapper {
        padding: 30px 25px;
    }
    
    .contact-card-v3 {
        padding: 15px;
    }
    
    .contact-icon {
        width: 50px;
        height: 50px;
        font-size: 1.3rem;
    }
    
    .map-wrapper-v3 iframe {
        height: 300px;
    }
    
    .contact-social {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Safari CAPTCHA Refresh Handler
    const refreshBtn = document.getElementById('refresh-captcha-contact');
    
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            const btn = this;
            const type = btn.dataset.type;
            const questionEl = document.getElementById('captcha-question-contact');
            const hintEl = document.getElementById('captcha-hint-contact');
            const inputEl = document.getElementById('safari-answer-contact');
            const countEl = btn.querySelector('.refresh-count');
            
            // Disable button and show loading
            btn.disabled = true;
            btn.classList.add('loading');
            
            // AJAX request
            fetch('<?php echo base_url("contact/refresh_captcha"); ?>', {
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
                    // Update question with animation
                    questionEl.style.opacity = '0';
                    setTimeout(() => {
                        questionEl.textContent = data.question;
                        questionEl.style.opacity = '1';
                    }, 200);
                    
                    // Update hint
                    hintEl.title = data.hint;
                    
                    // Clear input
                    inputEl.value = '';
                    inputEl.focus();
                    
                    // Update count
                    countEl.textContent = '(' + data.remaining + ' left)';
                    
                    if (data.remaining === 0) {
                        btn.disabled = true;
                        btn.classList.add('no-refreshes');
                        btn.querySelector('span:not(.refresh-count)').textContent = 'No more refreshes!';
                    } else {
                        btn.disabled = false;
                    }
                } else {
                    // No more refreshes
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
    
    // Add transition for question
    const questionEl = document.getElementById('captcha-question-contact');
    if (questionEl) {
        questionEl.style.transition = 'opacity 0.2s ease';
    }
});
</script>
