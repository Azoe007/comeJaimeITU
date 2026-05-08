<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletModel extends Model
{
    protected $table            = 'wallets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user', 'solde'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = ['id_user' => 'required|integer', 'solde' => 'required|integer'];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function ajouter_solde($id_user, $montant) {
        $wallet = $this->where('id_user', $id_user)->first();
        if ($wallet) {
                $nouveau_solde = $wallet['solde'] + $montant;
                $this->update($wallet['id'], ['solde' => $nouveau_solde]);
            } else {
                return $this->insert(['id_user' => $id_user, 'solde' => $montant]);
            }
    }
    public function retirer_solde($id_user, $montant) {
        $wallet = $this->where('id_user', $id_user)->first();
        if ($wallet && $wallet['solde'] >= $montant) {
                $nouveau_solde = $wallet['solde'] - $montant;
                return $this->update($wallet['id'], ['solde' => $nouveau_solde]);
            } else {
                return false; // Solde insuffisant ou wallet non trouvé
            }
    }
    public function get_solde($id_user) {
        $wallet = $this->where('id_user', $id_user)->first();
        return $wallet ? $wallet['solde'] : null; // Retourne le solde ou null si wallet non trouvé
    }
}