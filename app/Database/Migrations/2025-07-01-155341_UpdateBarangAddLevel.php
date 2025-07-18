<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateBarangAddLevel extends Migration
{
    public function up()
    {
        // Tambahkan kolom brglevel
        $this->forge->addColumn('barang', [
            'brglevel' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'brgstok'
            ]
        ]);

        // Tambahkan foreign key ke tabel level
        $this->db->query('ALTER TABLE barang ADD CONSTRAINT fk_barang_level FOREIGN KEY (brglevel) REFERENCES level(idlevel)');
    }

    public function down()
    {
        // Hapus foreign key dulu
        $this->db->query('ALTER TABLE barang DROP FOREIGN KEY fk_barang_level');

        // Hapus kolom
        $this->forge->dropColumn('barang', 'brglevel');
    }
}
