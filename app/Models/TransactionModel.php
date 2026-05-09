<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_user', 'id_programme', 'montant', 'reduction', 'etat', 'created_at'];

    protected $validationRules = [
        'id_user'      => 'required|integer',
        'id_programme' => 'permit_empty|integer',
        'montant'      => 'required|numeric',
        'reduction'    => 'numeric',
        'etat'         => 'required|in_list[en cours,valide,annule,echec]',
    ];

    protected $validationMessages = [
        'etat' => [
            'in_list' => 'L\'état de la transaction doit être : en cours, valide, annule ou echec.'
        ]
    ];
}