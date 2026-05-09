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
        $montant = (int) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->back()->withInput()->with('error', 'Le montant doit être supérieur à zéro.');
        }

        $balance = (int) session()->get('demo_wallet_balance');
        $balance += $montant;
        session()->set('demo_wallet_balance', $balance);

        return redirect()->back()->with('success', 'Solde ajouté avec succès.');
    }

    public function retirer_solde()
    {
        $montant = (int) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->back()->withInput()->with('error', 'Le montant doit être supérieur à zéro.');
        }

        $balance = (int) session()->get('demo_wallet_balance');
        $result = $balance >= $montant;

        if ($result) {
            $balance -= $montant;
            session()->set('demo_wallet_balance', $balance);
            return redirect()->back()->with('success', 'Solde retiré avec succès.');
        } else {
            return redirect()->back()->with('error', 'Solde insuffisant pour effectuer cette opération.');
        }
    }
    // Dans WalletController.php

public function index()
{
    $balance = session()->get('demo_wallet_balance');
    if ($balance === null) {
        $balance = 15000;
        session()->set('demo_wallet_balance', $balance);
    }

    $transactions = session()->get('demo_wallet_transactions');
    if (!is_array($transactions)) {
        $transactions = [
            ['label' => 'Recharge par code HLT-2026-90', 'amount' => '+10 000 Ar', 'status' => 'Valide'],
            ['label' => 'Achat regime prise de masse 30 jours', 'amount' => '-22 000 Ar', 'status' => 'Debite'],
        ];
        session()->set('demo_wallet_transactions', $transactions);
    }

    $data = [
        'pageTitle'   => 'Portefeuille - Health Coach',
        'pageHeading' => 'Portefeuille',
        'breadcrumb'  => 'Portefeuille',
        // Si le wallet n'existe pas encore, on met 0 par défaut
        'solde'       => $balance,
        'transactions' => $transactions,
    ];
    return view('wallet/index', $data);
}

    public function acheterGold()
    {
        if ((bool) session()->get('is_gold')) {
            return redirect()->to('/wallet')->with('success', 'Votre compte est deja Gold.');
        }

        $price = 30000;
        $balance = (int) session()->get('demo_wallet_balance');
        if ($balance < $price) {
            return redirect()->to('/wallet')->with('error', 'Solde insuffisant pour devenir Gold.');
        }

        $balance -= $price;
        session()->set('demo_wallet_balance', $balance);
        session()->set('is_gold', true);

        $transactions = session()->get('demo_wallet_transactions');
        if (!is_array($transactions)) {
            $transactions = [];
        }
        $transactions[] = [
            'label' => 'Activation Gold',
            'amount' => '-' . number_format((float) $price, 0, ',', ' ') . ' Ar',
            'status' => 'Valide',
        ];
        session()->set('demo_wallet_transactions', $transactions);

        return redirect()->to('/wallet')->with('success', 'Felicitation, votre compte est Gold.');
    }

public function recharger()
{
    $codeSaisi = strtoupper(trim((string) $this->request->getPost('code_recharge')));
    $demoCodes = [
        'HLT-2026-90' => 10000,
        'HC-1000-A' => 10000,
        'HC-2500-B' => 25000,
        'HC-5000-C' => 50000,
    ];

    if (!array_key_exists($codeSaisi, $demoCodes)) {
        return redirect()->back()->with('error', 'Code invalide ou déjà utilisé.');
    }

    $usedCodes = session()->get('demo_used_codes');
    if (!is_array($usedCodes)) {
        $usedCodes = [];
    }

    if (in_array($codeSaisi, $usedCodes, true)) {
        return redirect()->back()->with('error', 'Code invalide ou déjà utilisé.');
    }

    $amount = $demoCodes[$codeSaisi];
    $balance = (int) session()->get('demo_wallet_balance');
    $balance += $amount;
    session()->set('demo_wallet_balance', $balance);

    $transactions = session()->get('demo_wallet_transactions');
    if (!is_array($transactions)) {
        $transactions = [];
    }
    $transactions[] = [
        'label' => 'Recharge par code ' . $codeSaisi,
        'amount' => '+' . number_format((float) $amount, 0, ',', ' ') . ' Ar',
        'status' => 'Valide',
    ];
    session()->set('demo_wallet_transactions', $transactions);

    $usedCodes[] = $codeSaisi;
    session()->set('demo_used_codes', $usedCodes);

    return redirect()->to('/wallet')->with('success', 'Votre compte a été crédité de ' . $amount . ' Ar');
}
}