<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SEO Configuration
 */

$config['ai'] = [
    'enabled' => false,  // Set to true to enable AI features
    'provider' => 'openai',  // 'openai' or 'claude'
    'api_key' => ''  // Your API key here
];

/**
 * SETUP INSTRUCTIONS:
 * 
 * 1. For OpenAI:
 *    - Get API key from: https://platform.openai.com/api-keys
 *    - Set provider to 'openai'
 *    - Set api_key to your key
 * 
 * 2. For Claude:
 *    - Get API key from: https://console.anthropic.com/
 *    - Set provider to 'claude'
 *    - Set api_key to your key
 * 
 * Example:
 * $config['ai'] = [
 *     'enabled' => true,
 *     'provider' => 'openai',
 *     'api_key' => 'sk-...'
 * ];
 */
