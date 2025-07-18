<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelsatuan extends Model
{
   protected $table            = 'satuan';
    protected $primaryKey       = 'satid';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['satid','satnama'];
}
