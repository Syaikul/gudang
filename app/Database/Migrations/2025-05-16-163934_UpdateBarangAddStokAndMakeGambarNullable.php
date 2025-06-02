<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateBarang_AddStokAndMakeGambarNullable extends Migration
{
    public function up()
    {
        // Tambah kolom 'brgstok'
        $this->forge->addColumn('barang', [
            'brgstok' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
                'after'      => 'brggambar'
            ]
        ]);

        // Ubah kolom 'brggambar' agar bisa NULL
        $fields = [
            'brggambar' => [
                'name'       => 'brggambar',
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
        ];
        $this->forge->modifyColumn('barang', $fields);
    }

    public function down()
    {
        // Hapus kolom 'brgstok'
        $this->forge->dropColumn('barang', 'brgstok');

        // Ubah kolom 'brggambar' kembali jadi NOT NULL
        $fields = [
            'brggambar' => [
                'name'       => 'brggambar',
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => false,
            ],
        ];
        $this->forge->modifyColumn('barang', $fields);
    }
}
