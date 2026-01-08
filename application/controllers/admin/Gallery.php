<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends Admin_Controller 
{
    private $upload_path = './assets/img/gallery/';
    private $categories = [
        'safari' => 'Safari',
        'wildlife' => 'Wildlife',
        'landscapes' => 'Landscapes',
        'culture' => 'Culture',
        'accommodation' => 'Accommodation',
        'adventure' => 'Adventure',
        'beach' => 'Beach',
        'mountain' => 'Mountain'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gallery_model');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['form', 'url', 'text']);
        
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    /**
     * List all gallery images
     */
    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Gallery';
        $data['categories'] = $this->categories;
        $data['active_template'] = get_active_template();
        
        // Search and filter
        $keyword = $this->input->get('search');
        $category = $this->input->get('category');
        
        if (!empty($keyword)) {
            $data['images'] = $this->Gallery_model->search($keyword);
            $data['search_keyword'] = $keyword;
        } elseif (!empty($category) && $category !== 'all') {
            $data['images'] = $this->Gallery_model->get_by_category($category, 100);
            $data['active_category'] = $category;
        } else {
            $data['images'] = $this->get_all_images();
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/gallery/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Get all images for active theme (including inactive status)
     */
    private function get_all_images()
    {
        return $this->Gallery_model->get_all_by_theme();
    }

    /**
     * Create new gallery image
     */
    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Add Gallery Image';
        $data['image'] = null;
        $data['categories'] = $this->categories;
        $data['form_action'] = base_url('admin/gallery/create');

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('category', 'Category', 'required');

            if ($this->form_validation->run() === TRUE) {
                $image_data = [
                    'title' => $this->input->post('title', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'category' => $this->input->post('category', TRUE),
                    'alt_text' => $this->input->post('alt_text', TRUE) ?: $this->input->post('title', TRUE),
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                    'display_order' => $this->input->post('display_order') ?: 0,
                    'theme' => get_active_template()
                ];

                // Handle image upload
                if (!empty($_FILES['image']['name'])) {
                    $uploaded = $this->upload_image('image');
                    if ($uploaded) {
                        $image_data['src'] = 'assets/img/gallery/' . $uploaded;
                    } else {
                        $this->session->set_flashdata('error', 'Image upload failed. Please try again.');
                        redirect('admin/gallery/create');
                        return;
                    }
                } else {
                    $this->session->set_flashdata('error', 'Please select an image to upload.');
                    redirect('admin/gallery/create');
                    return;
                }

                if ($this->Gallery_model->create($image_data)) {
                    $this->session->set_flashdata('success', 'Gallery image added successfully.');
                    redirect('admin/gallery');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add gallery image.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/gallery/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Edit gallery image
     */
    public function edit($uid)
    {
        $image = $this->Gallery_model->get_by_uid($uid);
        if (!$image) {
            $this->session->set_flashdata('error', 'Image not found.');
            redirect('admin/gallery');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Gallery Image';
        $data['image'] = $image;
        $data['categories'] = $this->categories;
        $data['form_action'] = base_url('admin/gallery/edit/' . $uid);

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('category', 'Category', 'required');

            if ($this->form_validation->run() === TRUE) {
                $image_data = [
                    'title' => $this->input->post('title', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'category' => $this->input->post('category', TRUE),
                    'alt_text' => $this->input->post('alt_text', TRUE) ?: $this->input->post('title', TRUE),
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                    'display_order' => $this->input->post('display_order') ?: 0
                ];

                // Handle new image upload
                if (!empty($_FILES['image']['name'])) {
                    $uploaded = $this->upload_image('image');
                    if ($uploaded) {
                        // Delete old image
                        $this->delete_image_file($image->src);
                        $image_data['src'] = 'assets/img/gallery/' . $uploaded;
                    }
                }

                if ($this->Gallery_model->update($uid, $image_data)) {
                    $this->session->set_flashdata('success', 'Gallery image updated successfully.');
                    redirect('admin/gallery');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update gallery image.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/gallery/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Delete gallery image
     */
    public function delete($uid)
    {
        $image = $this->Gallery_model->get_by_uid($uid);
        if (!$image) {
            $this->session->set_flashdata('error', 'Image not found.');
            redirect('admin/gallery');
        }

        // Delete image file
        $this->delete_image_file($image->src);

        if ($this->Gallery_model->delete($uid)) {
            $this->session->set_flashdata('success', 'Gallery image deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete gallery image.');
        }

        redirect('admin/gallery');
    }

    /**
     * Toggle featured status (AJAX)
     */
    public function toggle_featured($uid)
    {
        if (!$this->input->is_ajax_request()) {
            $this->session->set_flashdata('error', 'Invalid request.');
            redirect('admin/gallery');
        }

        $image = $this->Gallery_model->get_by_uid($uid);
        if (!$image) {
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Image not found']);
            return;
        }

        $new_status = $image->is_featured ? 0 : 1;
        $result = $this->Gallery_model->toggle_featured($uid, $new_status);

        $this->output->set_content_type('application/json');
        echo json_encode([
            'success' => $result,
            'is_featured' => $new_status,
            'message' => $result ? 'Featured status updated' : 'Failed to update status'
        ]);
    }

    /**
     * Toggle active status (AJAX)
     */
    public function toggle_active($uid)
    {
        if (!$this->input->is_ajax_request()) {
            $this->session->set_flashdata('error', 'Invalid request.');
            redirect('admin/gallery');
        }

        $image = $this->Gallery_model->get_by_uid($uid);
        if (!$image) {
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Image not found']);
            return;
        }

        $new_status = $image->is_active ? 0 : 1;
        $result = $this->Gallery_model->toggle_active($uid, $new_status);

        $this->output->set_content_type('application/json');
        echo json_encode([
            'success' => $result,
            'is_active' => $new_status,
            'message' => $result ? 'Status updated successfully' : 'Failed to update status'
        ]);
    }

    /**
     * Update display order (AJAX)
     */
    public function update_order()
    {
        if (!$this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $orders = $this->input->post('orders');
        if (empty($orders)) {
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'No data provided']);
            return;
        }

        // Decode JSON if it's a string
        if (is_string($orders)) {
            $orders = json_decode($orders, true);
        }

        if (!is_array($orders)) {
            $this->output->set_content_type('application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid data format']);
            return;
        }

        foreach ($orders as $order) {
            $this->Gallery_model->update_order($order['uid'], $order['position']);
        }

        $this->output->set_content_type('application/json');
        echo json_encode(['success' => true, 'message' => 'Order updated successfully']);
    }

    /**
     * Bulk upload images
     */
    public function bulk_upload()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Bulk Upload Images';
        $data['categories'] = $this->categories;

        if ($this->input->post()) {
            $category = $this->input->post('category', TRUE) ?: 'safari';
            $is_featured = $this->input->post('is_featured') ? 1 : 0;
            
            if (!empty($_FILES['images']['name'][0])) {
                $uploaded_count = 0;
                $total_files = count($_FILES['images']['name']);
                
                for ($i = 0; $i < $total_files; $i++) {
                    if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                        $_FILES['image']['name'] = $_FILES['images']['name'][$i];
                        $_FILES['image']['type'] = $_FILES['images']['type'][$i];
                        $_FILES['image']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
                        $_FILES['image']['error'] = $_FILES['images']['error'][$i];
                        $_FILES['image']['size'] = $_FILES['images']['size'][$i];
                        
                        $uploaded = $this->upload_image('image');
                        if ($uploaded) {
                            $title = pathinfo($_FILES['images']['name'][$i], PATHINFO_FILENAME);
                            $title = str_replace(['_', '-'], ' ', $title);
                            $title = ucwords($title);
                            
                            $image_data = [
                                'title' => $title,
                                'category' => $category,
                                'alt_text' => $title,
                                'is_featured' => $is_featured,
                                'is_active' => 1,
                                'src' => 'assets/img/gallery/' . $uploaded,
                                'theme' => get_active_template()
                            ];
                            
                            if ($this->Gallery_model->create($image_data)) {
                                $uploaded_count++;
                            }
                        }
                    }
                }
                
                if ($uploaded_count > 0) {
                    $this->session->set_flashdata('success', $uploaded_count . ' of ' . $total_files . ' images uploaded successfully.');
                } else {
                    $this->session->set_flashdata('error', 'No images were uploaded. Please check file formats.');
                }
                redirect('admin/gallery');
            } else {
                $this->session->set_flashdata('error', 'Please select images to upload.');
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/gallery/bulk_upload', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Upload single image
     */
    private function upload_image($field_name)
    {
        $config = [
            'upload_path' => $this->upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size' => 5120, // 5MB
            'encrypt_name' => TRUE
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        }

        return false;
    }

    /**
     * Delete image file from server
     */
    private function delete_image_file($src)
    {
        if (empty($src)) return;
        
        // Handle both relative and full paths
        if (strpos($src, 'assets/img/gallery/') === 0) {
            $file_path = './' . $src;
        } else {
            $file_path = $this->upload_path . basename($src);
        }
        
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
}
