<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelkategori extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'katid';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['katid','katnama'];

}
