<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Site Settings</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Settings</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Active Template Indicator -->
<div class="alert alert-primary d-flex align-items-center mb-3" role="alert">
    <i class="fas fa-palette me-3 fs-4"></i>
    <div>
        <strong>Editing settings for:</strong> 
        <span class="badge bg-primary fs-6 ms-2"><?= ucfirst($active_template_name ?? 'default') ?></span> template
        <small class="d-block text-muted mt-1">Changes will only affect this template. Switch templates in the "Template" tab to edit other template settings.</small>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <!-- Settings Tabs -->
        <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $active_tab == 'general' ? 'active' : '' ?>" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button">
                    <i class="fas fa-cog me-2"></i>General
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $active_tab == 'contact' ? 'active' : '' ?>" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button">
                    <i class="fas fa-address-book me-2"></i>Contact
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $active_tab == 'social' ? 'active' : '' ?>" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button">
                    <i class="fas fa-share-alt me-2"></i>Social Media
                </button>
            </li>
            <li class="nav-item" role="presentation">
                 <button class="nav-link <?= $active_tab == 'email' ? 'active' : '' ?>" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button">
                     <i class="fas fa-envelope me-2"></i>Email
                 </button>
             </li>
             <!-- Payment Tab - Commented out
             <li class="nav-item" role="presentation">
                  <button class="nav-link <?= $active_tab == 'payment' ? 'active' : '' ?>" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button">
                      <i class="fas fa-credit-card me-2"></i>Payment
                  </button>
              </li>
             -->
             <li class="nav-item" role="presentation">
                  <button class="nav-link <?= $active_tab == 'system' ? 'active' : '' ?>" id="system-tab" data-bs-toggle="tab" data-bs-target="#system" type="button">
                      <i class="fas fa-server me-2"></i>System
                  </button>
              </li>
              <!-- Template Tab - Commented out
              <li class="nav-item" role="presentation">
                                 <button class="nav-link <?= $active_tab == 'template' ? 'active' : '' ?>" id="template-tab" data-bs-toggle="tab" data-bs-target="#template" type="button">
                                     <i class="fas fa-layer-group me-2"></i>Template
                                 </button>
                             </li>
              -->
              
              <!-- Theme Tab - Commented out
              <li class="nav-item" role="presentation">
                                 <button class="nav-link <?= $active_tab == 'theme' ? 'active' : '' ?>" id="theme-tab" data-bs-toggle="tab" data-bs-target="#theme" type="button">
                                     <i class="fas fa-paint-brush me-2"></i>Theme
                                 </button>
                             </li>
              -->
              <li class="nav-item" role="presentation">
                   <button class="nav-link <?= $active_tab == 'seo' ? 'active' : '' ?>" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button">
                       <i class="fas fa-search me-2"></i>SEO AI
                   </button>
               </li>
               <!-- Bulk SMS Tab - Commented out
               <li class="nav-item" role="presentation">
                   <button class="nav-link <?= $active_tab == 'sms' ? 'active' : '' ?>" id="sms-tab" data-bs-toggle="tab" data-bs-target="#sms" type="button">
                       <i class="fas fa-sms me-2"></i>Bulk SMS
                   </button>
               </li>
               -->
               
               <!-- Menus Tab - Commented out
               <li class="nav-item" role="presentation">
                   <button class="nav-link <?= $active_tab == 'menu' ? 'active' : '' ?>" id="menu-tab" data-bs-toggle="tab" data-bs-target="#menu" type="button">
                       <i class="fas fa-bars me-2"></i>Menus
                   </button>
               </li>
               -->
               </ul>

        <!-- Tab Contents -->
        <div class="tab-content" id="settingsTabContent">
            
            <!-- General Settings Tab -->
            <div class="tab-pane fade <?= $active_tab == 'general' ? 'show active' : '' ?>" id="general" role="tabpanel">
                <?= form_open_multipart('admin/settings/save') ?>
                    <input type="hidden" name="active_tab" value="general">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Site Name <span class="text-danger">*</span></label>
                                <input type="text" name="site_name" class="form-control" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Site Tagline</label>
                                <input type="text" name="site_tagline" class="form-control" value="<?= htmlspecialchars($settings['site_tagline'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Site Logo</label>
                                <?php if (!empty($settings['site_logo'])): ?>
                                    <div class="mb-2">
                                        <img src="<?= base_url('assets/images/' . $settings['site_logo']) ?>" alt="Current Logo" class="img-thumbnail" style="max-height: 80px;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="site_logo" class="form-control" accept="image/*">
                                <small class="text-muted">Recommended: 200x60px, PNG or SVG</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Favicon</label>
                                <?php if (!empty($settings['site_favicon'])): ?>
                                    <div class="mb-2">
                                        <img src="<?= base_url('assets/images/' . $settings['site_favicon']) ?>" alt="Current Favicon" class="img-thumbnail" style="max-height: 32px;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="site_favicon" class="form-control" accept="image/*,.ico">
                                <small class="text-muted">Recommended: 32x32px, ICO or PNG</small>
                            </div>
                        </div>
                    </div>

                    <!-- Theme Colors Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-palette me-2"></i>Theme Colors</h5>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Primary Color</label>
                                <div class="input-group">
                                    <input type="color" name="primary_color" class="form-control form-control-color" value="<?= htmlspecialchars($settings['primary_color'] ?? '#C7805C') ?>" title="Choose primary color">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($settings['primary_color'] ?? '#C7805C') ?>" id="primary_color_text" readonly>
                                </div>
                                <small class="text-muted">Terracotta (Main brand color)</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Secondary Color</label>
                                <div class="input-group">
                                    <input type="color" name="secondary_color" class="form-control form-control-color" value="<?= htmlspecialchars($settings['secondary_color'] ?? '#90B3A7') ?>" title="Choose secondary color">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($settings['secondary_color'] ?? '#90B3A7') ?>" id="secondary_color_text" readonly>
                                </div>
                                <small class="text-muted">Sage green (Accent)</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Accent Color</label>
                                <div class="input-group">
                                    <input type="color" name="accent_color" class="form-control form-control-color" value="<?= htmlspecialchars($settings['accent_color'] ?? '#D9B39B') ?>" title="Choose accent color">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($settings['accent_color'] ?? '#D9B39B') ?>" id="accent_color_text" readonly>
                                </div>
                                <small class="text-muted">Beige (Highlights)</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Background Color</label>
                                <div class="input-group">
                                    <input type="color" name="background_color" class="form-control form-control-color" value="<?= htmlspecialchars($settings['background_color'] ?? '#F5F0E1') ?>" title="Choose background color">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($settings['background_color'] ?? '#F5F0E1') ?>" id="background_color_text" readonly>
                                </div>
                                <small class="text-muted">Cream (Light backgrounds)</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Currency</label>
                                <select name="currency" class="form-select">
                                    <option value="USD" <?= ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' ?>>USD - US Dollar</option>
                                    <option value="EUR" <?= ($settings['currency'] ?? '') == 'EUR' ? 'selected' : '' ?>>EUR - Euro</option>
                                    <option value="GBP" <?= ($settings['currency'] ?? '') == 'GBP' ? 'selected' : '' ?>>GBP - British Pound</option>
                                    <option value="TZS" <?= ($settings['currency'] ?? '') == 'TZS' ? 'selected' : '' ?>>TZS - Tanzanian Shilling</option>
                                    <option value="KES" <?= ($settings['currency'] ?? '') == 'KES' ? 'selected' : '' ?>>KES - Kenyan Shilling</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Currency Symbol</label>
                                <input type="text" name="currency_symbol" class="form-control" value="<?= htmlspecialchars($settings['currency_symbol'] ?? '$') ?>" maxlength="5">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Timezone</label>
                                <select name="timezone" class="form-select">
                                    <option value="Africa/Dar_es_Salaam" <?= ($settings['timezone'] ?? '') == 'Africa/Dar_es_Salaam' ? 'selected' : '' ?>>Africa/Dar_es_Salaam (EAT)</option>
                                    <option value="Africa/Nairobi" <?= ($settings['timezone'] ?? '') == 'Africa/Nairobi' ? 'selected' : '' ?>>Africa/Nairobi (EAT)</option>
                                    <option value="UTC" <?= ($settings['timezone'] ?? '') == 'UTC' ? 'selected' : '' ?>>UTC</option>
                                    <option value="Europe/London" <?= ($settings['timezone'] ?? '') == 'Europe/London' ? 'selected' : '' ?>>Europe/London (GMT)</option>
                                    <option value="America/New_York" <?= ($settings['timezone'] ?? '') == 'America/New_York' ? 'selected' : '' ?>>America/New_York (EST)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save General Settings
                        </button>
                    </div>
                <?= form_close() ?>
            </div>

            <!-- Contact Settings Tab -->
            <div class="tab-pane fade <?= $active_tab == 'contact' ? 'show active' : '' ?>" id="contact" role="tabpanel">
                <?= form_open('admin/settings/save') ?>
                    <input type="hidden" name="active_tab" value="contact">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="site_email" class="form-control" value="<?= htmlspecialchars($settings['site_email'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Primary Phone Number</label>
                                <input type="text" name="site_phone" class="form-control" value="<?= htmlspecialchars($settings['site_phone'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Secondary Phone Number</label>
                                <input type="text" name="site_phone_secondary" class="form-control" value="<?= htmlspecialchars($settings['site_phone_secondary'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">WhatsApp Number</label>
                                <input type="text" name="whatsapp_number" class="form-control" value="<?= htmlspecialchars($settings['whatsapp_number'] ?? '') ?>" placeholder="+255123456789">
                                <small class="text-muted">Include country code without spaces or dashes</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="site_address" class="form-control" rows="3"><?= htmlspecialchars($settings['site_address'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Google Maps Embed Code</label>
                        <textarea name="map_embed_code" class="form-control" rows="4" placeholder="<iframe src='...'></iframe>"><?= htmlspecialchars($settings['map_embed_code'] ?? '') ?></textarea>
                        <small class="text-muted">Paste the full iframe embed code from Google Maps</small>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Contact Settings
                        </button>
                    </div>
                <?= form_close() ?>
            </div>

            <!-- Social Media Settings Tab -->
            <div class="tab-pane fade <?= $active_tab == 'social' ? 'show active' : '' ?>" id="social" role="tabpanel">
                <?= form_open('admin/settings/save') ?>
                    <input type="hidden" name="active_tab" value="social">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-facebook text-primary me-2"></i>Facebook URL</label>
                                <input type="url" name="facebook_url" class="form-control" value="<?= htmlspecialchars($settings['facebook_url'] ?? '') ?>" placeholder="https://facebook.com/yourpage">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-instagram text-danger me-2"></i>Instagram URL</label>
                                <input type="url" name="instagram_url" class="form-control" value="<?= htmlspecialchars($settings['instagram_url'] ?? '') ?>" placeholder="https://instagram.com/yourprofile">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-twitter text-info me-2"></i>Twitter/X URL</label>
                                <input type="url" name="twitter_url" class="form-control" value="<?= htmlspecialchars($settings['twitter_url'] ?? '') ?>" placeholder="https://twitter.com/yourhandle">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-youtube text-danger me-2"></i>YouTube URL</label>
                                <input type="url" name="youtube_url" class="form-control" value="<?= htmlspecialchars($settings['youtube_url'] ?? '') ?>" placeholder="https://youtube.com/c/yourchannel">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-linkedin text-primary me-2"></i>LinkedIn URL</label>
                                <input type="url" name="linkedin_url" class="form-control" value="<?= htmlspecialchars($settings['linkedin_url'] ?? '') ?>" placeholder="https://linkedin.com/company/yourcompany">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-tripadvisor text-success me-2"></i>TripAdvisor URL</label>
                                <input type="url" name="tripadvisor_url" class="form-control" value="<?= htmlspecialchars($settings['tripadvisor_url'] ?? '') ?>" placeholder="https://tripadvisor.com/...">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-pinterest text-danger me-2"></i>Pinterest URL</label>
                                <input type="url" name="pinterest_url" class="form-control" value="<?= htmlspecialchars($settings['pinterest_url'] ?? '') ?>" placeholder="https://pinterest.com/yourprofile">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Social Media Settings
                        </button>
                    </div>
                <?= form_close() ?>
            </div>

            <!-- Email Settings Tab -->
            <div class="tab-pane fade <?= $active_tab == 'email' ? 'show active' : '' ?>" id="email" role="tabpanel">
                <?= form_open('admin/settings/save') ?>
                    <input type="hidden" name="active_tab" value="email">
                    
                    <h5 class="mb-3">Notification Emails</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Admin Email</label>
                                <input type="email" name="admin_email" class="form-control" value="<?= htmlspecialchars($settings['admin_email'] ?? '') ?>">
                                <small class="text-muted">Receives system notifications</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Booking Email</label>
                                <input type="email" name="booking_email" class="form-control" value="<?= htmlspecialchars($settings['booking_email'] ?? '') ?>">
                                <small class="text-muted">Receives booking notifications</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Enquiry Email</label>
                                <input type="email" name="enquiry_email" class="form-control" value="<?= htmlspecialchars($settings['enquiry_email'] ?? '') ?>">
                                <small class="text-muted">Receives contact form enquiries</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">SMTP Settings</h5>
                    <p class="text-muted mb-3">Configure SMTP for reliable email delivery. Leave empty to use PHP's default mail function.</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">SMTP Host</label>
                                <input type="text" name="smtp_host" class="form-control" value="<?= htmlspecialchars($settings['smtp_host'] ?? '') ?>" placeholder="smtp.gmail.com">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">SMTP Port</label>
                                <input type="number" name="smtp_port" class="form-control" value="<?= htmlspecialchars($settings['smtp_port'] ?? '587') ?>" placeholder="587">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Encryption</label>
                                <select name="smtp_encryption" class="form-select">
                                    <option value="tls" <?= ($settings['smtp_encryption'] ?? '') == 'tls' ? 'selected' : '' ?>>TLS</option>
                                    <option value="ssl" <?= ($settings['smtp_encryption'] ?? '') == 'ssl' ? 'selected' : '' ?>>SSL</option>
                                    <option value="" <?= ($settings['smtp_encryption'] ?? '') == '' ? 'selected' : '' ?>>None</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">SMTP Username</label>
                                <input type="text" name="smtp_username" class="form-control" value="<?= htmlspecialchars($settings['smtp_username'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">SMTP Password</label>
                                <input type="password" name="smtp_password" class="form-control" placeholder="<?= !empty($settings['smtp_password']) ? '••••••••' : '' ?>">
                                <small class="text-muted">Leave empty to keep current password</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">From Name</label>
                                <input type="text" name="email_from_name" class="form-control" value="<?= htmlspecialchars($settings['email_from_name'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Email Settings
                        </button>
                        <a href="<?= base_url('admin/settings/test_email') ?>" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-paper-plane me-2"></i>Send Test Email
                        </a>
                    </div>
                <?= form_close() ?>
            </div>

            <!-- Payment Settings Tab -->
            <div class="tab-pane fade <?= $active_tab == 'payment' ? 'show active' : '' ?>" id="payment" role="tabpanel">
                <?= form_open('admin/settings/save') ?>
                    <input type="hidden" name="active_tab" value="payment">
                    
                    <h5 class="mb-3"><i class="fas fa-university me-2"></i>Bank Details</h5>
                    <p class="text-muted mb-4">Configure your bank account details for customer payments. These details will be included in invoice and payment emails sent to customers.</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Bank Name <span class="text-danger">*</span></label>
                                <input type="text" name="bank_name" class="form-control" value="<?= htmlspecialchars($settings['bank_name'] ?? '') ?>" placeholder="e.g., Tanzania National Bank" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Account Holder Name <span class="text-danger">*</span></label>
                                <input type="text" name="bank_account_name" class="form-control" value="<?= htmlspecialchars($settings['bank_account_name'] ?? '') ?>" placeholder="e.g., Osiram Safari Ltd" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Account Number <span class="text-danger">*</span></label>
                                <input type="text" name="bank_account_number" class="form-control" value="<?= htmlspecialchars($settings['bank_account_number'] ?? '') ?>" placeholder="e.g., 1234567890" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">SWIFT Code</label>
                                <input type="text" name="bank_swift_code" class="form-control" value="<?= htmlspecialchars($settings['bank_swift_code'] ?? '') ?>" placeholder="e.g., TZNZZZZXXX">
                                <small class="text-muted">Optional - For international transfers</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Bank Branch</label>
                                <input type="text" name="bank_branch" class="form-control" value="<?= htmlspecialchars($settings['bank_branch'] ?? '') ?>" placeholder="e.g., Arusha Main Branch">
                                <small class="text-muted">Optional - Branch location or code</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Bank Currency</label>
                                <select name="bank_currency" class="form-select">
                                    <option value="">-- Select Currency --</option>
                                    <option value="USD" <?= ($settings['bank_currency'] ?? '') == 'USD' ? 'selected' : '' ?>>USD - US Dollar</option>
                                    <option value="TZS" <?= ($settings['bank_currency'] ?? '') == 'TZS' ? 'selected' : '' ?>>TZS - Tanzanian Shilling</option>
                                    <option value="EUR" <?= ($settings['bank_currency'] ?? '') == 'EUR' ? 'selected' : '' ?>>EUR - Euro</option>
                                    <option value="GBP" <?= ($settings['bank_currency'] ?? '') == 'GBP' ? 'selected' : '' ?>>GBP - British Pound</option>
                                    <option value="KES" <?= ($settings['bank_currency'] ?? '') == 'KES' ? 'selected' : '' ?>>KES - Kenyan Shilling</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Additional Payment Instructions</label>
                        <textarea name="bank_additional_info" class="form-control" rows="4" placeholder="e.g., Important notes about payment, reference format, processing times, etc."><?= htmlspecialchars($settings['bank_additional_info'] ?? '') ?></textarea>
                        <small class="text-muted">Optional - Additional information to include in payment emails (e.g., payment reference format, processing times)</small>
                    </div>

                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Preview:</strong> When you use the "Send Bank Details" function for a booking, customers will receive an email with all these details formatted professionally.
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Payment Settings
                        </button>
                    </div>
                <?= form_close() ?>
            </div>

            <!-- System Settings Tab -->
            <div class="tab-pane fade <?= $active_tab == 'system' ? 'show active' : '' ?>" id="system" role="tabpanel">
                <?= form_open('admin/settings/save') ?>
                    <input type="hidden" name="active_tab" value="system">
                    
                    <h5 class="mb-3">Analytics & Tracking</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Google Analytics ID</label>
                                <input type="text" name="google_analytics_id" class="form-control" value="<?= htmlspecialchars($settings['google_analytics_id'] ?? '') ?>" placeholder="G-XXXXXXXXXX or UA-XXXXXXXX-X">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Google Tag Manager ID</label>
                                <input type="text" name="google_tag_manager_id" class="form-control" value="<?= htmlspecialchars($settings['google_tag_manager_id'] ?? '') ?>" placeholder="GTM-XXXXXXX">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Maintenance Mode</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="maintenance_mode" class="form-check-input" id="maintenance_mode" value="1" <?= ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="maintenance_mode">Enable Maintenance Mode</label>
                                </div>
                                <small class="text-muted">When enabled, visitors will see a maintenance page</small>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Maintenance Message</label>
                                <textarea name="maintenance_message" class="form-control" rows="2"><?= htmlspecialchars($settings['maintenance_message'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Cache Settings</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="cache_enabled" class="form-check-input" id="cache_enabled" value="1" <?= ($settings['cache_enabled'] ?? '0') == '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="cache_enabled">Enable Cache</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Cache Duration (seconds)</label>
                                <input type="number" name="cache_duration" class="form-control" value="<?= htmlspecialchars($settings['cache_duration'] ?? '3600') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <a href="<?= base_url('admin/settings/clear_cache') ?>" class="btn btn-outline-warning">
                                        <i class="fas fa-broom me-2"></i>Clear Cache
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">SEO Settings</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="enable_seo" class="form-check-input" id="enable_seo" value="1" <?= ($settings['enable_seo'] ?? '1') == '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="enable_seo">Enable SEO Features</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Default Meta Description</label>
                                <textarea name="default_meta_description" class="form-control" rows="2" maxlength="160"><?= htmlspecialchars($settings['default_meta_description'] ?? '') ?></textarea>
                                <small class="text-muted">Maximum 160 characters. Used when page-specific description is not set.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Default Meta Keywords</label>
                                <input type="text" name="default_meta_keywords" class="form-control" value="<?= htmlspecialchars($settings['default_meta_keywords'] ?? '') ?>">
                                <small class="text-muted">Comma-separated keywords. Used when page-specific keywords are not set.</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save System Settings
                        </button>
                    </div>
                    <?= form_close() ?>
                    </div>

                    <!-- Template Settings Tab -->
                    <div class="tab-pane fade <?= $active_tab == 'template' ? 'show active' : '' ?>" id="template" role="tabpanel">
                    <?= form_open('admin/settings/save') ?>
                    <input type="hidden" name="active_tab" value="template">
                    
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Website Template:</strong> Switch between different website templates. Each template has its own design, layout, and style.
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-layer-group me-2"></i>Available Templates
                                </div>
                                <div class="card-body">
                                    <?php 
                                    $this->load->helper('template');
                                    $templates = get_available_templates();
                                    $active_template = $settings['active_template'] ?? 'tourism';
                                    ?>
                                    
                                    <div class="row">
                                        <?php foreach ($templates as $key => $template): ?>
                                        <div class="col-md-6 mb-4">
                                            <div class="card template-card <?= $active_template == $key ? 'border-primary' : '' ?>" style="cursor: pointer;" onclick="selectTemplate('<?= $key ?>')">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-start">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="active_template" id="template_<?= $key ?>" value="<?= $key ?>" <?= $active_template == $key ? 'checked' : '' ?>>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="card-title mb-1">
                                                                <?= htmlspecialchars($template['display_name']) ?>
                                                                <?php if ($active_template == $key): ?>
                                                                <span class="badge bg-success ms-2">Active</span>
                                                                <?php endif; ?>
                                                            </h5>
                                                            <p class="text-muted small mb-2"><?= htmlspecialchars($template['description']) ?></p>
                                                            <div class="d-flex gap-1 mb-2">
                                                                <?php if (!empty($template['colors'])): ?>
                                                                    <?php foreach ($template['colors'] as $colorName => $colorValue): ?>
                                                                    <div class="rounded-circle" style="width: 20px; height: 20px; background-color: <?= $colorValue ?>; border: 1px solid #ddd;" title="<?= ucfirst($colorName) ?>"></div>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                            <small class="text-muted">
                                                                <i class="fas fa-code-branch me-1"></i>v<?= $template['version'] ?>
                                                                <span class="ms-2"><i class="fas fa-user me-1"></i><?= htmlspecialchars($template['author']) ?></span>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php if (empty($templates)): ?>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        No templates found. Please ensure templates are properly installed in <code>assets/templates/</code>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-info-circle me-2"></i>Template Info
                                </div>
                                <div class="card-body">
                                    <h6>How Templates Work</h6>
                                    <ul class="small mb-3">
                                        <li>Each template has its own CSS, JS, and images</li>
                                        <li>Templates include header, footer, and navigation</li>
                                        <li>Theme colors can still be customized per template</li>
                                        <li>Content and data remain the same across templates</li>
                                    </ul>

                                    <h6>Template Locations</h6>
                                    <ul class="small mb-3">
                                        <li><strong>Assets:</strong> <code>assets/templates/{name}/</code></li>
                                        <li><strong>Views:</strong> <code>views/templates/{name}/</code></li>
                                    </ul>

                                    <div class="alert alert-warning small mb-0">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        <strong>Note:</strong> Switching templates may require a page refresh to see all changes.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Template Settings
                        </button>
                    </div>
                    <?= form_close() ?>
                    
                    <script>
                    // Template colors data from PHP
                    var templateColors = <?= json_encode(array_map(function($t) { 
                        return $t['colors'] ?? []; 
                    }, $templates)) ?>;
                    
                    function selectTemplate(key) {
                        document.getElementById('template_' + key).checked = true;
                        document.querySelectorAll('.template-card').forEach(function(card) {
                            card.classList.remove('border-primary');
                        });
                        document.getElementById('template_' + key).closest('.template-card').classList.add('border-primary');
                        
                        // Update theme color pickers with selected template's colors
                        if (templateColors[key]) {
                            var colors = templateColors[key];
                            updateThemeColorPicker('theme_primary_color', colors.primary);
                            updateThemeColorPicker('theme_secondary_color', colors.secondary);
                            updateThemeColorPicker('theme_accent_color', colors.accent);
                            updateThemeColorPicker('theme_background_color', colors.background);
                            updateThemePreview(colors);
                        }
                    }
                    
                    function updateThemeColorPicker(name, color) {
                        if (!color) return;
                        var colorInput = document.querySelector('input[name="' + name + '"]');
                        if (colorInput) {
                            colorInput.value = color;
                            // Update the hex text input next to it
                            var hexInput = colorInput.closest('.input-group').querySelector('.color-hex');
                            if (hexInput) {
                                hexInput.value = color;
                            }
                            // Update color preview
                            var previewDiv = colorInput.closest('.color-picker-group').querySelector('.color-preview');
                            if (previewDiv) {
                                previewDiv.style.backgroundColor = color;
                            }
                        }
                    }
                    
                    function updateThemePreview(colors) {
                        // Update the live preview buttons
                        var previewSection = document.querySelector('.theme-preview');
                        if (previewSection) {
                            var buttons = previewSection.querySelectorAll('.btn');
                            if (buttons[0] && colors.primary) buttons[0].style.backgroundColor = colors.primary;
                            if (buttons[1] && colors.secondary) buttons[1].style.backgroundColor = colors.secondary;
                            if (buttons[2] && colors.accent) buttons[2].style.backgroundColor = colors.accent;
                            var bgPreview = previewSection.querySelector('.rounded');
                            if (bgPreview && colors.background) bgPreview.style.backgroundColor = colors.background;
                        }
                    }
                    </script>
                    
                    <style>
                    .template-card {
                        transition: all 0.2s ease;
                    }
                    .template-card:hover {
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                        transform: translateY(-2px);
                    }
                    .template-card.border-primary {
                        border-width: 2px !important;
                    }
                    </style>
                    </div>

                    <!-- Theme Settings Tab -->
                    <div class="tab-pane fade <?= $active_tab == 'theme' ? 'show active' : '' ?>" id="theme" role="tabpanel">
                    <?= form_open('admin/settings/save') ?>
                    <input type="hidden" name="active_tab" value="theme">
                    
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Dynamic Theme Settings:</strong> Configure your frontend color scheme below. These colors will automatically apply across the entire website.
                    </div>

                    <!-- Theme Presets -->
                    <h5 class="mb-3"><i class="fas fa-palette me-2"></i>Theme Presets</h5>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="btn-group mb-3" role="group">
                                <button type="button" class="btn btn-outline-secondary preset-btn" data-preset="default">
                                    <i class="fas fa-redo me-2"></i>Default (Safari)
                                </button>
                                <button type="button" class="btn btn-outline-secondary preset-btn" data-preset="modern">
                                    <i class="fas fa-moon me-2"></i>Modern Dark
                                </button>
                                <button type="button" class="btn btn-outline-secondary preset-btn" data-preset="ocean">
                                    <i class="fas fa-water me-2"></i>Ocean Blue
                                </button>
                                <button type="button" class="btn btn-outline-secondary preset-btn" data-preset="tropical">
                                    <i class="fas fa-leaf me-2"></i>Tropical
                                </button>
                            </div>
                            <small class="text-muted d-block">Click a preset to quickly apply a theme, then customize as needed.</small>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Primary Theme Colors Section -->
                    <h5 class="mb-3"><i class="fas fa-swatches me-2"></i>Frontend Color Scheme</h5>
                    <p class="text-muted mb-4">Customize the primary colors used throughout your website frontend.</p>

                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Primary Color</label>
                                <div class="color-picker-group">
                                    <div class="input-group mb-2">
                                        <input type="color" name="theme_primary_color" class="form-control form-control-color color-input" value="<?= htmlspecialchars($settings['theme_primary_color'] ?? '#C7805C') ?>" title="Choose primary color" data-color-type="primary">
                                        <input type="text" class="form-control color-hex" value="<?= htmlspecialchars($settings['theme_primary_color'] ?? '#C7805C') ?>" readonly>
                                    </div>
                                    <div class="color-preview" style="background-color: <?= htmlspecialchars($settings['theme_primary_color'] ?? '#C7805C') ?>;"></div>
                                </div>
                                <small class="text-muted d-block mt-2">Main brand color (buttons, links, headings)</small>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Secondary Color</label>
                                <div class="color-picker-group">
                                    <div class="input-group mb-2">
                                        <input type="color" name="theme_secondary_color" class="form-control form-control-color color-input" value="<?= htmlspecialchars($settings['theme_secondary_color'] ?? '#90B3A7') ?>" title="Choose secondary color" data-color-type="secondary">
                                        <input type="text" class="form-control color-hex" value="<?= htmlspecialchars($settings['theme_secondary_color'] ?? '#90B3A7') ?>" readonly>
                                    </div>
                                    <div class="color-preview" style="background-color: <?= htmlspecialchars($settings['theme_secondary_color'] ?? '#90B3A7') ?>;"></div>
                                </div>
                                <small class="text-muted d-block mt-2">Accent color (sections, borders, highlights)</small>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Accent Color</label>
                                <div class="color-picker-group">
                                    <div class="input-group mb-2">
                                        <input type="color" name="theme_accent_color" class="form-control form-control-color color-input" value="<?= htmlspecialchars($settings['theme_accent_color'] ?? '#D9B39B') ?>" title="Choose accent color" data-color-type="accent">
                                        <input type="text" class="form-control color-hex" value="<?= htmlspecialchars($settings['theme_accent_color'] ?? '#D9B39B') ?>" readonly>
                                    </div>
                                    <div class="color-preview" style="background-color: <?= htmlspecialchars($settings['theme_accent_color'] ?? '#D9B39B') ?>;"></div>
                                </div>
                                <small class="text-muted d-block mt-2">Text accents and special highlights</small>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Background Color</label>
                                <div class="color-picker-group">
                                    <div class="input-group mb-2">
                                        <input type="color" name="theme_background_color" class="form-control form-control-color color-input" value="<?= htmlspecialchars($settings['theme_background_color'] ?? '#F5F0E1') ?>" title="Choose background color" data-color-type="background">
                                        <input type="text" class="form-control color-hex" value="<?= htmlspecialchars($settings['theme_background_color'] ?? '#F5F0E1') ?>" readonly>
                                    </div>
                                    <div class="color-preview" style="background-color: <?= htmlspecialchars($settings['theme_background_color'] ?? '#F5F0E1') ?>;"></div>
                                </div>
                                <small class="text-muted d-block mt-2">Light background elements</small>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Sidebar Background Color</label>
                                <div class="color-picker-group">
                                    <div class="input-group mb-2">
                                        <input type="color" name="theme_sidebar_bg_color" class="form-control form-control-color color-input" value="<?= htmlspecialchars($settings['theme_sidebar_bg_color'] ?? '#F8F9FA') ?>" title="Choose sidebar background color" data-color-type="sidebar">
                                        <input type="text" class="form-control color-hex" value="<?= htmlspecialchars($settings['theme_sidebar_bg_color'] ?? '#F8F9FA') ?>" readonly>
                                    </div>
                                    <div class="color-preview" style="background-color: <?= htmlspecialchars($settings['theme_sidebar_bg_color'] ?? '#F8F9FA') ?>;"></div>
                                </div>
                                <small class="text-muted d-block mt-2">Blog sidebar (search, categories, recent posts)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Theme Options -->
                    <hr class="my-4">
                    <h5 class="mb-3"><i class="fas fa-sliders-h me-2"></i>Theme Options</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="theme_enable_gradients" class="form-check-input" id="theme_enable_gradients" value="1" <?= ($settings['theme_enable_gradients'] ?? '1') == '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="theme_enable_gradients">Enable Color Gradients</label>
                                </div>
                                <small class="text-muted">Use gradient effects based on theme colors</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="theme_enable_shadows" class="form-check-input" id="theme_enable_shadows" value="1" <?= ($settings['theme_enable_shadows'] ?? '1') == '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="theme_enable_shadows">Enable Color Shadows</label>
                                </div>
                                <small class="text-muted">Add subtle shadow effects with theme colors</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Text Color</label>
                                <select name="theme_text_color" class="form-select">
                                    <option value="dark" <?= ($settings['theme_text_color'] ?? 'dark') == 'dark' ? 'selected' : '' ?>>Dark Text (Dark background)</option>
                                    <option value="light" <?= ($settings['theme_text_color'] ?? 'dark') == 'light' ? 'selected' : '' ?>>Light Text (Dark background)</option>
                                </select>
                                <small class="text-muted">Choose text color scheme for better contrast</small>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <hr class="my-4">
                    <h5 class="mb-3"><i class="fas fa-eye me-2"></i>Live Preview</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="theme-preview card p-4" style="border: 2px solid #ddd;">
                                <h6 class="mb-3">Sample Styled Elements:</h6>
                                <button class="btn me-2 mb-2" style="background-color: <?= htmlspecialchars($settings['theme_primary_color'] ?? '#C7805C') ?>; color: white;">Primary Button</button>
                                <button class="btn me-2 mb-2" style="background-color: <?= htmlspecialchars($settings['theme_secondary_color'] ?? '#90B3A7') ?>; color: white;">Secondary Button</button>
                                <button class="btn mb-2" style="background-color: <?= htmlspecialchars($settings['theme_accent_color'] ?? '#D9B39B') ?>; color: white;">Accent Button</button>
                                <div class="mt-3 p-3 rounded" style="background-color: <?= htmlspecialchars($settings['theme_background_color'] ?? '#F5F0E1') ?>; color: #333;">
                                    <p class="mb-0">Background preview with main text</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Theme Settings
                        </button>
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-redo me-2"></i>Reset to Current
                        </a>
                    </div>
                    <?= form_close() ?>
                    </div>

                    <!-- SEO AI Settings Tab -->
                    <div class="tab-pane fade <?= $active_tab == 'seo' ? 'show active' : '' ?>" id="seo" role="tabpanel">
                        <?= form_open('admin/settings/save') ?>
                            <input type="hidden" name="active_tab" value="seo">
                            
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <i class="fas fa-robot me-2"></i>SEO AI Configuration
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted mb-4">
                                                Configure AI-powered SEO generation for automatic meta tags, descriptions, and keywords.
                                            </p>

                                            <div class="mb-4">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           name="seo_ai_enabled" 
                                                           id="seo_ai_enabled" 
                                                           value="1" 
                                                           <?= ($settings['seo_ai_enabled'] ?? 0) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="seo_ai_enabled">
                                                        <strong>Enable AI-Powered SEO</strong>
                                                        <br><small class="text-muted">Requires an API key from OpenAI or Claude</small>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label" for="seo_ai_provider">AI Provider</label>
                                                <select name="seo_ai_provider" id="seo_ai_provider" class="form-select">
                                                    <option value="openai" <?= ($settings['seo_ai_provider'] ?? 'openai') === 'openai' ? 'selected' : '' ?>>
                                                        OpenAI (GPT-3.5-turbo)
                                                    </option>
                                                    <option value="claude" <?= ($settings['seo_ai_provider'] ?? 'openai') === 'claude' ? 'selected' : '' ?>>
                                                        Anthropic (Claude)
                                                    </option>
                                                </select>
                                                <small class="text-muted d-block mt-2">
                                                    <strong>OpenAI:</strong> ~$0.001-0.005 per generation<br>
                                                    <strong>Claude:</strong> Similar pricing
                                                </small>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label" for="seo_ai_api_key">API Key</label>
                                                <input type="password" 
                                                       name="seo_ai_api_key" 
                                                       id="seo_ai_api_key" 
                                                       class="form-control" 
                                                       value="<?= isset($settings['seo_ai_api_key']) ? substr($settings['seo_ai_api_key'], 0, 10) . '***' : '' ?>" 
                                                       placeholder="sk-... (leave blank to keep current)">
                                                <small class="text-muted d-block mt-2">
                                                    <strong>OpenAI Key:</strong> Get from <a href="https://platform.openai.com/api-keys" target="_blank">platform.openai.com</a><br>
                                                    <strong>Claude Key:</strong> Get from <a href="https://console.anthropic.com/" target="_blank">console.anthropic.com</a><br>
                                                    Leave blank to keep your current API key
                                                </small>
                                            </div>

                                            <hr>

                                            <div class="alert alert-info mb-0">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Quick Generation (Always Available)</strong><br>
                                                Without AI, you can still use Auto-Generate for instant SEO suggestions using our built-in PHP engine (no cost).
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <i class="fas fa-question-circle me-2"></i>How It Works
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Quick Generation:</strong></p>
                                            <ul class="small mb-3">
                                                <li>No API needed</li>
                                                <li>Instant results</li>
                                                <li>PHP-based heuristics</li>
                                            </ul>

                                            <p><strong>AI Polish (Optional):</strong></p>
                                            <ul class="small mb-3">
                                                <li>Uses OpenAI or Claude</li>
                                                <li>Context-aware optimization</li>
                                                <li>Better quality results</li>
                                                <li>Costs ~$0.001-0.005/use</li>
                                            </ul>

                                            <div class="alert alert-warning small mb-0">
                                                <strong>Tip:</strong> API key is encrypted before storing. Update it only when adding a new key.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save SEO Settings
                                </button>
                                <a href="<?= current_url() ?>" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-redo me-2"></i>Reset
                                </a>
                            </div>
                        <?= form_close() ?>
                    </div>

                    <!-- Bulk SMS Settings Tab -->
                    <div class="tab-pane fade <?= $active_tab == 'sms' ? 'show active' : '' ?>" id="sms" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fas fa-plus me-2"></i>SMS Providers
                    </div>
                                    <div class="card-body">
                                        <p class="text-muted mb-4">Configure multiple SMS providers/vendors. You can add different providers with their API endpoints and authentication details.</p>

                                        <!-- SMS Providers Table -->
                                        <div class="table-responsive mb-4">
                                            <table class="table table-hover" id="smsProvidersTable">
                                                <thead>
                                                    <tr>
                                                        <th>Provider Name</th>
                                                        <th>API Endpoint</th>
                                                        <th>Status</th>
                                                        <th width="120">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($sms_providers)): ?>
                                                        <?php foreach ($sms_providers as $provider): ?>
                                                            <tr data-provider-id="<?= $provider->id ?>">
                                                                <td><strong><?= htmlspecialchars($provider->name) ?></strong></td>
                                                                <td><code class="text-muted"><?= htmlspecialchars($provider->api_endpoint) ?></code></td>
                                                                <td>
                                                                    <?php if ($provider->is_active): ?>
                                                                        <span class="badge bg-success">Active</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-secondary">Inactive</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-sm btn-outline-info edit-provider" data-provider-id="<?= $provider->id ?>">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                                        onclick="confirmDelete('<?= base_url('admin/settings/delete_sms_provider/' . $provider->id) ?>', 'SMS provider')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center py-4 text-muted">
                                                                No SMS providers configured yet.
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSmsProviderModal">
                                            <i class="fas fa-plus me-2"></i>Add Provider
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fas fa-info-circle me-2"></i>SMS Provider Setup
                                    </div>
                                    <div class="card-body">
                                        <p class="small mb-3"><strong>Common SMS Providers:</strong></p>
                                        <ul class="small list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Twilio</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Nexmo (Vonage)</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Africa's Talking</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Clickatell</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Infobip</li>
                                            <li><i class="fas fa-check text-success me-2"></i>AWS SNS</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Custom API</li>
                                        </ul>

                                        <hr>

                                        <p class="small mb-2"><strong>Setup Requirements:</strong></p>
                                        <ul class="small text-muted">
                                            <li>Provider API Endpoint URL</li>
                                            <li>API Key / Authentication Token</li>
                                            <li>Sender ID (for some providers)</li>
                                            <li>API Headers (if required)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Management Tab -->
                    <div class="tab-pane fade <?= $active_tab == 'menu' ? 'show active' : '' ?>" id="menu" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Create Menu Card -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-folder-plus me-2"></i>Create New Menu
                                    </div>
                                    <div class="card-body">
                                        <form id="createMenuForm">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Menu Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="menu_name" class="form-control" placeholder="e.g., Main Header Menu" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Menu Label <span class="text-danger">*</span></label>
                                                        <input type="text" name="menu_label" class="form-control" placeholder="e.g., Header" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Location <span class="text-danger">*</span></label>
                                                        <select name="menu_location" class="form-select" required>
                                                            <option value="">-- Choose Location --</option>
                                                            <option value="primary">Primary (Header)</option>
                                                            <option value="footer">Footer</option>
                                                            <option value="sidebar">Sidebar</option>
                                                            <option value="custom">Custom</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" name="is_active" class="form-check-input" id="menuActive" value="1" checked>
                                                <label class="form-check-label" for="menuActive">Active</label>
                                            </div>
                                            <button type="submit" class="btn btn-success mt-3">
                                                <i class="fas fa-save me-2"></i>Create Menu
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Manage Menu Items Card -->
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-list me-2"></i>Manage Menu Items</span>
                                        <button type="button" class="btn btn-sm btn-primary" id="addMenuBtn" style="display: none;">
                                            <i class="fas fa-plus me-2"></i>Add Menu Item
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Select Menu</label>
                                            <select id="menuSelect" class="form-control">
                                                <option value="">-- Choose a menu --</option>
                                                <?php if (!empty($menus)): ?>
                                                    <?php foreach ($menus as $menu): ?>
                                                        <option value="<?= $menu->id ?>"><?= htmlspecialchars($menu->menu_label) ?> (<?= $menu->menu_location ?>)</option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <div id="menuItemsContainer" style="display: none;" class="mt-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0">Menu Items</h6>
                                                <button type="button" class="btn btn-sm btn-primary" id="addMenuBtn2">
                                                    <i class="fas fa-plus me-1"></i>Add Item
                                                </button>
                                            </div>
                                            <div class="menu-tree" id="menuTree" style="border: 1px solid #dee2e6; border-radius: 4px; padding: 15px; background-color: #f8f9fa;">
                                                <!-- Menu items will be loaded here -->
                                            </div>
                                        </div>

                                        <div id="noMenuMessage" class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle me-2"></i>Select a menu to manage its items.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fas fa-info-circle me-2"></i>Menu Statistics
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <small class="text-muted">Total Menus</small>
                                            <h4><?= $menu_stats['total_menus'] ?? 0 ?></h4>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted">Active Menus</small>
                                            <h4><?= $menu_stats['active_menus'] ?? 0 ?></h4>
                                        </div>
                                        
                                        <hr>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted d-block mb-2"><strong>Role Level Color Guide</strong></small>
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="role-level-badge" style="background-color: #e74c3c;"></span>
                                                <small class="ms-2">Super Admin</small>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="role-level-badge" style="background-color: #e67e22;"></span>
                                                <small class="ms-2">Admin</small>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="role-level-badge" style="background-color: #3498db;"></span>
                                                <small class="ms-2">Editor</small>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="role-level-badge" style="background-color: #9b59b6;"></span>
                                                <small class="ms-2">Staff</small>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="role-level-badge" style="background-color: #95a5a6;"></span>
                                                <small class="ms-2">User</small>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted">Total Menu Items</small>
                                            <h4><?= $menu_stats['total_items'] ?? 0 ?></h4>
                                        </div>

                                        <hr>

                                        <p class="small mb-2"><strong>Menu Locations:</strong></p>
                                        <ul class="small text-muted list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Primary</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Footer</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Sidebar</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>

<style>
.nav-tabs .nav-link {
    color: var(--primary-color);
    border: none;
    padding: 12px 20px;
    font-weight: 500;
}
.nav-tabs .nav-link:hover {
    border: none;
    background: #f8f9fa;
}
.nav-tabs .nav-link.active {
    color: var(--accent-color);
    border: none;
    border-bottom: 3px solid var(--accent-color);
    background: transparent;
}
.form-switch .form-check-input {
    width: 3em;
    height: 1.5em;
}
.form-switch .form-check-input:checked {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
}

/* Theme Color Picker Styles */
.color-picker-group {
    display: flex;
    flex-direction: column;
}
.color-picker-group .input-group {
    margin-bottom: 0.5rem;
}
.color-picker-group .form-control-color {
    cursor: pointer;
    height: 45px;
    border-radius: 4px 0 0 4px;
    border: 1px solid #dee2e6;
    padding: 3px;
}
.color-picker-group .color-hex {
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
    text-transform: uppercase;
    border-radius: 0 4px 4px 0;
}
.color-preview {
    height: 60px;
    border-radius: 4px;
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
}
.preset-btn {
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
}
.preset-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}
.preset-btn.active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}
.theme-preview {
    background: white;
    border-radius: 8px;
    transition: all 0.3s ease;
}

