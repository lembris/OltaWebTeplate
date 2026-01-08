<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_itineraries_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'package_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE,
                'comment' => 'Link to package'
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE,
                'comment' => 'Itinerary title (e.g. "Serengeti 7-Day Safari")'
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'Overall itinerary description'
            ),
            'duration_days' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'default' => 1,
                'comment' => 'Number of days'
            ),
            'difficulty_level' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'moderate',
                'comment' => 'easy, moderate, challenging'
            ),
            'best_season' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'comment' => 'Best time to visit (e.g. "Jun-Oct")'
            ),
            'altitude' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'comment' => 'Max altitude if relevant'
            ),
            'inclusions' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'What is included (WYSIWYG HTML)'
            ),
            'exclusions' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'What is excluded'
            ),
            'what_to_bring' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'Packing list'
            ),
            'price_per_person' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => TRUE,
                'comment' => 'Starting price per person'
            ),
            'published' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'comment' => '1 = published, 0 = draft'
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
        $this->dbforge->add_key('package_id');
        $this->dbforge->add_key('published');
        $this->dbforge->create_table('itineraries');
    }

    public function down()
    {
        $this->dbforge->drop_table('itineraries');
    }
}
