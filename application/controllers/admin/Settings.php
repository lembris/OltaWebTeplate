<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Settings_model');
        $this->load->model('Menu_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('menu');
        
        $this->check_role(['super_admin', 'admin']);
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Site Settings';
        
        // Get active template and load template-specific settings
        $this->load->helper('template');
        $active_template = get_active_template();
        $data['active_template_name'] = $active_template;
        $data['settings'] = $this->Settings_model->get_all($active_template);
        $data['active_tab'] = $this->input->get('tab') ?: 'general';
        $data['templates'] = get_available_templates();
        
        // Check if sms_providers table exists, create if not
        if (!$this->db->table_exists('sms_providers')) {
            $this->_create_sms_providers_table();
        }
        $data['sms_providers'] = $this->db->get('sms_providers')->result();
        
        // Load menu data
        $data['menus'] = $this->Menu_model->get_all_menus();
        $data['menu_stats'] = $this->Menu_model->get_menu_statistics();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/settings/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }
    
    private function _create_sms_providers_table()
    {
        $this->load->dbforge();
        
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE,
                'unsigned' => TRUE,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
            ],
            'api_endpoint' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'api_key' => [
                'type' => 'TEXT',
                'null' => FALSE,
            ],
            'sender_id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'api_headers' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'request_params' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'http_method' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'default' => 'POST',
            ],
            'request_format' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'default' => 'json',
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('sms_providers', TRUE);
    }

    public function save()
    {
        if ($this->input->method() !== 'post') {
            redirect('admin/settings');
        }

        $tab = $this->input->post('active_tab') ?: 'general';
        $settings_to_update = [];

        switch ($tab) {
            case 'general':
                $settings_to_update = [
                    'site_name' => $this->input->post('site_name'),
                    'site_tagline' => $this->input->post('site_tagline'),
                    'currency' => $this->input->post('currency'),
                    'currency_symbol' => $this->input->post('currency_symbol'),
                    'timezone' => $this->input->post('timezone')
                ];
                
                if (!empty($_FILES['site_logo']['name'])) {
                    $logo = $this->upload_file('site_logo', 'logos');
                    if ($logo) {
                        $settings_to_update['site_logo'] = $logo;
                    }
                }
                
                if (!empty($_FILES['site_favicon']['name'])) {
                    $favicon = $this->upload_file('site_favicon', 'logos');
                    if ($favicon) {
                        $settings_to_update['site_favicon'] = $favicon;
                    }
                }
                break;

            case 'contact':
                $settings_to_update = [
                    'site_email' => $this->input->post('site_email'),
                    'site_phone' => $this->input->post('site_phone'),
                    'site_phone_secondary' => $this->input->post('site_phone_secondary'),
                    'site_address' => $this->input->post('site_address'),
                    'whatsapp_number' => $this->input->post('whatsapp_number'),
                    'map_embed_code' => $this->input->post('map_embed_code')
                ];
                break;

            case 'social':
                $settings_to_update = [
                    'facebook_url' => $this->input->post('facebook_url'),
                    'instagram_url' => $this->input->post('instagram_url'),
                    'twitter_url' => $this->input->post('twitter_url'),
                    'youtube_url' => $this->input->post('youtube_url'),
                    'linkedin_url' => $this->input->post('linkedin_url'),
                    'tripadvisor_url' => $this->input->post('tripadvisor_url'),
                    'pinterest_url' => $this->input->post('pinterest_url')
                ];
                break;

            case 'email':
                $settings_to_update = [
                    'admin_email' => $this->input->post('admin_email'),
                    'booking_email' => $this->input->post('booking_email'),
                    'enquiry_email' => $this->input->post('enquiry_email'),
                    'smtp_host' => $this->input->post('smtp_host'),
                    'smtp_port' => $this->input->post('smtp_port'),
                    'smtp_username' => $this->input->post('smtp_username'),
                    'smtp_encryption' => $this->input->post('smtp_encryption'),
                    'email_from_name' => $this->input->post('email_from_name')
                ];
                
                $smtp_password = $this->input->post('smtp_password');
                if (!empty($smtp_password)) {
                    $settings_to_update['smtp_password'] = $smtp_password;
                }
                break;

            case 'payment':
                $settings_to_update = [
                    'bank_name' => $this->input->post('bank_name'),
                    'bank_account_name' => $this->input->post('bank_account_name'),
                    'bank_account_number' => $this->input->post('bank_account_number'),
                    'bank_swift_code' => $this->input->post('bank_swift_code'),
                    'bank_branch' => $this->input->post('bank_branch'),
                    'bank_currency' => $this->input->post('bank_currency'),
                    'bank_additional_info' => $this->input->post('bank_additional_info')
                ];
                break;

            case 'system':
                $settings_to_update = [
                    'google_analytics_id' => $this->input->post('google_analytics_id'),
                    'google_tag_manager_id' => $this->input->post('google_tag_manager_id'),
                    'maintenance_mode' => $this->input->post('maintenance_mode') ? '1' : '0',
                    'maintenance_message' => $this->input->post('maintenance_message'),
                    'cache_enabled' => $this->input->post('cache_enabled') ? '1' : '0',
                    'cache_duration' => $this->input->post('cache_duration'),
                    'enable_seo' => $this->input->post('enable_seo') ? '1' : '0',
                    'default_meta_description' => $this->input->post('default_meta_description'),
                    'default_meta_keywords' => $this->input->post('default_meta_keywords')
                ];
                break;

            case 'template':
                $active_template = $this->input->post('active_template');
                // Validate template exists
                $this->load->helper('template');
                $available_templates = get_available_templates();
                if (array_key_exists($active_template, $available_templates)) {
                    $settings_to_update = [
                        'active_template' => $active_template
                    ];
                    
                    // Also update theme colors to match the selected template's default colors
                    $template_info = $available_templates[$active_template];
                    if (!empty($template_info['colors'])) {
                        $colors = $template_info['colors'];
                        if (!empty($colors['primary'])) {
                            $settings_to_update['theme_primary_color'] = $colors['primary'];
                        }
                        if (!empty($colors['secondary'])) {
                            $settings_to_update['theme_secondary_color'] = $colors['secondary'];
                        }
                        if (!empty($colors['accent'])) {
                            $settings_to_update['theme_accent_color'] = $colors['accent'];
                        }
                        if (!empty($colors['background'])) {
                            $settings_to_update['theme_background_color'] = $colors['background'];
                        }
                    }
                } else {
                    $this->session->set_flashdata('error', 'Invalid template selected.');
                    redirect('admin/settings?tab=' . $tab);
                    return;
                }
                break;

            case 'theme':
                $settings_to_update = [
                    'theme_primary_color' => $this->input->post('theme_primary_color'),
                    'theme_secondary_color' => $this->input->post('theme_secondary_color'),
                    'theme_accent_color' => $this->input->post('theme_accent_color'),
                    'theme_background_color' => $this->input->post('theme_background_color'),
                    'theme_sidebar_bg_color' => $this->input->post('theme_sidebar_bg_color'),
                    'theme_enable_gradients' => $this->input->post('theme_enable_gradients') ? '1' : '0',
                    'theme_enable_shadows' => $this->input->post('theme_enable_shadows') ? '1' : '0',
                    'theme_text_color' => $this->input->post('theme_text_color')
                ];
                break;

            case 'seo':
                $settings_to_update = [
                    'seo_ai_enabled' => $this->input->post('seo_ai_enabled') ? '1' : '0',
                    'seo_ai_provider' => $this->input->post('seo_ai_provider'),
                    'seo_ai_api_key' => $this->input->post('seo_ai_api_key')
                ];
                break;
        }

        // Get active template - settings are saved per template (except template selection itself)
        $this->load->helper('template');
        $active_template = get_active_template();
        
        // Template tab settings are saved as shared (null template) since they control which template is active
        // All other settings are saved for the specific active template
        $save_template = ($tab === 'template') ? null : $active_template;
        
        if ($this->Settings_model->update_batch($settings_to_update, $save_template)) {
            $this->session->set_flashdata('success', 'Settings have been updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update settings. Please try again.');
        }

        redirect('admin/settings?tab=' . $tab);
    }
    
    // ========== TEMPLATE CRUD METHODS ==========
    
    public function save_template()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $template_key = $this->input->post('template_key') ?: $this->input->post('template_name');
        $display_name = $this->input->post('display_name');
        $description = $this->input->post('description');
        $version = $this->input->post('version') ?: '1.0.0';
        $author = $this->input->post('author') ?: 'Unknown';
        $type = $this->input->post('type') ?: 'general';
        
        // Get colors
        $colors = [
            'primary' => $this->input->post('colors[primary]') ?: '#006EB0',
            'secondary' => $this->input->post('colors[secondary]') ?: '#0CA69C',
            'accent' => $this->input->post('colors[accent]') ?: '#E43834',
            'background' => $this->input->post('colors[background]') ?: '#E9F7F6'
        ];
        
        // Debug log received data
        log_message('info', '=== TEMPLATE SAVE DEBUG ===');
        log_message('info', 'template_key: ' . $template_key);
        log_message('info', 'display_name: ' . $display_name);
        log_message('info', 'description: ' . $description);
        log_message('info', 'version: ' . $version);
        log_message('info', 'author: ' . $author);
        log_message('info', 'type: ' . $type);
        log_message('info', 'colors: ' . json_encode($colors));
        
        // Validate
        if (empty($template_key) || empty($display_name)) {
            echo json_encode(['success' => false, 'message' => 'Template name and display name are required']);
            return;
        }
        
        // Validate template key format (lowercase, numbers, underscores, hyphens)
        if (!preg_match('/^[a-z0-9_-]+$/', $template_key)) {
            echo json_encode(['success' => false, 'message' => 'Template name can only contain lowercase letters, numbers, underscores, and hyphens']);
            return;
        }
        
        // Check if template folder exists
        $templates_path = FCPATH . 'assets/templates/';
        $template_path = $templates_path . $template_key . '/';
        $is_update = is_dir($template_path);
        
        if (!$is_update) {
            echo json_encode(['success' => false, 'message' => 'Template folder does not exist: ' . $template_path]);
            return;
        }
        
        log_message('info', 'is_update: ' . ($is_update ? 'true' : 'false'));
        
        // Save template settings to database (for this specific template)
        // All settings stored in site_settings table
        $result1 = $this->Settings_model->update('template_display_name', $display_name, $template_key, 'template');
        $result2 = $this->Settings_model->update('template_description', $description, $template_key, 'template');
        $result3 = $this->Settings_model->update('template_version', $version, $template_key, 'template');
        $result4 = $this->Settings_model->update('template_author', $author, $template_key, 'template');
        $result5 = $this->Settings_model->update('template_type', $type, $template_key, 'template');
        
        // Save theme colors for this template
        $result6 = $this->Settings_model->update('theme_primary_color', $colors['primary'], $template_key, 'theme');
        $result7 = $this->Settings_model->update('theme_secondary_color', $colors['secondary'], $template_key, 'theme');
        $result8 = $this->Settings_model->update('theme_accent_color', $colors['accent'], $template_key, 'theme');
        $result9 = $this->Settings_model->update('theme_background_color', $colors['background'], $template_key, 'theme');
        
        log_message('info', 'Save results: dn=' . ($result1?'1':'0') . ', desc=' . ($result2?'1':'0') . ', ver=' . ($result3?'1':'0') . ', auth=' . ($result4?'1':'0') . ', type=' . ($result5?'1':'0'));
        log_message('info', 'Color results: p=' . ($result6?'1':'0') . ', s=' . ($result7?'1':'0') . ', a=' . ($result8?'1':'0') . ', bg=' . ($result9?'1':'0'));
        
        // Verify the saves
        $verify_display = $this->Settings_model->get('template_display_name', $template_key);
        $verify_desc = $this->Settings_model->get('template_description', $template_key);
        $verify_primary = $this->Settings_model->get('theme_primary_color', $template_key);
        
        log_message('info', 'Verification - display_name: ' . ($verify_display ?: 'NOT FOUND'));
        log_message('info', 'Verification - description: ' . ($verify_desc ?: 'NOT FOUND'));
        log_message('info', 'Verification - primary_color: ' . ($verify_primary ?: 'NOT FOUND'));
        
        echo json_encode([
            'success' => true, 
            'message' => $is_update ? 'Template "' . $display_name . '" updated successfully!' : 'Template created successfully',
            'template' => [
                'name' => $template_key,
                'display_name' => $display_name,
                'description' => $description,
                'version' => $version,
                'author' => $author,
                'type' => $type,
                'colors' => $colors
            ],
            'debug' => [
                'template_key' => $template_key,
                'saved_display_name' => $display_name,
                'verified_display_name' => $verify_display,
                'verified_description' => $verify_desc,
                'verified_primary_color' => $verify_primary
            ]
        ]);
    }
    
    public function delete_template($template_key)
    {
        if (empty($template_key)) {
            $this->session->set_flashdata('error', 'Template key is required');
            redirect('admin/settings?tab=template');
            return;
        }
        
        // Get active template
        $this->load->helper('template');
        $active_template = get_active_template();
        
        // Cannot delete active template
        if ($template_key === $active_template) {
            $this->session->set_flashdata('error', 'Cannot delete the active template. Please activate a different template first.');
            redirect('admin/settings?tab=template');
            return;
        }
        
        // Delete from database (template settings)
        $this->db->where('setting_key', 'active_template');
        $this->db->where('template', $template_key);
        $this->db->delete('site_settings');
        
        // Also delete any template-specific settings
        $this->db->where('template', $template_key);
        $this->db->delete('site_settings');
        
        $this->session->set_flashdata('success', 'Template "' . htmlspecialchars($template_key) . '" has been removed from the database. The physical files have not been deleted.');
        redirect('admin/settings?tab=template');
    }
    
    public function activate_template($template_key)
    {
        if (empty($template_key)) {
            $this->session->set_flashdata('error', 'Template key is required');
            redirect('admin/settings?tab=template');
            return;
        }
        
        // Check if template exists
        $this->load->helper('template');
        $available_templates = get_available_templates();
        
        if (!array_key_exists($template_key, $available_templates)) {
            $this->session->set_flashdata('error', 'Template not found');
            redirect('admin/settings?tab=template');
            return;
        }
        
        // Update active template
        $this->Settings_model->update('active_template', $template_key, null, 'template');
        
        // Also sync theme colors with template defaults
        $template_info = $available_templates[$template_key];
        if (!empty($template_info['colors'])) {
            foreach ($template_info['colors'] as $key => $color) {
                $color_key = 'theme_' . $key . '_color';
                $this->Settings_model->update($color_key, $color, null, 'theme');
            }
        }
        
        $this->session->set_flashdata('success', 'Template "' . htmlspecialchars($template_info['display_name'] ?? $template_key) . '" is now active.');
        redirect('admin/settings?tab=template');
    }

    private function upload_file($field_name, $folder = 'uploads')
    {
        $config['upload_path'] = FCPATH . 'assets/images/' . $folder . '/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|ico|svg';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            return $folder . '/' . $upload_data['file_name'];
        } else {
            log_message('error', 'Upload failed for ' . $field_name . ': ' . $this->upload->display_errors('', ''));
        }

        return false;
    }

    public function clear_cache()
    {
        $this->load->driver('cache', ['adapter' => 'file']);
        $this->cache->clean();
        
        $this->session->set_flashdata('success', 'Cache has been cleared successfully.');
        redirect('admin/settings?tab=system');
    }

    public function test_email()
    {
        $this->load->library('email');
        
        $settings = $this->Settings_model->get_all();
        
        if (!empty($settings['smtp_host'])) {
            $config = [
                'protocol' => 'smtp',
                'smtp_host' => $settings['smtp_host'],
                'smtp_port' => $settings['smtp_port'] ?: 587,
                'smtp_user' => $settings['smtp_username'],
                'smtp_pass' => $settings['smtp_password'],
                'smtp_crypto' => $settings['smtp_encryption'] ?: 'tls',
                'mailtype' => 'html',
                'charset' => 'utf-8'
            ];
            $this->email->initialize($config);
        }
        
        $this->email->from($settings['site_email'] ?: 'noreply@example.com', $settings['email_from_name'] ?: 'System');
        $this->email->to($settings['admin_email']);
        $this->email->subject('Test Email from ' . ($settings['site_name'] ?: 'Your Website'));
        $this->email->message('<h2>Test Email</h2><p>This is a test email to verify your email settings are working correctly.</p>');
        
        if ($this->email->send()) {
            $this->session->set_flashdata('success', 'Test email sent successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to send test email. Error: ' . $this->email->print_debugger(['headers']));
        }
        
        redirect('admin/settings?tab=email');
    }

    public function get_sms_provider($id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $provider = $this->db->get_where('sms_providers', ['id' => $id])->row();
        
        if ($provider) {
            // Don't expose API key in response
            echo json_encode([
                'success' => true,
                'provider' => [
                    'id' => $provider->id,
                    'name' => $provider->name,
                    'api_endpoint' => $provider->api_endpoint,
                    'sender_id' => $provider->sender_id,
                    'api_headers' => $provider->api_headers,
                    'request_params' => $provider->request_params,
                    'http_method' => $provider->http_method,
                    'request_format' => $provider->request_format,
                    'is_active' => $provider->is_active
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Provider not found'
            ]);
        }
    }

    public function save_sms_provider()
    {
        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->load->library('form_validation');
        
        // Validation rules
        $this->form_validation->set_rules('provider_name', 'Provider Name', 'required|max_length[100]');
        $this->form_validation->set_rules('api_endpoint', 'API Endpoint', 'required|valid_url');
        $this->form_validation->set_rules('http_method', 'HTTP Method', 'required|in_list[GET,POST,PUT]');
        $this->form_validation->set_rules('request_format', 'Request Format', 'required|in_list[json,form]');
        
        if (!$this->form_validation->run()) {
            echo json_encode([
                'success' => false,
                'message' => 'Validation failed: ' . $this->form_validation->error_string()
            ]);
            return;
        }

        $provider_id = $this->input->post('provider_id');
        $api_key = $this->input->post('api_key');
        
        $data = [
            'name' => $this->input->post('provider_name'),
            'api_endpoint' => $this->input->post('api_endpoint'),
            'sender_id' => $this->input->post('sender_id'),
            'http_method' => $this->input->post('http_method'),
            'request_format' => $this->input->post('request_format'),
            'is_active' => $this->input->post('is_active') ? 1 : 0
        ];

        // Validate and store JSON fields
        $api_headers = $this->input->post('api_headers');
        if (!empty($api_headers)) {
            if (json_decode($api_headers) === null) {
                echo json_encode(['success' => false, 'message' => 'Invalid JSON in API Headers']);
                return;
            }
            $data['api_headers'] = $api_headers;
        } else {
            $data['api_headers'] = null;
        }

        $request_params = $this->input->post('request_params');
        if (!empty($request_params)) {
            if (json_decode($request_params) === null) {
                echo json_encode(['success' => false, 'message' => 'Invalid JSON in Request Parameters']);
                return;
            }
            $data['request_params'] = $request_params;
        } else {
            $data['request_params'] = null;
        }

        // Only update API key if provided (not empty)
        if (!empty($api_key)) {
            $data['api_key'] = $api_key;
        } elseif (empty($provider_id)) {
            // New provider requires API key
            echo json_encode(['success' => false, 'message' => 'API Key is required for new providers']);
            return;
        }

        if (empty($provider_id)) {
            // Create new provider
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            if ($this->db->insert('sms_providers', $data)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'SMS Provider added successfully',
                    'provider_id' => $this->db->insert_id()
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to add provider: ' . $this->db->error()['message']
                ]);
            }
        } else {
            // Update existing provider
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            if ($this->db->update('sms_providers', $data, ['id' => $provider_id])) {
                echo json_encode([
                    'success' => true,
                    'message' => 'SMS Provider updated successfully'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update provider: ' . $this->db->error()['message']
                ]);
            }
        }
    }

    public function delete_sms_provider($id)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('error', 'Invalid request method');
            redirect('admin/settings?tab=sms');
        }

        // Verify provider exists before deletion
        $provider = $this->db->get_where('sms_providers', ['id' => $id])->row();
        if (!$provider) {
            $this->session->set_flashdata('error', 'Provider not found');
            redirect('admin/settings?tab=sms');
        }

        if ($this->db->delete('sms_providers', ['id' => $id])) {
            $this->session->set_flashdata('success', 'SMS Provider deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete provider');
        }
        
        redirect('admin/settings?tab=sms');
    }

    // Menu Management Methods

    public function create_menu()
    {
        if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
            show_404();
        }

        $this->load->library('form_validation');
        
        $menu_name = $this->input->post('menu_name');
        $menu_label = $this->input->post('menu_label');
        $menu_location = $this->input->post('menu_location');
        $is_active = $this->input->post('is_active') ? 1 : 0;
        
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'required|max_length[255]');
        $this->form_validation->set_rules('menu_label', 'Menu Label', 'required|max_length[255]');
        $this->form_validation->set_rules('menu_location', 'Menu Location', 'required|max_length[255]');
        
        if (!$this->form_validation->run()) {
            echo json_encode([
                'success' => false,
                'message' => $this->form_validation->error_string()
            ]);
            return;
        }

        $data = [
            'menu_name' => $menu_name,
            'menu_label' => $menu_label,
            'menu_location' => $menu_location,
            'is_active' => $is_active,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Menu_model->create_menu($data)) {
            echo json_encode([
                'success' => true,
                'message' => 'Menu created successfully',
                'menu_id' => $this->db->insert_id()
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to create menu'
            ]);
        }
    }

    public function save_menu_item()
    {
        if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
            show_404();
        }

        try {
            $this->load->library('form_validation');
            
            $item_id = $this->input->post('item_id');
            $menu_id = $this->input->post('menu_id');
            $parent_id = $this->input->post('parent_id') ?: NULL;
            $item_label = $this->input->post('item_label');
            $item_url = $this->input->post('item_url');
            
            $this->form_validation->set_rules('menu_id', 'Menu', 'required|integer');
            $this->form_validation->set_rules('item_label', 'Menu Item Label', 'required|max_length[255]');
            
            if (!$this->form_validation->run()) {
                echo json_encode([
                    'success' => false,
                    'message' => $this->form_validation->error_string()
                ]);
                return;
            }

            // Verify menu exists
            $menu = $this->Menu_model->get_menu($menu_id);
            if (!$menu) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid menu selected'
                ]);
                return;
            }

            // If parent_id is set, verify it exists and is in the same menu
            if ($parent_id) {
                $parent = $this->Menu_model->get_menu_item($parent_id);
                if (!$parent || $parent->menu_id != $menu_id) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Invalid parent item selected'
                    ]);
                    return;
                }
            }

            // Calculate depth level based on parent
            $depth_level = 0;
            if ($parent_id) {
                $parent = $this->Menu_model->get_menu_item($parent_id);
                if ($parent) {
                    $depth_level = $parent->depth_level + 1;
                }
            }

            $data = [
                'menu_id' => $menu_id,
                'item_label' => $item_label,
                'item_url' => $item_url ?: NULL,
                'item_icon' => $this->input->post('item_icon'),
                'item_class' => $this->input->post('item_class'),
                'parent_id' => $parent_id,
                'target_blank' => $this->input->post('target_blank') ? 1 : 0,
                'is_visible' => $this->input->post('is_visible') ? 1 : 0,
                'menu_type' => $this->input->post('menu_type') ?: 'link',
                'depth_level' => $depth_level
            ];

            if (empty($item_id)) {
                // Create new item
                $data['display_order'] = $this->Menu_model->get_next_display_order($menu_id, $parent_id);
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');
                
                if ($this->Menu_model->create_menu_item($data)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Menu item created successfully',
                        'item_id' => $this->db->insert_id()
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to create menu item: ' . $this->db->error()['message']
                    ]);
                }
            } else {
                // Update existing item
                $existingItem = $this->Menu_model->get_menu_item($item_id);
                if (!$existingItem) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Menu item not found'
                    ]);
                    return;
                }

                // Only update display_order if needed
                if (!isset($data['display_order'])) {
                    $data['display_order'] = $existingItem->display_order;
                }
                $data['updated_at'] = date('Y-m-d H:i:s');
                
                if ($this->Menu_model->update_menu_item($item_id, $data)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Menu item updated successfully'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to update menu item: ' . $this->db->error()['message']
                    ]);
                }
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function delete_menu_item($item_id)
    {
        if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
            show_404();
        }

        $item = $this->Menu_model->get_menu_item($item_id);
        
        if (!$item) {
            echo json_encode([
                'success' => false,
                'message' => 'Menu item not found'
            ]);
            return;
        }

        if ($this->Menu_model->delete_menu_item($item_id)) {
            echo json_encode([
                'success' => true,
                'message' => 'Menu item deleted successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to delete menu item'
            ]);
        }
    }

    public function get_menu_items($menu_id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $items = $this->Menu_model->get_menu_items_tree($menu_id);
        
        echo json_encode([
            'success' => true,
            'items' => $items
        ]);
    }

    public function get_menu_item($item_id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $item = $this->Menu_model->get_menu_item($item_id);
        
        if ($item) {
            echo json_encode([
                'success' => true,
                'item' => $item
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Menu item not found'
            ]);
        }
    }

    public function reorder_menu_items()
    {
        if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
            show_404();
        }

        $items = json_decode($this->input->raw_input_stream, true);
        
        if (!is_array($items)) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid item data'
            ]);
            return;
        }

        if ($this->Menu_model->reorder_menu_items($items)) {
            echo json_encode([
                'success' => true,
                'message' => 'Menu items reordered successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to reorder menu items'
            ]);
        }
    }

    public function toggle_menu_item_visibility($item_id)
    {
        if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
            show_404();
        }

        $item = $this->Menu_model->get_menu_item($item_id);
        
        if (!$item) {
            echo json_encode([
                'success' => false,
                'message' => 'Menu item not found'
            ]);
            return;
        }

        $new_status = !$item->is_visible;
        
        if ($this->Menu_model->toggle_menu_item_visibility($item_id, $new_status)) {
            echo json_encode([
                'success' => true,
                'message' => 'Menu item visibility toggled successfully',
                'is_visible' => $new_status
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to toggle visibility'
            ]);
        }
    }
}
