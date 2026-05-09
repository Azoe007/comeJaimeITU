<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regimes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['description', 'viande', 'poisson', 'volaille', 'variation', 'duree', 'type'];

    protected $validationRules = [
        'description' => 'required',
        'viande'      => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'poisson'     => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'volaille'    => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'variation'   => 'required|numeric',
        'duree'       => 'required|integer',
        'type'        => 'required|in_list[augmentation,diminution]',
    ];
}