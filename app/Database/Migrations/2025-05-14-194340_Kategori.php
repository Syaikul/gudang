<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'katid' => [
                'type'           => 'INT',
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'katnama' => [
                'type'       => 'VARCHAR',
                'constraint' => '50'
            ]
        ]);
        $this->forge->addKey('katid', true); // true = primary key
        $this->forge->createTable('kategori');
    }


    public function down()
    {
        $this->forge->dropTable('kategori');
    }
}
