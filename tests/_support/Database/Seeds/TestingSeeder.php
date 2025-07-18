<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'brgkode'  => 'B001',
                'brgnama'  => 'Kursi',
                'brglevel' => 1,
            ],
            [
                'brgkode'  => 'B002',
                'brgnama'  => 'Meja',
                'brglevel' => 2,
            ],
        ];

        $this->db->table('barang')->insertBatch($data);
    }
}
