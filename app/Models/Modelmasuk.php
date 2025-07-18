<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelmasuk extends Model
{
    protected $table            = 'masuk';
    protected $primaryKey       = 'mskkode';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mskbrgkode', 'msktanggal', 'mskjumlah', 'mskketerangan'];
}
