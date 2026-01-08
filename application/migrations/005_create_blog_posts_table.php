<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_blog_posts_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE,
                'unique' => TRUE
            ),
            'category' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => 'travel-tips'
            ),
            'excerpt' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'content' => array(
                'type' => 'LONGTEXT',
                'null' => FALSE
            ),
            'featured_image' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'author' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => 'Osiram Safari'
            ),
            'published' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'comment' => '1 = published, 0 = draft'
            ),
            'views' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'default' => 0
            ),
            'seo_title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
                'comment' => 'For meta title tag'
            ),
            'seo_description' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
                'comment' => 'For meta description tag'
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => FALSE,
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => FALSE,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'on_update' => new RawSql('CURRENT_TIMESTAMP')
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('slug');
        $this->dbforge->add_key('category');
        $this->dbforge->add_key('published');
        $this->dbforge->create_table('blog_posts');
    }

    public function down()
    {
        $this->dbforge->drop_table('blog_posts');
    }
}