/* Role Level Badge */
.role-level-badge {
    display: inline-block;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    box-shadow: 0 0 4px rgba(0,0,0,0.2);
}

/* Menu Item with Role Level */
.menu-item-role-level {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 6px;
    vertical-align: middle;
}

.menu-tree .menu-item-content {
    position: relative;
}

.menu-tree .menu-item-content strong {
    display: flex;
    align-items: center;
}

.role-level-indicator-sm {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-left: 8px;
}
</style>

<!-- Add/Edit SMS Provider Modal -->
<div class="modal fade" id="addSmsProviderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add SMS Provider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="smsProviderForm">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <input type="hidden" id="provider_id" name="provider_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Provider Name <span class="text-danger">*</span></label>
                        <input type="text" id="provider_name" name="provider_name" class="form-control" placeholder="e.g., Twilio, Nexmo, Africa's Talking" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">API Endpoint URL <span class="text-danger">*</span></label>
                        <input type="url" id="api_endpoint" name="api_endpoint" class="form-control" placeholder="https://api.provider.com/send" required>
                        <small class="text-muted">The full URL endpoint for sending SMS messages</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">API Key/Token <span class="text-danger">*</span></label>
                                <input type="password" id="api_key" name="api_key" class="form-control" placeholder="API Key or Auth Token">
                                <small class="text-muted" id="api_key_note" style="display: none;">Leave empty to keep the existing API key.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Sender ID</label>
                                <input type="text" id="sender_id" name="sender_id" class="form-control" placeholder="Optional sender ID">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">API Headers (JSON format)</label>
                        <textarea id="api_headers" name="api_headers" class="form-control" rows="3" placeholder='{"Authorization": "Bearer token", "Content-Type": "application/json"}' style="font-family: monospace; font-size: 0.85rem;"></textarea>
                        <small class="text-muted">Optional: Additional headers required by the API endpoint</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Request Parameters (JSON format)</label>
                        <textarea id="request_params" name="request_params" class="form-control" rows="3" placeholder='{"to": "phone", "message": "text"}' style="font-family: monospace; font-size: 0.85rem;"></textarea>
                        <small class="text-muted">Required: Map the request payload. Use {phone} and {message} as placeholders</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">HTTP Method</label>
                                <select id="http_method" name="http_method" class="form-select">
                                    <option value="POST">POST</option>
                                    <option value="GET">GET</option>
                                    <option value="PUT">PUT</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Request Format</label>
                                <select id="request_format" name="request_format" class="form-select">
                                    <option value="json">JSON</option>
                                    <option value="form">Form Data</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" id="is_active" name="is_active" class="form-check-input" value="1" checked>
                        <label class="form-check-label" for="is_active">Activate this provider</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Provider</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update URL when tab changes
    var tabs = document.querySelectorAll('#settingsTabs button[data-bs-toggle="tab"]');
    tabs.forEach(function(tab) {
        tab.addEventListener('shown.bs.tab', function(e) {
            var tabId = e.target.getAttribute('data-bs-target').replace('#', '');
            var newUrl = window.location.pathname + '?tab=' + tabId;
            window.history.replaceState(null, null, newUrl);
        });
    });

    // Sync color picker with text input and preview
    var colorInputs = document.querySelectorAll('input[type="color"]');
    colorInputs.forEach(function(colorInput) {
        var group = colorInput.closest('.color-picker-group');
        if (!group) return;
        var textInput = group.querySelector('input[type="text"]');
        var preview = group.querySelector('.color-preview');
        
        if (textInput) {
            colorInput.addEventListener('input', function() {
                textInput.value = colorInput.value.toUpperCase();
                if (preview) {
                    preview.style.backgroundColor = colorInput.value;
                }
                updateThemePreview();
            });
        }
    });

    // Theme Presets
    var presets = {
        default: {
            primary: '#C7805C',
            secondary: '#90B3A7',
            accent: '#D9B39B',
            background: '#F5F0E1'
        },
        modern: {
            primary: '#2C3E50',
            secondary: '#34495E',
            accent: '#E74C3C',
            background: '#ECF0F1'
        },
        ocean: {
            primary: '#0066CC',
            secondary: '#0099FF',
            accent: '#00CCFF',
            background: '#E6F2FF'
        },
        tropical: {
            primary: '#FF6B35',
            secondary: '#004E89',
            accent: '#1B998B',
            background: '#F7FFF7'
        }
    };

    var presetBtns = document.querySelectorAll('.preset-btn');
    presetBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var presetName = this.getAttribute('data-preset');
            var preset = presets[presetName];
            
            if (preset) {
                document.querySelector('input[name="theme_primary_color"]').value = preset.primary;
                document.querySelector('input[name="theme_secondary_color"]').value = preset.secondary;
                document.querySelector('input[name="theme_accent_color"]').value = preset.accent;
                document.querySelector('input[name="theme_background_color"]').value = preset.background;
                
                // Update hex displays and previews
                updateColorDisplays();
                updateThemePreview();
                
                // Show active state
                presetBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }
        });
    });

    function updateColorDisplays() {
        var colorInputs = document.querySelectorAll('input[type="color"]');
        colorInputs.forEach(function(colorInput) {
            var group = colorInput.closest('.color-picker-group');
            if (!group) return;
            var textInput = group.querySelector('input[type="text"]');
            var preview = group.querySelector('.color-preview');
            
            if (textInput) {
                textInput.value = colorInput.value.toUpperCase();
            }
            if (preview) {
                preview.style.backgroundColor = colorInput.value;
            }
        });
    }

    function updateThemePreview() {
        var primaryInput = document.querySelector('input[name="theme_primary_color"]');
        var secondaryInput = document.querySelector('input[name="theme_secondary_color"]');
        var accentInput = document.querySelector('input[name="theme_accent_color"]');
        var backgroundInput = document.querySelector('input[name="theme_background_color"]');
        
        if (!primaryInput || !secondaryInput || !accentInput || !backgroundInput) {
            return;
        }
        
        var primary = primaryInput.value;
        var secondary = secondaryInput.value;
        var accent = accentInput.value;
        var background = backgroundInput.value;
        
        // Update preview buttons
        var primaryBtn = document.querySelector('.theme-preview button:nth-of-type(1)');
        var secondaryBtn = document.querySelector('.theme-preview button:nth-of-type(2)');
        var accentBtn = document.querySelector('.theme-preview button:nth-of-type(3)');
        var bgPreview = document.querySelector('.theme-preview > div');
        
        if (primaryBtn) primaryBtn.style.backgroundColor = primary;
        if (secondaryBtn) secondaryBtn.style.backgroundColor = secondary;
        if (accentBtn) accentBtn.style.backgroundColor = accent;
        if (bgPreview) bgPreview.style.backgroundColor = background;
    }

    // SMS Provider Management
    var smsForm = document.getElementById('smsProviderForm');
    var smsModalEl = document.getElementById('addSmsProviderModal');
    var smsModal = smsModalEl ? new bootstrap.Modal(smsModalEl) : null;
    var isEditingProvider = false;

    // Edit provider
    function setupEditButtons() {
        document.querySelectorAll('.edit-provider').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (!smsModal) return;
                isEditingProvider = true;
                var providerId = this.dataset.providerId;
                fetch('<?= base_url('admin/settings/get_sms_provider/') ?>' + providerId, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('modalTitle').textContent = 'Edit SMS Provider';
                        document.getElementById('provider_id').value = data.provider.id;
                        document.getElementById('provider_name').value = data.provider.name;
                        document.getElementById('api_endpoint').value = data.provider.api_endpoint;
                        document.getElementById('api_key').value = '';
                        document.getElementById('api_key').required = false;
                        document.getElementById('api_key_note').style.display = 'block';
                        document.getElementById('sender_id').value = data.provider.sender_id || '';
                        document.getElementById('api_headers').value = data.provider.api_headers || '';
                        document.getElementById('request_params').value = data.provider.request_params || '';
                        document.getElementById('http_method').value = data.provider.http_method || 'POST';
                        document.getElementById('request_format').value = data.provider.request_format || 'json';
                        document.getElementById('is_active').checked = data.provider.is_active == 1;
                        smsModal.show();
                    } else {
                        alert('Error: ' + (data.message || 'Failed to load provider'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while loading the provider');
                });
            });
        });
    }

    // Add provider button
    var addProviderBtn = document.querySelector('[data-bs-target="#addSmsProviderModal"]');
    if (addProviderBtn) {
        addProviderBtn.addEventListener('click', function() {
            isEditingProvider = false;
            document.getElementById('modalTitle').textContent = 'Add SMS Provider';
            if (smsForm) smsForm.reset();
            document.getElementById('provider_id').value = '';
            document.getElementById('api_key').required = true;
            document.getElementById('api_key_note').style.display = 'none';
            document.getElementById('is_active').checked = true;
        });
    }

    // Modal closing handler
    if (smsModalEl) {
        smsModalEl.addEventListener('hidden.bs.modal', function() {
            if (smsForm) smsForm.reset();
            document.getElementById('provider_id').value = '';
            document.getElementById('api_key').required = true;
            document.getElementById('api_key_note').style.display = 'none';
            isEditingProvider = false;
        });
    }

    // Submit form
    if (smsForm) {
    smsForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate API key for new providers
        if (!isEditingProvider && !document.getElementById('api_key').value.trim()) {
            alert('API Key is required for new providers');
            return;
        }
        
        // Validate JSON fields if provided
        var apiHeaders = document.getElementById('api_headers').value.trim();
        if (apiHeaders) {
            try {
                JSON.parse(apiHeaders);
            } catch (e) {
                alert('Invalid JSON in API Headers: ' + e.message);
                return;
            }
        }
        
        var requestParams = document.getElementById('request_params').value.trim();
        if (requestParams) {
            try {
                JSON.parse(requestParams);
            } catch (e) {
                alert('Invalid JSON in Request Parameters: ' + e.message);
                return;
            }
        }
        
        var formData = new FormData(this);
        var url = '<?= base_url('admin/settings/save_sms_provider') ?>';
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message || 'SMS Provider saved successfully!');
                smsModal.hide();
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to save provider'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving the provider');
        });
    });
    }

    // Initialize event listeners
    setupEditButtons();
});

