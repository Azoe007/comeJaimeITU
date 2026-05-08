<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class WalletController extends BaseController
{
    // public function index()
    // {
    //     return view('wallet/index', [
    //         'pageTitle' => 'Portefeuille - Health Coach',
    //         'pageHeading' => 'Portefeuille',
    //         'breadcrumb' => 'Portefeuille',
    //     ]);
    // }

    public function ajouter_solde()
    {
        $id_user = session()->get('user_id');
        $montant = (int) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->back()->withInput()->with('error', 'Le montant doit être supérieur à zéro.');
        }

        $walletModel = new \App\Models\WalletModel();
        $walletModel->ajouter_solde($id_user, $montant);

        return redirect()->back()->with('success', 'Solde ajouté avec succès.');
    }

    public function retirer_solde()
    {
        $id_user = session()->get('user_id');
        $montant = (int) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->back()->withInput()->with('error', 'Le montant doit être supérieur à zéro.');
        }

        $walletModel = new \App\Models\WalletModel();
        $result = $walletModel->retirer_solde($id_user, $montant);

        if ($result) {
            return redirect()->back()->with('success', 'Solde retiré avec succès.');
        } else {
            return redirect()->back()->with('error', 'Solde insuffisant pour effectuer cette opération.');
        }
    }
    // Dans WalletController.php

public function index()
{
    $id_user = session()->get('user_id');
    $walletModel = new \App\Models\WalletModel();
    $monPortefeuille = $walletModel->where('id_user', $id_user)->first();

    $data = [
        'pageTitle'   => 'Portefeuille - Health Coach',
        'pageHeading' => 'Portefeuille',
        'breadcrumb'  => 'Portefeuille',
        // Si le wallet n'existe pas encore, on met 0 par défaut
        'solde'       => $monPortefeuille ? $monPortefeuille['solde'] : 0, 
    ];
    return view('wallet/index', $data);
}

public function recharger()
{
    $codeSaisi = $this->request->getPost('code_recharge');
    $id_user = session()->get('user_id');

    $codeModel = new \App\Models\CodeModel();
    $walletModel = new \App\Models\WalletModel();

    // 1. Vérifier si le code existe et est disponible
    $codeData = $codeModel->where('code', $codeSaisi)
                          ->where('id_statut_code', 1)
                          ->first();

    if (!$codeData) {
        return redirect()->back()->with('error', 'Code invalide ou déjà utilisé.');
    }

    // 2. Logique de mise à jour
    try {
        $db = \Config\Database::connect();
        $db->transStart();

        // Créditer le portefeuille
        $walletModel->ajouter_solde($id_user, $codeData['valeur_en_ar']);

        // Marquer le code comme utilisé (Statut 2)
        $codeModel->update($codeData['id'], [
            'id_user'        => $id_user,
            'id_statut_code' => 2,
            'date_usage'     => date('Y-m-d H:i:s')
        ]);

        $db->transComplete();
        return redirect()->to('/wallet')->with('success', 'Votre compte a été crédité de ' . $codeData['valeur_en_ar'] . ' Ar');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erreur lors du rechargement.');
    }
}

public function acheter_gold()
{
    $id_user = session()->get('user_id');
    $prixGold = 25000; // nataoko static aloha ilay prix

    $walletModel = new \App\Models\WalletModel();
    $userModel = new \App\Models\UserModel(); 

    $wallet = $walletModel->where('id_user', $id_user)->first();

    if (!$wallet || $wallet['solde'] < $prixGold) {
        return redirect()->back()->with('error', 'Solde insuffisant. Veuillez recharger votre compte.');
    }

    try {
        $db = \Config\Database::connect();
        $db->transStart();

        $walletModel->retirer_solde($id_user, $prixGold);

        $userModel->update($id_user, ['est_gold' => 1]);

        session()->set('is_gold', true);

        $db->transComplete();
        return redirect()->to('/wallet')->with('success', 'Félicitations ! Vous êtes maintenant Membre Gold.');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue.Verifier votre solde.');
    }
}
}