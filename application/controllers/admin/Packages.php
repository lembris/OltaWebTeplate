<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends Admin_Controller 
{
    private $upload_path = './assets/img/packages/';
    private $gallery_path = './assets/img/packages/gallery/';
    private $categories = [
        'wildlife' => 'Wildlife Safari',
        'beach' => 'Beach & Safari',
        'mountain' => 'Mountain Trekking',
        'cultural' => 'Cultural Experience',
        'honeymoon' => 'Honeymoon',
        'luxury' => 'Luxury Safari',
        'budget' => 'Budget Safari'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Package_model');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['form', 'url', 'text']);
        
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
        if (!is_dir($this->gallery_path)) {
            mkdir($this->gallery_path, 0755, true);
        }
    }

    public function index()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Manage Packages';
        $data['packages'] = $this->Package_model->get_all_packages_admin();
        $data['categories'] = $this->categories;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/packages/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        $data = $this->get_admin_data();
        $data['page_title'] = 'Create Package';
        $data['categories'] = $this->categories;
        $data['package'] = null;
        $data['pricing'] = null;
        $data['form_action'] = base_url('admin/packages/create');

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Package Name', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('duration_days', 'Duration', 'required|integer|greater_than[0]');

            if ($this->form_validation->run() === TRUE) {
                $slug = $this->input->post('slug', TRUE);
                if (empty($slug)) {
                    $slug = $this->Package_model->generate_slug($this->input->post('name', TRUE));
                }

                $package_data = [
                    'name' => $this->input->post('name', TRUE),
                    'slug' => $slug,
                    'category' => $this->input->post('category', TRUE),
                    'duration_days' => $this->input->post('duration_days'),
                    'description' => $this->input->post('description'),
                    'short_description' => $this->input->post('short_description', TRUE),
                    'destinations' => $this->format_destinations($this->input->post('destinations', TRUE)),
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                    'meta_title' => $this->input->post('meta_title', TRUE),
                    'meta_description' => $this->input->post('meta_description', TRUE)
                ];

                if (!empty($_FILES['image']['name'])) {
                    $image = $this->upload_image('image');
                    if ($image) {
                        $package_data['image'] = $image;
                    }
                }

                // Handle gallery uploads
                $gallery_images = $this->upload_gallery_images();
                if (!empty($gallery_images)) {
                    $package_data['gallery'] = json_encode($gallery_images);
                }

                $package_id = $this->Package_model->create_package($package_data);

                if ($package_id) {
                    $pricing_data = [
                        'base_price' => $this->input->post('base_price'),
                        'price_per_person' => $this->input->post('price_per_person'),
                        'single_supplement' => $this->input->post('single_supplement')
                    ];
                    $this->Package_model->save_pricing($package_id, $pricing_data);

                    $this->session->set_flashdata('success', 'Package created successfully.');
                    redirect('admin/packages');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create package.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/packages/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function edit($uid)
    {
        // Support both UID and ID for backward compatibility
        $package = $this->Package_model->get_package_admin_by_uid($uid);
        if (!$package) {
            // Try numeric ID as fallback
            if (is_numeric($uid)) {
                $package = $this->Package_model->get_package_admin($uid);
            }
        }
        
        if (!$package) {
            $this->session->set_flashdata('error', 'Package not found.');
            redirect('admin/packages');
        }

        $data = $this->get_admin_data();
        $data['page_title'] = 'Edit Package';
        $data['categories'] = $this->categories;
        $data['package'] = $package;
        $data['pricing'] = $this->Package_model->get_pricing_by_season($package->id, 'mid');
        $data['form_action'] = base_url('admin/packages/edit/' . $package->uid);

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Package Name', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('duration_days', 'Duration', 'required|integer|greater_than[0]');

            if ($this->form_validation->run() === TRUE) {
                $slug = $this->input->post('slug', TRUE);
                if (empty($slug)) {
                    $slug = $this->Package_model->generate_slug($this->input->post('name', TRUE), $package->id);
                }

                $package_data = [
                    'name' => $this->input->post('name', TRUE),
                    'slug' => $slug,
                    'category' => $this->input->post('category', TRUE),
                    'duration_days' => $this->input->post('duration_days'),
                    'description' => $this->input->post('description'),
                    'short_description' => $this->input->post('short_description', TRUE),
                    'destinations' => $this->format_destinations($this->input->post('destinations', TRUE)),
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                    'meta_title' => $this->input->post('meta_title', TRUE),
                    'meta_description' => $this->input->post('meta_description', TRUE)
                ];

                if (!empty($_FILES['image']['name'])) {
                    $image = $this->upload_image('image');
                    if ($image) {
                        if (!empty($package->image) && file_exists($this->upload_path . $package->image)) {
                            unlink($this->upload_path . $package->image);
                        }
                        $package_data['image'] = $image;
                    }
                }

                // Handle gallery uploads and deletions
                $existing_gallery = !empty($package->gallery) ? json_decode($package->gallery, true) : [];
                $delete_images = $this->input->post('delete_gallery');
                
                // Remove deleted images
                if (!empty($delete_images) && is_array($delete_images)) {
                    foreach ($delete_images as $img) {
                        $key = array_search($img, $existing_gallery);
                        if ($key !== false) {
                            unset($existing_gallery[$key]);
                            $img_path = $this->gallery_path . $img;
                            if (file_exists($img_path)) {
                                unlink($img_path);
                            }
                        }
                    }
                    $existing_gallery = array_values($existing_gallery);
                }
                
                // Add new gallery images
                $new_gallery_images = $this->upload_gallery_images();
                if (!empty($new_gallery_images)) {
                    $existing_gallery = array_merge($existing_gallery, $new_gallery_images);
                }
                
                $package_data['gallery'] = json_encode($existing_gallery);

                if ($this->Package_model->update_package($package->id, $package_data)) {
                    $pricing_data = [
                        'base_price' => $this->input->post('base_price'),
                        'price_per_person' => $this->input->post('price_per_person'),
                        'single_supplement' => $this->input->post('single_supplement')
                    ];
                    $this->Package_model->save_pricing($package->id, $pricing_data);

                    $this->session->set_flashdata('success', 'Package updated successfully.');
                    redirect('admin/packages');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update package.');
                }
            }
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/packages/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($uid)
    {
        // Support both UID and ID for backward compatibility
        $package = $this->Package_model->get_package_admin_by_uid($uid);
        if (!$package) {
            // Try numeric ID as fallback
            if (is_numeric($uid)) {
                $package = $this->Package_model->get_package_admin($uid);
            }
        }
        
        if (!$package) {
            $this->session->set_flashdata('error', 'Package not found.');
            redirect('admin/packages');
        }

        if ($this->Package_model->delete_package($package->id)) {
            $this->session->set_flashdata('success', 'Package deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete package.');
        }

        redirect('admin/packages');
    }

    public function toggle_featured($uid)
    {
        // Support both UID and ID for backward compatibility
        $package = $this->Package_model->get_package_admin_by_uid($uid);
        if (!$package) {
            if (is_numeric($uid)) {
                $package = $this->Package_model->get_package_admin($uid);
            }
        }
        
        if (!$package) {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Package not found']);
                exit;
            }
            $this->session->set_flashdata('error', 'Package not found.');
            redirect('admin/packages');
        }
        
        $result = $this->Package_model->toggle_featured($package->id);

        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }

        if ($result['success']) {
            $this->session->set_flashdata('success', $result['message']);
        } else {
            $this->session->set_flashdata('error', $result['message']);
        }
        redirect('admin/packages');
    }

    public function toggle_active($uid)
    {
        // Support both UID and ID for backward compatibility
        $package = $this->Package_model->get_package_admin_by_uid($uid);
        if (!$package) {
            if (is_numeric($uid)) {
                $package = $this->Package_model->get_package_admin($uid);
            }
        }
        
        if (!$package) {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Package not found']);
                exit;
            }
            $this->session->set_flashdata('error', 'Package not found.');
            redirect('admin/packages');
        }
        
        $result = $this->Package_model->toggle_active($package->id);

        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }

        if ($result['success']) {
            $this->session->set_flashdata('success', $result['message']);
        } else {
            $this->session->set_flashdata('error', $result['message']);
        }
        redirect('admin/packages');
    }

    private function upload_image($field_name)
    {
        $config = [
            'upload_path' => $this->upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size' => 2048,
            'encrypt_name' => TRUE
        ];

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        }

        $this->session->set_flashdata('warning', 'Image upload failed: ' . $this->upload->display_errors('', ''));
        return false;
    }

    private function format_destinations($destinations)
    {
        if (empty($destinations)) {
            return '[]';
        }

        if (is_array($destinations)) {
            return json_encode($destinations);
        }

        $dest_array = array_map('trim', explode(',', $destinations));
        $dest_array = array_filter($dest_array);
        return json_encode(array_values($dest_array));
    }

    private function upload_gallery_images()
    {
        $uploaded = [];
        
        if (!isset($_FILES['gallery']) || empty($_FILES['gallery']['name'][0])) {
            return $uploaded;
        }

        $config = [
            'upload_path' => $this->gallery_path,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size' => 2048,
            'encrypt_name' => TRUE
        ];

        $files = $_FILES['gallery'];
        $file_count = count($files['name']);

        for ($i = 0; $i < $file_count; $i++) {
            if (empty($files['name'][$i])) continue;

            $_FILES['gallery_file'] = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i]
            ];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('gallery_file')) {
                $upload_data = $this->upload->data();
                $uploaded[] = $upload_data['file_name'];
            }
        }

        return $uploaded;
    }
}