// Menu Management JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const menuSelect = document.getElementById('menuSelect');
    const menuTree = document.getElementById('menuTree');
    const menuItemsContainer = document.getElementById('menuItemsContainer');
    const noMenuMessage = document.getElementById('noMenuMessage');
    const addMenuBtn = document.getElementById('addMenuBtn');

    menuSelect.addEventListener('change', function() {
        const menuId = this.value;
        if (!menuId) {
            menuItemsContainer.style.display = 'none';
            noMenuMessage.style.display = 'block';
            return;
        }

        fetch('<?= base_url('admin/settings/get_menu_items') ?>/' + menuId, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Store items globally for parent selection dropdown
                window.currentMenuItems = flattenItems(data.items);
                const html = renderMenuItems(data.items, menuId);
                menuTree.innerHTML = html;
                menuItemsContainer.style.display = 'block';
                noMenuMessage.style.display = 'none';
            }
        })
        .catch(error => console.error('Error:', error));
    });

    function flattenItems(items, depth = 0) {
        let flat = [];
        items.forEach(item => {
            flat.push({...item, depth_level: depth});
            if (item.children && item.children.length > 0) {
                flat = flat.concat(flattenItems(item.children, depth + 1));
            }
        });
        return flat;
    }

    function getRoleColor(depthLevel) {
        // Assign role colors based on depth level or item properties
        const colors = {
            'super-admin': '#e74c3c',
            'admin': '#e67e22',
            'editor': '#3498db',
            'staff': '#9b59b6',
            'user': '#95a5a6'
        };
        return colors['editor']; // Default to editor, can be extended
    }
    
    function renderMenuItems(items, menuId, parentId = null, depth = 0) {
        let html = '';
        
        const filteredItems = items.filter(item => item.parent_id === parentId);
        
        if (filteredItems.length === 0) {
            return html;
        }
        
        filteredItems.forEach(item => {
            const hasChildren = items.some(i => i.parent_id === item.id);
            const childItems = items.filter(i => i.parent_id === item.id);
            const roleColor = getRoleColor(depth);
            
            if (depth === 0) {
                // Parent level - in container box
                html += `
                    <div class="menu-group" data-item-id="${item.id}" style="
                        margin-bottom: 20px;
                        border: 2px solid #dee2e6;
                        border-radius: 6px;
                        overflow: hidden;
                    ">
                        <!-- Parent Item -->
                        <div class="menu-item-content" style="
                            background-color: #ffffff;
                            padding: 16px;
                            display: flex;
                            justify-content: space-between;
                            align-items: flex-start;
                            transition: all 0.2s ease;
                            border-bottom: ${hasChildren ? '2px solid #e9ecef' : 'none'};
                        " onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='#ffffff'">
                            <div style="flex: 1;">
                                <strong style="display: block; margin-bottom: 6px; font-size: 1.05em;">
                                    <span class="role-level-indicator-sm" style="background-color: ${roleColor}; margin-right: 8px;"></span>
                                    ${htmlEscape(item.item_label)}
                                </strong>
                                <small class="text-muted" style="display: block; margin-bottom: 8px;">
                                    <i class="fas fa-link" style="margin-right: 4px;"></i>${item.item_url ? htmlEscape(item.item_url) : '<em>(No URL)</em>'}
                                </small>
                                <div>
                                    ${!item.is_visible ? '<span class="badge bg-warning">Hidden</span>' : '<span class="badge bg-success">Visible</span>'}
                                    ${hasChildren ? '<span class="badge bg-info ms-2">+' + childItems.length + ' submenu(s)</span>' : ''}
                                </div>
                            </div>
                            <div class="btn-group btn-group-sm ms-3" style="flex-shrink: 0;">
                                <button type="button" class="btn btn-outline-success add-submenu" data-item-id="${item.id}" data-menu-id="${menuId}" title="Add submenu item" style="padding: 6px 10px;">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-outline-info edit-item" data-item-id="${item.id}" data-menu-id="${menuId}" title="Edit item" style="padding: 6px 10px;">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger delete-item" data-item-id="${item.id}" title="Delete item" style="padding: 6px 10px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                `;
                
                // Children container
                if (hasChildren) {
                    html += `
                        <div class="menu-children" style="
                            background-color: #f8f9fa;
                            padding: 0;
                        ">
                    `;
                    
                    childItems.forEach((child, index) => {
                        const grandChildren = items.filter(i => i.parent_id === child.id);
                        const hasGrandChildren = grandChildren.length > 0;
                        
                        html += `
                            <div class="menu-child-item" data-item-id="${child.id}" style="
                                border-top: 1px solid #e9ecef;
                                padding: 16px;
                                padding-left: 40px;
                                background-color: #ffffff;
                                display: flex;
                                justify-content: space-between;
                                align-items: flex-start;
                                transition: all 0.2s ease;
                            " onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='#ffffff'">
                                <div style="flex: 1;">
                                    <strong style="display: block; margin-bottom: 4px;">
                                        <i class="fas fa-arrow-right text-muted" style="margin-right: 8px; font-size: 0.75em; opacity: 0.6;"></i>
                                        ${htmlEscape(child.item_label)}
                                        <span style="font-size: 0.85em; font-weight: normal; color: #999; margin-left: 8px;">(Level 1)</span>
                                    </strong>
                                    <small class="text-muted" style="display: block; margin-bottom: 6px; margin-left: 20px;">
                                        <i class="fas fa-link" style="margin-right: 4px;"></i>${child.item_url ? htmlEscape(child.item_url) : '<em>(No URL)</em>'}
                                    </small>
                                    <div style="margin-left: 20px;">
                                        ${!child.is_visible ? '<span class="badge bg-warning">Hidden</span>' : '<span class="badge bg-success">Visible</span>'}
                                        ${hasGrandChildren ? '<span class="badge bg-info ms-2">+' + grandChildren.length + ' nested</span>' : ''}
                                    </div>
                                </div>
                                <div class="btn-group btn-group-sm ms-3" style="flex-shrink: 0;">
                                    <button type="button" class="btn btn-outline-success add-submenu" data-item-id="${child.id}" data-menu-id="${menuId}" title="Add nested item" style="padding: 6px 10px;">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-info edit-item" data-item-id="${child.id}" data-menu-id="${menuId}" title="Edit item" style="padding: 6px 10px;">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger delete-item" data-item-id="${child.id}" title="Delete item" style="padding: 6px 10px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                        
                        // Grandchildren
                        if (hasGrandChildren) {
                            grandChildren.forEach((grandchild) => {
                                const greatGrandChildren = items.filter(i => i.parent_id === grandchild.id);
                                const hasGreatGrandChildren = greatGrandChildren.length > 0;
                                
                                html += `
                                    <div class="menu-grandchild-item" data-item-id="${grandchild.id}" style="
                                        border-top: 1px solid #e9ecef;
                                        padding: 14px;
                                        padding-left: 60px;
                                        background-color: #fafafa;
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: flex-start;
                                        transition: all 0.2s ease;
                                    " onmouseover="this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.backgroundColor='#fafafa'">
                                        <div style="flex: 1;">
                                            <strong style="display: block; margin-bottom: 4px; font-size: 0.95em;">
                                                <i class="fas fa-arrow-right text-muted" style="margin-right: 8px; font-size: 0.7em; opacity: 0.5;"></i>
                                                ${htmlEscape(grandchild.item_label)}
                                                <span style="font-size: 0.8em; font-weight: normal; color: #999; margin-left: 8px;">(Level 2)</span>
                                            </strong>
                                            <small class="text-muted" style="display: block; margin-bottom: 6px; margin-left: 20px; font-size: 0.9em;">
                                                <i class="fas fa-link" style="margin-right: 4px;"></i>${grandchild.item_url ? htmlEscape(grandchild.item_url) : '<em>(No URL)</em>'}
                                            </small>
                                            <div style="margin-left: 20px;">
                                                ${!grandchild.is_visible ? '<span class="badge bg-warning badge-sm">Hidden</span>' : '<span class="badge bg-success badge-sm">Visible</span>'}
                                                ${hasGreatGrandChildren ? '<span class="badge bg-info ms-2 badge-sm">+' + greatGrandChildren.length + '</span>' : ''}
                                            </div>
                                        </div>
                                        <div class="btn-group btn-group-sm ms-3" style="flex-shrink: 0;">
                                            <button type="button" class="btn btn-outline-success add-submenu" data-item-id="${grandchild.id}" data-menu-id="${menuId}" title="Add nested item" style="padding: 5px 8px; font-size: 0.85em;">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-info edit-item" data-item-id="${grandchild.id}" data-menu-id="${menuId}" title="Edit item" style="padding: 5px 8px; font-size: 0.85em;">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger delete-item" data-item-id="${grandchild.id}" title="Delete item" style="padding: 5px 8px; font-size: 0.85em;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                `;
                                
                                // Deep nested items (Level 3+)
                                if (hasGreatGrandChildren) {
                                    greatGrandChildren.forEach((deepItem) => {
                                        html += `
                                            <div class="menu-deep-item" data-item-id="${deepItem.id}" style="
                                                border-top: 1px solid #e9ecef;
                                                padding: 12px;
                                                padding-left: 80px;
                                                background-color: #f5f5f5;
                                                display: flex;
                                                justify-content: space-between;
                                                align-items: flex-start;
                                                font-size: 0.9em;
                                                transition: all 0.2s ease;
                                            " onmouseover="this.style.backgroundColor='#eeeeee'" onmouseout="this.style.backgroundColor='#f5f5f5'">
                                                <div style="flex: 1;">
                                                    <strong style="display: block; margin-bottom: 3px; font-size: 0.95em;">
                                                        <i class="fas fa-arrow-right text-muted" style="margin-right: 6px; font-size: 0.65em; opacity: 0.4;"></i>
                                                        ${htmlEscape(deepItem.item_label)}
                                                        <span style="font-size: 0.75em; font-weight: normal; color: #999;">(Level 3+)</span>
                                                    </strong>
                                                    <small class="text-muted" style="display: block; margin-bottom: 4px; margin-left: 18px;">
                                                        ${deepItem.item_url ? htmlEscape(deepItem.item_url) : '<em>(No URL)</em>'}
                                                    </small>
                                                    <div>
                                                        ${!deepItem.is_visible ? '<span class="badge bg-warning badge-sm" style="font-size: 0.75em;">Hidden</span>' : '<span class="badge bg-success badge-sm" style="font-size: 0.75em;">Visible</span>'}
                                                    </div>
                                                </div>
                                                <div class="btn-group btn-group-sm ms-2" style="flex-shrink: 0;">
                                                    <button type="button" class="btn btn-outline-info edit-item" data-item-id="${deepItem.id}" data-menu-id="${menuId}" title="Edit" style="padding: 4px 6px; font-size: 0.75em;">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger delete-item" data-item-id="${deepItem.id}" title="Delete" style="padding: 4px 6px; font-size: 0.75em;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        `;
                                    });
                                }
                            });
                        }
                    });
                    
                    html += `</div>`;
                }
                
                html += `</div>`;
            }
        });
        
        return html;
    }

    function htmlEscape(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Add new menu item (main button)
    addMenuBtn.addEventListener('click', function() {
        const menuId = menuSelect.value;
        if (!menuId) {
            alert('Please select a menu first');
            return;
        }
        openMenuItemModal(null, menuId);
    });

    // Add new menu item (secondary button)
    const addMenuBtn2 = document.getElementById('addMenuBtn2');
    if (addMenuBtn2) {
        addMenuBtn2.addEventListener('click', function() {
            const menuId = menuSelect.value;
            if (!menuId) {
                alert('Please select a menu first');
                return;
            }
            openMenuItemModal(null, menuId);
        });
    }

    // Create new menu form handler
    const createMenuForm = document.getElementById('createMenuForm');
    if (createMenuForm) {
        createMenuForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const menuName = document.querySelector('input[name="menu_name"]').value;
            const menuLabel = document.querySelector('input[name="menu_label"]').value;
            const menuLocation = document.querySelector('select[name="menu_location"]').value;
            const isActive = document.querySelector('input[name="is_active"]').checked ? 1 : 0;
            
            if (!menuName || !menuLabel || !menuLocation) {
                alert('Please fill in all required fields');
                return;
            }
            
            const formData = new FormData();
            formData.append('menu_name', menuName);
            formData.append('menu_label', menuLabel);
            formData.append('menu_location', menuLocation);
            formData.append('is_active', isActive);
            const csrfName = document.querySelector('meta[name*="csrf"]')?.getAttribute('name') || '<?= $this->security->get_csrf_token_name() ?>';
            const csrfValue = document.querySelector('meta[name*="csrf"]')?.getAttribute('content') || '<?= $this->security->get_csrf_hash() ?>';
            if (csrfName && csrfValue) {
                formData.append(csrfName, csrfValue);
            }
            
            fetch('<?= base_url('admin/settings/create_menu') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Menu created successfully!');
                    createMenuForm.reset();
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to create menu'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the menu');
            });
        });
    }

    // Add submenu
    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-submenu')) {
            const itemId = e.target.closest('.add-submenu').dataset.itemId;
            const menuId = e.target.closest('.add-submenu').dataset.menuId;
            openMenuItemModal(null, menuId, itemId); // Pass itemId as parentId
        }
    });

    // Edit menu item
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-item')) {
            const itemId = e.target.closest('.edit-item').dataset.itemId;
            const menuId = e.target.closest('.edit-item').dataset.menuId;
            const item = (window.currentMenuItems || []).find(i => i.id == itemId);
            const parentId = item ? item.parent_id : null;
            openMenuItemModal(itemId, menuId, parentId);
        }
    });

    // Delete menu item
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-item')) {
            const itemId = e.target.closest('.delete-item').dataset.itemId;
            if (confirm('Are you sure you want to delete this menu item?')) {
                deleteMenuItem(itemId);
            }
        }
    });

    function openMenuItemModal(itemId, menuId, parentId = null) {
        const isEdit = itemId !== null;
        const title = isEdit ? 'Edit Menu Item' : 'Add Menu Item';
        const allItems = window.currentMenuItems || [];
        
        // Build parent options dropdown
        let parentOptions = '<option value="">-- Root Level (No Parent) --</option>';
        allItems.forEach(item => {
            if (!itemId || item.id != itemId) { // Don't allow item to be its own parent
                const indent = '&nbsp;'.repeat(item.depth_level * 4);
                parentOptions += `<option value="${item.id}" ${parentId == item.id ? 'selected' : ''}>${indent}${htmlEscape(item.item_label)}</option>`;
            }
        });
        
        let html = `
            <div class="modal-header">
                <h5 class="modal-title">${title}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="menuItemForm" class="menu-item-form" data-item-id="${itemId || ''}" data-menu-id="${menuId}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Label <span class="text-danger">*</span></label>
                        <input type="text" name="item_label" class="form-control" required placeholder="e.g., Home, About, Contact">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Parent Item</label>
                        <select name="parent_id" class="form-control">
                            ${parentOptions}
                        </select>
                        <small class="text-muted d-block mt-1">Select a parent to create a submenu. Leave empty for top-level items.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role Level</label>
                        <select name="role_level" class="form-control">
                            <option value="user">User (Gray)</option>
                            <option value="staff">Staff (Purple)</option>
                            <option value="editor">Editor (Blue)</option>
                            <option value="admin">Admin (Orange)</option>
                            <option value="super-admin">Super Admin (Red)</option>
                        </select>
                        <small class="text-muted d-block mt-1">Minimum role required to see this menu item.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL</label>
                        <input type="text" name="item_url" class="form-control" placeholder="e.g., /about, http://example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon Class (FontAwesome)</label>
                        <input type="text" name="item_icon" class="form-control" placeholder="e.g., fa-home, fa-about">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CSS Class</label>
                        <input type="text" name="item_class" class="form-control" placeholder="e.g., custom-class">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="target_blank" class="form-check-input" id="targetBlank">
                        <label class="form-check-label" for="targetBlank">Open in new tab</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_visible" class="form-check-input" id="isVisible" checked>
                        <label class="form-check-label" for="isVisible">Visible</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Item</button>
                </div>
            </form>
        `;

        if (!window.menuModal) {
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.id = 'menuItemModal';
            modal.tabIndex = -1;
            modal.innerHTML = '<div class="modal-dialog"><div class="modal-content"></div></div>';
            document.body.appendChild(modal);
            window.menuModal = new bootstrap.Modal(modal);
        }

        document.querySelector('#menuItemModal .modal-content').innerHTML = html;

        if (isEdit) {
            loadMenuItemData(itemId);
        }

        document.getElementById('menuItemForm').addEventListener('submit', function(e) {
            e.preventDefault();
            saveMenuItem(menuId, itemId);
        });

        window.menuModal.show();
    }

    function loadMenuItemData(itemId) {
        // Load item data from stored items
        const item = (window.currentMenuItems || []).find(i => i.id == itemId);
        if (item) {
            setTimeout(() => {
                document.querySelector('input[name="item_label"]').value = item.item_label || '';
                const parentSelect = document.querySelector('select[name="parent_id"]');
                if (parentSelect) {
                    parentSelect.value = item.parent_id ? item.parent_id : '';
                }
                document.querySelector('input[name="item_url"]').value = item.item_url || '';
                document.querySelector('input[name="item_icon"]').value = item.item_icon || '';
                document.querySelector('input[name="item_class"]').value = item.item_class || '';
                const targetBlankCheckbox = document.querySelector('input[name="target_blank"]');
                if (targetBlankCheckbox) {
                    targetBlankCheckbox.checked = item.target_blank ? true : false;
                }
                const isVisibleCheckbox = document.querySelector('input[name="is_visible"]');
                if (isVisibleCheckbox) {
                    isVisibleCheckbox.checked = item.is_visible ? true : false;
                }
            }, 100);
        }
    }

    function saveMenuItem(menuId, itemId) {
        const form = document.getElementById('menuItemForm');
        const formData = new FormData(form);
        
        // Add CSRF token from meta tag
        const csrfName = document.querySelector('meta[name*="csrf"]')?.getAttribute('name') || '<?= $this->security->get_csrf_token_name() ?>';
        const csrfValue = document.querySelector('meta[name*="csrf"]')?.getAttribute('content') || '<?= $this->security->get_csrf_hash() ?>';
        
        formData.append('menu_id', menuId);
        formData.append('item_id', itemId || '');
        if (csrfName && csrfValue) {
            formData.append(csrfName, csrfValue);
        }

        fetch('<?= base_url('admin/settings/save_menu_item') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message || 'Menu item saved successfully!');
                window.menuModal.hide();
                menuSelect.dispatchEvent(new Event('change'));
            } else {
                alert('Error: ' + (data.message || 'Failed to save menu item'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving the menu item');
        });
    }

    function deleteMenuItem(itemId) {
        const csrfName = document.querySelector('meta[name*="csrf"]')?.getAttribute('name') || '<?= $this->security->get_csrf_token_name() ?>';
        const csrfValue = document.querySelector('meta[name*="csrf"]')?.getAttribute('content') || '<?= $this->security->get_csrf_hash() ?>';
        
        const formData = new FormData();
        if (csrfName && csrfValue) {
            formData.append(csrfName, csrfValue);
        }
        
        fetch('<?= base_url('admin/settings/delete_menu_item') ?>/' + itemId, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message || 'Menu item deleted successfully!');
                menuSelect.dispatchEvent(new Event('change'));
            } else {
                alert('Error: ' + (data.message || 'Failed to delete menu item'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the menu item');
        });
    }
});
</script>
