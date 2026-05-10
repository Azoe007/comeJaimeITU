<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigRegimeModel extends Model
{
    protected $table = 'config_regime';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['id_regime', 'duree_jours', 'prix'];
}
