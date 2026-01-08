<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SEO Generator Library
 * Provides quick PHP-based SEO generation and AI-powered enhancement
 */
class SeoGenerator
{
    private $CI;
    private $ai_enabled = false;
    private $ai_provider = null; // 'openai' or 'claude'
    private $ai_api_key = null;

    public function __construct()
    {
        $this->CI =& get_instance();
        
        // Load settings from database
        $this->CI->load->model('Settings_model');
        $settings = $this->CI->Settings_model->get_all();
        
        // Check if AI is enabled from database settings
        if (isset($settings['seo_ai_enabled']) && $settings['seo_ai_enabled'] == '1') {
            $this->ai_enabled = true;
            $this->ai_provider = $settings['seo_ai_provider'] ?? 'openai';
            $this->ai_api_key = $settings['seo_ai_api_key'] ?? null;
        }
    }

    /**
     * Quick PHP-based SEO generation
     */
    public function generate_quick($type, $data)
    {
        $title = $data['title'] ?? $data['name'] ?? '';
        $content = $data['description'] ?? $data['content'] ?? '';
        $excerpt = $data['excerpt'] ?? $data['short_description'] ?? '';

        return [
            'meta_title' => $this->generate_title($title, $type),
            'meta_description' => $this->generate_description($excerpt ?: $content),
            'seo_keywords' => $this->extract_keywords($content ?: $excerpt),
            'alt_text' => $this->generate_alt_text($title)
        ];
    }

    /**
     * AI-powered SEO enhancement
     */
    public function generate_ai($type, $data)
    {
        if (!$this->ai_enabled || !$this->ai_api_key) {
            return $this->generate_quick($type, $data);
        }

        $title = $data['title'] ?? $data['name'] ?? '';
        $content = $data['description'] ?? $data['content'] ?? '';
        $excerpt = $data['excerpt'] ?? $data['short_description'] ?? '';

        $prompt = $this->build_seo_prompt($type, $title, $excerpt, $content);

        if ($this->ai_provider === 'openai') {
            return $this->call_openai($prompt);
        } elseif ($this->ai_provider === 'claude') {
            return $this->call_claude($prompt);
        }

        return $this->generate_quick($type, $data);
    }

    /**
     * Build SEO generation prompt for AI
     */
    private function build_seo_prompt($type, $title, $excerpt, $content)
    {
        $type_names = [
            'packages' => 'safari package',
            'blog' => 'blog post',
            'pages' => 'web page',
            'gallery' => 'image'
        ];

        $type_name = $type_names[$type] ?? 'content';

        return <<<PROMPT
You are an SEO expert. Generate SEO metadata for a $type_name.

Title: $title
Excerpt/Short Description: $excerpt
Content/Full Description: 
$content

Generate a JSON response with exactly these fields:
{
  "meta_title": "SEO-optimized title (50-60 characters)",
  "meta_description": "SEO-optimized description (150-160 characters)",
  "seo_keywords": "5-7 comma-separated keywords relevant to the content",
  "alt_text": "Descriptive alt text for images (100-125 characters)"
}

Requirements:
- Meta title should be compelling and include primary keyword
- Meta description should summarize the content and include CTA
- Keywords should be relevant, long-tail keywords
- Alt text should be descriptive for accessibility
- Return ONLY valid JSON, no other text

PROMPT;
    }

