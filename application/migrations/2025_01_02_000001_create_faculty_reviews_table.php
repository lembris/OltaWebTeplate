<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_faculty_reviews_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'auto_increment' => TRUE,
            ],
            'faculty_id' => [
                'type' => 'INT',
                'null' => FALSE,
            ],
            'student_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
            ],
            'rating' => [
                'type' => 'INT',
                'null' => FALSE,
            ],
            'review_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
            ],
            'review_text' => [
                'type' => 'LONGTEXT',
                'null' => FALSE,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default' => 'pending',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => TRUE,
            ],
            'user_id' => [
                'type' => 'INT',
                'null' => TRUE,
            ],
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('faculty_id');
        $this->dbforge->add_key('status');
        $this->dbforge->add_key('created_at');
        $this->dbforge->add_key('rating');
        
        $this->dbforge->create_table('faculty_reviews');

        // Add foreign key
        $this->db->query('ALTER TABLE faculty_reviews ADD CONSTRAINT fk_faculty_id 
            FOREIGN KEY (faculty_id) REFERENCES faculty_staff(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE faculty_reviews DROP FOREIGN KEY fk_faculty_id');
        $this->dbforge->drop_table('faculty_reviews');
    }
}
