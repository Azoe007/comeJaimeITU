<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifModel extends Model
{
    protected $table = 'objectifs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom'];

    protected $validationRules = [
        'nom' => 'required|min_length[3]|max_length[100]',
    ];
}