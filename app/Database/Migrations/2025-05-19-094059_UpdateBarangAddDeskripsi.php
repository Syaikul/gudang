<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateBarangAddDeskripsi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('barang', [
            'brgdeskripsi' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'brgsatid'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('barang', 'brgdeskripsi');
    }
}
