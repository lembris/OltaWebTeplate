<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Seeder: Add sample faculty members for testing
 */
class Seed_sample_faculty {

    public function up()
    {
        $CI =& get_instance();
        $CI->load->database();

        // Check if faculty_staff table exists and has data
        $query = $CI->db->get('faculty_staff');
        if ($query->num_rows() > 0) {
            echo "Faculty members already exist. Skipping seed.\n";
            return;
        }

        // Sample departments
        $departments = [
            ['name' => 'Department of Visual Arts', 'slug' => 'visual-arts', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Department of Film & Media', 'slug' => 'film-media', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Department of Business', 'slug' => 'business', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
        ];

        foreach ($departments as $dept) {
            $CI->db->insert('departments', $dept);
        }

        // Get department IDs
        $dept_ids = $CI->db->select('id')->from('departments')->get()->result_array();
        $dept_id_1 = $dept_ids[0]['id'] ?? 1;
        $dept_id_2 = $dept_ids[1]['id'] ?? 2;
        $dept_id_3 = $dept_ids[2]['id'] ?? 3;

        // Sample faculty members
        $faculty = [
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'slug' => 'john-smith',
                'email' => 'john.smith@dmi.ac.tz',
                'phone' => '+255 22 123 4567',
                'title' => 'Senior Lecturer',
                'department_id' => $dept_id_1,
                'specialization' => '2D Animation & Motion Graphics',
                'bio' => 'John is a veteran animator with over 15 years of experience in the animation industry. He has worked with major studios and brings practical knowledge to the classroom.',
                'education' => 'MFA in Animation, University of Arts London\nBFA in Graphic Design, Tanzania',
                'status' => 'active',
                'is_featured' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'slug' => 'sarah-johnson',
                'email' => 'sarah.johnson@dmi.ac.tz',
                'phone' => '+255 22 123 4568',
                'title' => 'Head of Department',
                'department_id' => $dept_id_2,
                'specialization' => 'Digital Media & Film Production',
                'bio' => 'Sarah is an award-winning filmmaker with experience in documentary and commercial production. She leads our film department with passion and expertise.',
                'education' => 'MA in Film Production, New York Film Academy\nBA in Communications, University of Dar es Salaam',
                'status' => 'active',
                'is_featured' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Chen',
                'slug' => 'michael-chen',
                'email' => 'michael.chen@dmi.ac.tz',
                'phone' => '+255 22 123 4569',
                'title' => 'Graphic Design Instructor',
                'department_id' => $dept_id_1,
                'specialization' => 'Graphic Design & Brand Identity',
                'bio' => 'Michael is a creative director with a passion for teaching. He has helped numerous startups build their brand identity.',
                'education' => 'BFA in Graphic Design, Savannah College of Art and Design',
                'status' => 'active',
                'is_featured' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Williams',
                'slug' => 'emily-williams',
                'email' => 'emily.williams@dmi.ac.tz',
                'phone' => '+255 22 123 4570',
                'title' => 'Photography Instructor',
                'department_id' => $dept_id_2,
                'specialization' => 'Professional Photography & Photo Editing',
                'bio' => 'Emily is a professional photographer specializing in portrait and commercial photography. Her work has been featured in national publications.',
                'education' => 'Diploma in Professional Photography, New York Institute of Photography',
                'status' => 'active',
                'is_featured' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($faculty as $member) {
            $CI->db->insert('faculty_staff', $member);
        }

        echo "Sample faculty members added successfully!\n";
        echo "Added " . count($faculty) . " faculty members across " . count($departments) . " departments.\n";
    }

    public function down()
    {
        $CI =& get_instance();
        $CI->load->database();

        // Delete all faculty members
        $CI->db->truncate('faculty_staff');

        // Delete departments (created by this seeder)
        $CI->db->where('slug IN', 'visual-arts,film-media,business', FALSE);
        $CI->db->delete('departments');

        echo "Sample faculty data removed.\n";
    }
}
