<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Client extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'clientid' => [
                'type'           => 'INT',
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'clientnama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ]
        ]);
        $this->forge->addKey('clientid', true); // true = primary key
        $this->forge->createTable('client');
    }

    public function down()
    {
        $this->forge->dropTable('client');
    }
}
