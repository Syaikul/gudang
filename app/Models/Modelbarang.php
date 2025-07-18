<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelbarang extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'brgkode';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'brgkode',
        'brgnama',
        'brgkatid',
        'brgsatid',
        'brgharga',
        'brggambar',
        'brgstok',
        'brgdeskripsi'
    ];


    public function tampildata()
    {
        return $this->table('barang')->join('kategori', 'brgkatid=katid',)->join('satuan', 'brgsatid=satid');
    }

    public function tampildata_cari($cari)
    {
        return $this->table('barang')
            ->join('kategori', 'brgkatid=katid')
            ->join('satuan', 'brgsatid=satid')
            ->groupStart()
            ->orLike('brgkode', $cari)
            ->orLike('brgnama', $cari)
            ->orLike('katnama', $cari)
            ->orLike('satnama', $cari)
            ->groupEnd();
    }
}
