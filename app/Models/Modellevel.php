<?php

namespace App\Models;

use CodeIgniter\Model;

class Modellevel extends Model
{
    protected $table            = 'level';
    protected $primaryKey       = 'idlevel';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['levelnama', 'level'];
}
