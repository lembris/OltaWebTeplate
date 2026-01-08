<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_itinerary_days_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'itinerary_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE,
                'comment' => 'Link to itinerary'
            ),
            'day_number' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE,
                'comment' => 'Day 1, 2, 3, etc'
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE,
                'comment' => 'Day title (e.g. "Arrival in Dar es Salaam")'
            ),
            'description' => array(
                'type' => 'LONGTEXT',
                'null' => FALSE,
                'comment' => 'Detailed day description'
            ),
            'activities' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'Activities for the day (bullet points)'
            ),
            'meals' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => 'breakfast,lunch,dinner',
                'comment' => 'Meals included (B, L, D)'
            ),
            'accommodation' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
                'comment' => 'Type of accommodation'
            ),
            'transportation' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
                'comment' => 'Mode of transport for the day'
            ),
            'distance' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'comment' => 'Distance traveled (e.g. "280 km")'
            ),
            'duration' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'comment' => 'Duration (e.g. "4-5 hours")'
            ),
            'image' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
                'comment' => 'Day image/photo'
            ),
            'display_order' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'default' => 0,
                'comment' => 'Order of display'
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
        $this->dbforge->add_key('itinerary_id');
        $this->dbforge->add_key('day_number');
        $this->dbforge->create_table('itinerary_days');
    }

    public function down()
    {
        $this->dbforge->drop_table('itinerary_days');
    }
}
