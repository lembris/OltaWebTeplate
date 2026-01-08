<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seo extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('SeoGenerator');
    }

    /**
     * Generate quick SEO (PHP-based)
     * POST /admin/seo/generate-quick
     */
    public function generate_quick()
    {
        // Read JSON body (not POST parameters)
        $input = json_decode($this->input->raw_input_stream, true);

        if (empty($input) || empty($input['type'])) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Invalid request']));
            return;
        }

        try {
            $type = $input['type'];
            $seo = $this->seogenerator->generate_quick($type, $input);
            
            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'data' => $seo
                ]));
        } catch (Exception $e) {
            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'error' => 'Failed to generate SEO: ' . $e->getMessage()
                ]));
        }
    }

    /**
     * Generate AI-powered SEO
     * POST /admin/seo/generate-ai
     */
    public function generate_ai()
    {
        // Read JSON body (not POST parameters)
        $input = json_decode($this->input->raw_input_stream, true);

        if (empty($input) || empty($input['type'])) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Invalid request']));
            return;
        }

        // Check if AI is enabled
        if (!$this->seogenerator->is_ai_enabled()) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'error' => 'AI features not configured. Please set up API key in admin settings.'
                ]));
            return;
        }

        try {
            $type = $input['type'];
            $seo = $this->seogenerator->generate_ai($type, $input);
            
            if ($seo === null) {
                throw new Exception('AI API returned invalid response');
            }

            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'data' => $seo
                ]));
        } catch (Exception $e) {
            log_message('error', 'SEO AI Generation Error: ' . $e->getMessage());
            
            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'error' => 'Failed to generate AI SEO. Using quick generation instead.',
                    'fallback' => true
                ]));
        }
    }

    /**
     * Check if AI is enabled
     * GET /admin/seo/ai-status
     */
    public function ai_status()
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'ai_enabled' => $this->seogenerator->is_ai_enabled()
            ]));
    }
}
