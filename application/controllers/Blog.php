<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->library('pagination');
        $this->load->helper(['template', 'text']);
    }

    /**
     * Blog listing page with pagination
     */
    public function index($page = 1)
    {
        $limit = 12;
        $page = max(1, (int)$page); // Ensure page is at least 1
        $total = $this->Blog_model->get_published_count();

        // Pagination config
        $config['base_url'] = base_url('blog/page/');
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;

        // Bootstrap 5 pagination styling
        $config['attributes'] = ['class' => 'pagination'];
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        // Get posts - ensure offset is never negative
        $offset = ($page - 1) * $limit;
        $offset = max(0, $offset);
        $data['posts'] = $this->Blog_model->get_published_posts($limit, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['total_posts'] = $total;
        $data['categories'] = $this->Blog_model->get_categories();
        $data['latest_posts'] = $this->Blog_model->get_latest_posts(5);
        
        // Page meta
        $data['current_page_name'] = 'Blog';
        $data['main_page'] = 'Blog';
        
        $active_template = get_active_template();
        if ($active_template === 'medical') {
            $data['page_title'] = 'Health Blog | TNA CARE - Health Tips & Medical Insights';
            $data['meta_description'] = 'Expert health tips, medical insights, and wellness guidance from TNA CARE healthcare professionals. Stay informed about health topics.';
            $data['meta_keywords'] = 'health blog Tanzania, medical tips, health education, wellness guidance, TNA CARE blog';
            $data['canonical_url'] = base_url('blog');
            $data['og_image'] = base_url('assets/templates/medical/img/health/tna-female-doctor-community-health.png');
        } else {
            $data['page_title'] = 'Safari Blog - Travel Tips & Guides';
            $data['meta_description'] = 'Expert safari travel tips, wildlife guides, and Tanzania destination advice from Osiram Safari Adventure.';
        }
        
        // Merge common data
        $data = array_merge($this->get_common_data(), $data);
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('blog', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * Single blog post detail page
     */
    public function post($slug)
    {
        $data = $this->get_common_data();
        $data['post'] = $this->Blog_model->get_by_slug($slug);

        if (!$data['post']) {
            $data['page_title'] = 'Post Not Found';
            $data['current_page_name'] = 'Post Not Found';
            $data['main_page'] = 'Blog';
            $data['latest_posts'] = $this->Blog_model->get_latest_posts(3);
            
            // Load footer programs for college template
            $data['footer_programs'] = $this->get_footer_programs();
            
            $template = get_active_template();
            $this->load->view('templates/' . $template . '/header', $data);
            $this->load->view('templates/' . $template . '/navigation', $data);
            load_template_page('blog-404', $data);
            $this->load->view('templates/' . $template . '/footer', $data);
            return;
        }

        $this->Blog_model->increment_views($data['post']->id);

        // Get active template for theme-aware queries
        $this->load->helper('template');
        $active_template = get_active_template();

        $data['related_posts'] = $this->Blog_model->get_related_posts(
            $slug, 
            $data['post']->category, 
            3,
            $active_template
        );

        $data['latest_posts'] = $this->Blog_model->get_latest_posts(5);
        $data['categories'] = $this->Blog_model->get_categories();
        
        // Get theme sidebar background color setting
        $this->load->model('Settings_model');
        $data['sidebar_bg_color'] = $this->Settings_model->get('theme_sidebar_bg_color', $active_template) ?: '#f8f9fa';
        
        $data['current_page_name'] = $data['post']->title;
        $data['main_page'] = 'Blog';
        $data['page_title'] = $data['post']->seo_title ?: $data['post']->title;
        $data['meta_description'] = $data['post']->seo_description ?: substr(strip_tags($data['post']->excerpt ?: $data['post']->content), 0, 160);
        
        // Medical template OG image
        $active_template = get_active_template();
        if ($active_template === 'medical') {
            $data['og_image'] = !empty($data['post']->featured_image) 
                ? base_url('assets/img/blog/' . $data['post']->featured_image)
                : base_url('assets/templates/medical/img/health/tna-female-doctor-community-health.png');
            $data['canonical_url'] = base_url('blog/post/' . $data['post']->slug);
        }
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('blog-single', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * Posts by category
     */
    public function category($category, $page = 1)
    {
        $this->load->helper('template');
        
        // Convert URL-safe format back to original category name
        $category = str_replace('-', ' ', $category);
        $category = urldecode($category);
        $limit = 12;
        $page = max(1, (int)$page); // Ensure page is at least 1
        
        // Get theme-aware count
        $theme = get_active_template();
        $total = $this->Blog_model->get_category_count($category, $theme);

        if ($total == 0) {
            show_404();
        }

        // Pagination config
        $config['base_url'] = base_url('blog/category/' . str_replace(' ', '-', $category) . '/');
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;

        $config['attributes'] = ['class' => 'pagination'];
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        // Get posts - ensure offset is never negative
        $offset = max(0, ($page - 1) * $limit);
        $data['posts'] = $this->Blog_model->get_by_category($category, $limit, $offset, $theme);
        $data['pagination'] = $this->pagination->create_links();
        $data['category'] = $category;
        $data['categories'] = $this->Blog_model->get_categories($theme);
        $data['latest_posts'] = $this->Blog_model->get_latest_posts(5, $theme);
        
        // Page meta
        $category_name = ucfirst(str_replace('-', ' ', $category));
        $data['current_page_name'] = $category_name . ' Articles';
        $data['main_page'] = 'Blog';
        $data['page_title'] = $category_name . ' - Safari Blog';
        $data['meta_description'] = 'Browse ' . $category_name . ' articles and guides from Osiram Safari Adventure.';
        
        // Merge common data
        $data = array_merge($this->get_common_data(), $data);
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('blog-category', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * Search blog posts
     */
    public function search()
    {
        $keyword = $this->input->get('q');

        if (empty($keyword)) {
            redirect('blog');
        }

        $this->load->helper('template');
        $theme = get_active_template();
        
        $page = max(1, (int)$this->input->get('page', TRUE) ?: 1);
        $limit = 12;
        $total = $this->Blog_model->get_search_count($keyword, $theme);

        $config['base_url'] = base_url('blog/search/');
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['query_string_segment'] = 'page';
        $config['enable_query_strings'] = TRUE;
        $config['attributes'] = ['class' => 'pagination'];
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $offset = max(0, ($page - 1) * $limit);
        $data['posts'] = $this->Blog_model->search($keyword, $limit, $offset, $theme);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword'] = $keyword;
        $data['total_results'] = $total;
        $data['categories'] = $this->Blog_model->get_categories($theme);
        $data['latest_posts'] = $this->Blog_model->get_latest_posts(5, $theme);
        
        $data['current_page_name'] = 'Search Results';
        $data['main_page'] = 'Blog';
        $data['page_title'] = 'Search: ' . $keyword . ' - Blog';
        $data['meta_description'] = 'Search results for "' . $keyword . '" in our blog.';
        
        $data = array_merge($this->get_common_data(), $data);

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('blog-search', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * API endpoint: Get latest posts (for homepage widget)
     */
    public function api_latest()
    {
        $this->output->set_content_type('application/json');
        $posts = $this->Blog_model->get_latest_posts(3);
        echo json_encode($posts);
    }

    /**
     * API endpoint: Get most viewed posts
     */
    public function api_most_viewed()
    {
        $this->output->set_content_type('application/json');
        $this->load->helper('template');
        $theme = get_active_template();
        $posts = $this->Blog_model->get_most_viewed(5, $theme);
        echo json_encode(['posts' => $posts]);
    }

    /**
     * API endpoint: Get popular tags
     */
    public function api_popular_tags()
    {
        $this->output->set_content_type('application/json');
        $this->load->helper('template');
        $theme = get_active_template();
        $tags = $this->Blog_model->get_popular_tags(8, $theme);
        echo json_encode(['tags' => $tags]);
    }
}