    /**
     * Call OpenAI API
     */
    private function call_openai($prompt)
    {
        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        
        $payload = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an SEO expert AI assistant.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.7,
            'max_tokens' => 500
        ];

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->ai_api_key
            ],
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200) {
            log_message('error', 'OpenAI API Error: ' . $response);
            return null;
        }

        $result = json_decode($response, true);
        if (isset($result['choices'][0]['message']['content'])) {
            $content = $result['choices'][0]['message']['content'];
            return $this->parse_ai_response($content);
        }

        return null;
    }

    /**
     * Call Claude API
     */
    private function call_claude($prompt)
    {
        $ch = curl_init('https://api.anthropic.com/v1/messages');
        
        $payload = [
            'model' => 'claude-3-sonnet-20240229',
            'max_tokens' => 500,
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ]
        ];

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'x-api-key: ' . $this->ai_api_key,
                'anthropic-version: 2023-06-01'
            ],
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200) {
            log_message('error', 'Claude API Error: ' . $response);
            return null;
        }

        $result = json_decode($response, true);
        if (isset($result['content'][0]['text'])) {
            $content = $result['content'][0]['text'];
            return $this->parse_ai_response($content);
        }

        return null;
    }

    /**
     * Parse AI response and extract JSON
     */
    private function parse_ai_response($content)
    {
        // Try to extract JSON from the response
        preg_match('/\{[\s\S]*\}/', $content, $matches);
        
        if (empty($matches)) {
            return null;
        }

        $json = json_decode($matches[0], true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return [
            'meta_title' => substr($json['meta_title'] ?? '', 0, 70),
            'meta_description' => substr($json['meta_description'] ?? '', 0, 160),
            'seo_keywords' => $json['seo_keywords'] ?? '',
            'alt_text' => substr($json['alt_text'] ?? '', 0, 125)
        ];
    }

    /**
     * Generate SEO title
     */
    private function generate_title($title, $type = '')
    {
        $max_length = 60;
        $title = trim($title);

        if (strlen($title) <= $max_length) {
            return $title;
        }

        // Truncate intelligently at word boundary
        $truncated = substr($title, 0, $max_length);
        $last_space = strrpos($truncated, ' ');
        
        if ($last_space > 0) {
            return substr($truncated, 0, $last_space);
        }

        return $truncated;
    }

    /**
     * Generate SEO description
     */
    private function generate_description($text)
    {
        $max_length = 160;
        
        // Strip HTML tags
        $text = strip_tags($text);
        $text = trim(preg_replace('/\s+/', ' ', $text));

        if (strlen($text) <= $max_length) {
            return $text;
        }

        // Truncate at word boundary
        $truncated = substr($text, 0, $max_length);
        $last_space = strrpos($truncated, ' ');
        
        if ($last_space > 0) {
            $text = substr($truncated, 0, $last_space);
        } else {
            $text = $truncated;
        }

        // Add ellipsis if truncated
        if (strlen($text) < strlen(strip_tags($text))) {
            $text = rtrim($text, '.') . '...';
        }

        return $text;
    }

    /**
     * Extract keywords from content
     */
    private function extract_keywords($text)
    {
        // Remove HTML
        $text = strip_tags($text);
        
        // Convert to lowercase
        $text = strtolower($text);
        
        // Remove common stop words
        $stop_words = [
            'the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for',
            'of', 'with', 'is', 'are', 'was', 'were', 'be', 'been', 'being',
            'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could',
            'should', 'may', 'might', 'must', 'can', 'this', 'that', 'these',
            'those', 'i', 'you', 'he', 'she', 'it', 'we', 'they', 'what', 'which',
            'who', 'when', 'where', 'why', 'how', 'all', 'each', 'every', 'both',
            'few', 'more', 'most', 'some', 'such', 'no', 'nor', 'not', 'only',
            'same', 'so', 'than', 'too', 'very', 'as', 'safari', 'tour', 'travel'
        ];

        // Split into words
        preg_match_all('/\b[a-z]{3,}\b/i', $text, $matches);
        $words = $matches[0];

        // Count word frequencies
        $word_freq = array_count_values($words);

        // Filter stop words and low frequency
        $keywords = [];
        foreach ($word_freq as $word => $freq) {
            if (!in_array(strtolower($word), $stop_words) && $freq >= 2) {
                $keywords[$word] = $freq;
            }
        }

        // Sort by frequency
        arsort($keywords);

        // Get top 6 keywords
        $top_keywords = array_keys(array_slice($keywords, 0, 6));
        
        return implode(', ', $top_keywords);
    }

    /**
     * Generate alt text for images
     */
    private function generate_alt_text($title)
    {
        $max_length = 125;
        $alt_text = trim($title);

        if (strlen($alt_text) <= $max_length) {
            return $alt_text;
        }

        $truncated = substr($alt_text, 0, $max_length);
        $last_space = strrpos($truncated, ' ');
        
        if ($last_space > 0) {
            return substr($truncated, 0, $last_space);
        }

        return $truncated;
    }

    /**
     * Check if AI is enabled
     */
    public function is_ai_enabled()
    {
        return $this->ai_enabled && !empty($this->ai_api_key);
    }
}
