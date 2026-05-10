<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifHistoryModel extends Model
{
    protected $table = 'objectif_history';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['id_user', 'id_objectif', 'poids_kg', 'taille_cm', 'poids_objectif', 'created_at'];
    protected $useTimestamps = false; 

    protected $validationRules = [
        'id_user'     => 'required|integer',
        'id_objectif' => 'required|integer',
        'poids_kg'    => 'required|numeric',
        'taille_cm'   => 'required|numeric',
        'poids_objectif' => 'permit_empty|numeric',
    ];

    public function latestForUser(int $userId): ?array
    {
        $row = $this->select('objectif_history.*, objectifs.nom as objectif_nom')
            ->join('objectifs', 'objectifs.id = objectif_history.id_objectif')
            ->where('id_user', $userId)
            ->orderBy('objectif_history.created_at', 'DESC')
            ->first();

        return $row ?: null;
    }
}
