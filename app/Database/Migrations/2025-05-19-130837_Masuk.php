<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Masuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'mskkode' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'mskbrgkode' => [
                'type' => 'CHAR',
                'constraint' => '10',
            ],
            'msktanggal' => [
                'type' => 'DATE',
            ],
            'mskjumlah' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'mskketerangan' => [
                'type' => 'TEXT',
                'null' => true,
            ]
        ]);

        $this->forge->addPrimaryKey('mskkode');
        $this->forge->addForeignKey('mskbrgkode', 'barang', 'brgkode');

        $this->forge->createTable('masuk');
    }

    public function down()
    {
        $this->forge->dropTable('masuk');
    }
}
