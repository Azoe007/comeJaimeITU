<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteSportiveModel extends Model
{
    protected $table = 'activites_sportives';
    protected $primaryKey = 'id';
    protected $allowedFields = ['description', 'diminution_poids', 'frequence', 'duree'];

    protected $validationRules = [
        'description'      => 'required',
        'diminution_poids' => 'required|numeric',
        'frequence'        => 'required|integer',
        'duree'            => 'required|integer',
    ];
}