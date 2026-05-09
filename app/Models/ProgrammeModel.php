<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgrammeModel extends Model
{
    protected $table = 'programmes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_user', 'id_regime', 'id_activite1', 'id_activite2', 
        'prix_total', 'date_debut', 'date_fin', 'duree_jours', 'created_at'
    ];

    protected $validationRules = [
        'id_user'      => 'required|integer',
        'id_regime'    => 'required|integer',
        'prix_total'   => 'required|numeric',
        'date_debut'   => 'required|valid_date',
        'date_fin'     => 'required|valid_date',
        'duree_jours'  => 'required|integer',
    ];
}