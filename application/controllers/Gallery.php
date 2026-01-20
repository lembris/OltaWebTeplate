<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gallery_model');
        $this->load->helper('template');
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['main_page'] = '';
        $data['current_page_name'] = 'Gallery';
        
        $active_template = get_active_template();
        
        if ($active_template === 'college') {
            $data['page_title'] = 'Campus Gallery - Photos & Events';
            $data['meta_description'] = 'Browse photos of our campus, events, and student activities.';
        } else {
            $data['page_title'] = 'Safari Gallery - Wildlife Photos';
            $data['meta_description'] = 'Browse stunning photos from our safari adventures and wildlife encounters.';
        }

        // Get images from database
        $db_images = $this->Gallery_model->get_all(100);
        
        // Convert to array format for compatibility
        $all_images = [];
        foreach ($db_images as $img) {
            $all_images[] = [
                'id' => $img->id,
                'src' => $img->src,
                'thumb' => $img->thumb ?? $img->src,
                'title' => $img->title,
                'category' => $img->category,
                'description' => $img->description ?? '',
                'featured' => $img->is_featured
            ];
        }
        
        $total_images = count($all_images);
        $data['total_images'] = $total_images;
        $data['use_load_more'] = $total_images >= 50;
        $data['initial_batch_size'] = 24;
        $data['load_batch_size'] = 12;
        
        if ($data['use_load_more']) {
            $data['gallery_images'] = array_slice($all_images, 0, $data['initial_batch_size']);
            $data['all_gallery_images'] = $all_images;
        } else {
            $data['gallery_images'] = $all_images;
        }

        // Get categories from database
        $db_categories = $this->Gallery_model->get_categories();
        $categories = ['all'];
        foreach ($db_categories as $cat) {
            $categories[] = $cat->category;
        }
        $data['gallery_categories'] = $categories;
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        $template = get_active_template();
        $this->load->view('templates/' . $template . '/header', $data);
        $this->load->view('templates/' . $template . '/navigation', $data);
        load_template_page('gallery', $data);
        $this->load->view('templates/' . $template . '/footer', $data);
    }

    /**
     * AJAX endpoint to load more gallery images
     */
    public function load_more()
    {
        $offset = $this->input->post('offset');
        $batch_size = $this->input->post('batch_size') ?: 12;
        
        if (!is_numeric($offset) || $offset < 0) {
            echo json_encode(['error' => 'Invalid offset']);
            return;
        }

        $all_images = $this->get_gallery_images();
        $images = array_slice($all_images, $offset, $batch_size);
        
        echo json_encode([
            'success' => true,
            'images' => $images,
            'total_loaded' => $offset + count($images),
            'total_available' => count($all_images),
            'has_more' => ($offset + count($images)) < count($all_images)
        ]);
    }

    private function get_gallery_images()
    {
        return [
            // Safari Category
            [
                'id' => 1,
                'src' => 'assets/img/destinations/serengeti/serengeti-np1.jpg',
                'thumb' => 'assets/img/destinations/serengeti/serengeti-np1.jpg',
                'title' => 'Serengeti Game Drive',
                'category' => 'safari',
                'description' => 'Experience the thrill of a morning game drive in the Serengeti',
                'featured' => true
            ],
            [
                'id' => 2,
                'src' => 'assets/img/destinations/serengeti/serengeti-np2.jpg',
                'thumb' => 'assets/img/destinations/serengeti/serengeti-np2.jpg',
                'title' => 'Safari Vehicle Adventure',
                'category' => 'safari',
                'description' => 'Our 4x4 vehicles ready for the ultimate safari experience',
                'featured' => true
            ],
            [
                'id' => 3,
                'src' => 'assets/img/destinations/ngorongoro/ngorongoro1.jpg',
                'thumb' => 'assets/img/destinations/ngorongoro/ngorongoro1.jpg',
                'title' => 'Ngorongoro Crater Safari',
                'category' => 'safari',
                'description' => 'Descending into the world-famous Ngorongoro Crater',
                'featured' => false
            ],
            // Wildlife Category
            [
                'id' => 4,
                'src' => 'assets/img/destinations/serengeti/serengeti-np3.jpg',
                'thumb' => 'assets/img/destinations/serengeti/serengeti-np3.jpg',
                'title' => 'Lions of the Serengeti',
                'category' => 'wildlife',
                'description' => 'Majestic lions resting in the African savanna',
                'featured' => true
            ],
            [
                'id' => 5,
                'src' => 'assets/img/destinations/serengeti/serengeti-np4.jpg',
                'thumb' => 'assets/img/destinations/serengeti/serengeti-np4.jpg',
                'title' => 'Great Migration',
                'category' => 'wildlife',
                'description' => 'Witness millions of wildebeest crossing the plains',
                'featured' => true
            ],
            [
                'id' => 6,
                'src' => 'assets/img/destinations/tarangire/tarangire-np1.jpg',
                'thumb' => 'assets/img/destinations/tarangire/tarangire-np1.jpg',
                'title' => 'Elephant Herds',
                'category' => 'wildlife',
                'description' => 'Large elephant families in Tarangire National Park',
                'featured' => true
            ],
            [
                'id' => 7,
                'src' => 'assets/img/destinations/ngorongoro/ngorongoro2.jpg',
                'thumb' => 'assets/img/destinations/ngorongoro/ngorongoro2.jpg',
                'title' => 'Flamingos at Crater Lake',
                'category' => 'wildlife',
                'description' => 'Pink flamingos at the soda lake in Ngorongoro',
                'featured' => false
            ],
            // Landscapes Category
            [
                'id' => 8,
                'src' => 'assets/img/destinations/serengeti/serengeti-np5.jpg',
                'thumb' => 'assets/img/destinations/serengeti/serengeti-np5.jpg',
                'title' => 'Serengeti Sunset',
                'category' => 'landscapes',
                'description' => 'Breathtaking African sunset over the endless plains',
                'featured' => true
            ],
            [
                'id' => 9,
                'src' => 'assets/img/destinations/kilimanjaro/kilimanjaro1.jpg',
                'thumb' => 'assets/img/destinations/kilimanjaro/kilimanjaro1.jpg',
                'title' => 'Mount Kilimanjaro',
                'category' => 'landscapes',
                'description' => 'Africa\'s highest peak rising above the clouds',
                'featured' => true
            ],
            [
                'id' => 10,
                'src' => 'assets/img/destinations/zanzibar/zanzibar1.jpg',
                'thumb' => 'assets/img/destinations/zanzibar/zanzibar1.jpg',
                'title' => 'Zanzibar Beach Paradise',
                'category' => 'landscapes',
                'description' => 'Crystal clear waters and white sandy beaches',
                'featured' => false
            ],
            [
                'id' => 11,
                'src' => 'assets/img/destinations/lake-manyara/lake-manyara1.jpg',
                'thumb' => 'assets/img/destinations/lake-manyara/lake-manyara1.jpg',
                'title' => 'Lake Manyara Views',
                'category' => 'landscapes',
                'description' => 'Stunning views of Lake Manyara and the rift valley',
                'featured' => false
            ],
            // Culture Category
            [
                'id' => 12,
                'src' => 'assets/img/destinations/zanzibar/zanzibar2.jpg',
                'thumb' => 'assets/img/destinations/zanzibar/zanzibar2.jpg',
                'title' => 'Maasai Village Visit',
                'category' => 'culture',
                'description' => 'Experience authentic Maasai traditions and culture',
                'featured' => true
            ],
            [
                'id' => 13,
                'src' => 'assets/img/destinations/zanzibar/zanzibar3.jpg',
                'thumb' => 'assets/img/destinations/zanzibar/zanzibar3.jpg',
                'title' => 'Stone Town Heritage',
                'category' => 'culture',
                'description' => 'Explore the historic streets of Stone Town',
                'featured' => false
            ],
            [
                'id' => 14,
                'src' => 'assets/img/destinations/zanzibar/zanzibar4.jpg',
                'thumb' => 'assets/img/destinations/zanzibar/zanzibar4.jpg',
                'title' => 'Spice Farm Tour',
                'category' => 'culture',
                'description' => 'Discover the aromatic spice plantations of Zanzibar',
                'featured' => false
            ],
            // Accommodation Category
            [
                'id' => 15,
                'src' => 'assets/img/destinations/serengeti/serengeti-np6.jpg',
                'thumb' => 'assets/img/destinations/serengeti/serengeti-np6.jpg',
                'title' => 'Luxury Safari Lodge',
                'category' => 'accommodation',
                'description' => 'Premium lodges with stunning savanna views',
                'featured' => true
            ],
            [
                'id' => 16,
                'src' => 'assets/img/destinations/serengeti/serengeti-np7.jpg',
                'thumb' => 'assets/img/destinations/serengeti/serengeti-np7.jpg',
                'title' => 'Tented Safari Camp',
                'category' => 'accommodation',
                'description' => 'Authentic camping experience under African skies',
                'featured' => false
            ],
            [
                'id' => 17,
                'src' => 'assets/img/destinations/ngorongoro/ngorongoro3.jpg',
                'thumb' => 'assets/img/destinations/ngorongoro/ngorongoro3.jpg',
                'title' => 'Crater Rim Lodge',
                'category' => 'accommodation',
                'description' => 'Wake up to spectacular crater views',
                'featured' => false
            ],
            [
                'id' => 18,
                'src' => 'assets/img/destinations/zanzibar/zanzibar5.jpg',
                'thumb' => 'assets/img/destinations/zanzibar/zanzibar5.jpg',
                'title' => 'Beach Resort',
                'category' => 'accommodation',
                'description' => 'Beachfront luxury on the Indian Ocean',
                'featured' => false
            ],
        ];
    }

    public function get_featured_images()
    {
        $all_images = $this->get_gallery_images();
        return array_filter($all_images, function($img) {
            return $img['featured'] === true;
        });
    }
}
