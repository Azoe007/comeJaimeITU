<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'prenom', 'email', 'password', 'date_naissance', 'photo_profil', 'role_id'];
    protected $useTimestamps = true;
    protected $returnType = 'array';

    protected $validationRules = [
        'nom' => 'required|max_length[100]',
        'prenom' => 'required|max_length[100]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'date_naissance' => 'required|valid_date',
        'photo_profil' => 'max_length[255]',
        'role_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'nom' => [
            'required' => 'Le nom est requis.',
            'max_length' => 'Le nom ne doit pas dépasser 100 caractères.',
        ],
        'prenom' => [
            'required' => 'Le prénom est requis.',
            'max_length' => 'Le prénom ne doit pas dépasser 100 caractères.',
        ],
        'email' => [
            'required' => 'L\'email est requis.',
            'valid_email' => 'L\'email n\'est pas valide.',
            'is_unique' => 'Cet email est déjà utilisé.',
        ],
        'password' => [
            'required' => 'Le mot de passe est requis.',
            'min_length' => 'Le mot de passe doit faire au moins 6 caractères.',
        ],
        'date_naissance' => [
            'required' => 'La date de naissance est requise.',
            'valid_date' => 'La date de naissance n\'est pas valide.',
        ],
        'photo_profil' => [
            'max_length' => 'La photo de profil ne doit pas dépasser 255 caractères.',
        ],
        'role_id' => [
            'required' => 'Le rôle est requis.',
            'integer' => 'Le rôle doit être un nombre entier.',
        ],
    ];

    public function getUserWithRole($id)
    {
        return $this->select('users.*, role.nom_role')
                    ->join('role', 'users.role_id = role.id')
                    ->where('users.id', $id)
                    ->first();
    }

    
}