<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelclient extends Model
{
    protected $table            = 'client';
    protected $primaryKey       = 'clientid';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['clientid', 'clientnama'];
}
