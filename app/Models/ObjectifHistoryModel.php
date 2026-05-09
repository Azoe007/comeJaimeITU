<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifHistoryModel extends Model
{
    protected $table = 'objectif_history';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_user', 'id_objectif', 'poids_kg', 'taille_cm', 'created_at'];
    protected $useTimestamps = false; 

    protected $validationRules = [
        'id_user'     => 'required|integer',
        'id_objectif' => 'required|integer',
        'poids_kg'    => 'required|numeric',
        'taille_cm'   => 'required|numeric',
    ];
}