<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Keluar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'klrkode' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'klrbrgkode' => [
                'type' => 'CHAR',
                'constraint' => '10',
            ],
            'klrtanggal' => [
                'type' => 'DATE',
            ],
            'klrjumlah' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'clientid' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'klrketerangan' => [
                'type' => 'TEXT',
                'null' => true,
            ]
        ]);

        $this->forge->addPrimaryKey('klrkode');
        $this->forge->addForeignKey('klrbrgkode', 'barang', 'brgkode');
        $this->forge->addForeignKey('clientid', 'client', 'clientid');

        $this->forge->createTable('keluar');
    }

    public function down()
    {
        $this->forge->dropTable('keluar');
    }
}
