<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Level extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idlevel' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'levelnama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'level' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addKey('idlevel', true);
        $this->forge->createTable('level');
    }

    public function down()
    {
        $this->forge->dropTable('level');
    }
}
