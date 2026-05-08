<?php
namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['nom_role'];

    protected $validationRules = [
        'nom_role' => 'required|max_length[100]',
    ];

    protected $validationMessages = [
        'nom_role' => [
            'required' => 'Le nom du rôle est requis.',
            'max_length' => 'Le nom du rôle ne doit pas dépasser 100 caractères.',
        ],
    ];
}