<?php

namespace App\Models;

use CodeIgniter\Model;

class UserHealthModel extends Model
{
    protected $table = 'user_health';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id', 'poids', 'taille'];

    protected $validationRules = [
        'user_id' => 'required|integer',
        'poids' => 'required|numeric',
        'taille' => 'required|numeric',
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'L\'utilisateur est requis.',
            'integer' => 'L\'identifiant utilisateur doit être un entier.',
        ],
        'poids' => [
            'required' => 'Le poids est requis.',
            'numeric' => 'Le poids doit être un nombre.',
        ],
        'taille' => [
            'required' => 'La taille est requise.',
            'numeric' => 'La taille doit être un nombre.',
        ],
    ];
}