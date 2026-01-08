<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_sms_providers_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE,
                'unsigned' => TRUE,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
            ],
            'api_endpoint' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
                'comment' => 'URL endpoint for sending SMS'
            ],
            'api_key' => [
                'type' => 'TEXT',
                'null' => FALSE,
                'comment' => 'Encrypted API key or authentication token'
            ],
            'sender_id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'api_headers' => [
                'type' => 'JSON',
                'null' => TRUE,
                'comment' => 'Additional API headers in JSON format'
            ],
            'request_params' => [
                'type' => 'JSON',
                'null' => TRUE,
                'comment' => 'Request payload mapping in JSON format'
            ],
            'http_method' => [
                'type' => 'ENUM',
                'constraint' => ['GET', 'POST', 'PUT'],
                'default' => 'POST',
            ],
            'request_format' => [
                'type' => 'ENUM',
                'constraint' => ['json', 'form'],
                'default' => 'json',
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP'
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('sms_providers');
    }

    public function down()
    {
        $this->dbforge->drop_table('sms_providers');
    }
}
