<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\WalletModel;
use App\Models\ParametreModel;

class WalletController extends BaseController
{
    public function index()
    {
        $userId = (int) session('user_id');
        $walletModel = new WalletModel();
        $balance = $userId > 0 ? (int) ($walletModel->get_solde($userId) ?? 0) : (int) (session('demo_wallet_balance') ?? 0);
        $transactions = session('demo_wallet_transactions');
        if (! is_array($transactions)) {
            $transactions = [];
            session()->set('demo_wallet_transactions', $transactions);
        }
        $goldSettings = $this->getGoldSettings();

        return view('wallet/index', [
            'pageTitle' => 'Portefeuille - Health Coach',
            'pageHeading' => 'Portefeuille',
            'breadcrumb' => 'Portefeuille',
            'solde' => $balance,
            'transactions' => array_reverse($transactions),
            'goldPrice' => $goldSettings['prix_gold'],
            'goldReduction' => $goldSettings['reduction_gold'],
        ]);
    }

    public function acheterGold()
    {
        if ((bool) session('is_gold')) {
            return redirect()->to('/wallet')->with('success', 'Votre compte est deja Gold.');
        }

        $userId = (int) session('user_id');
        if ($userId <= 0) {
            session()->set('redirect_after_auth', base_url('wallet'));
            return redirect()->to(base_url('login'))->with('error', 'Veuillez vous connecter pour devenir Gold.');
        }

        $goldSettings = $this->getGoldSettings();
        $price = (float) $goldSettings['prix_gold'];
        $walletModel = new WalletModel();
        $balance = (int) ($walletModel->get_solde($userId) ?? 0);
        if ($balance < $price) {
            return redirect()->to('/wallet')->with('error', 'Solde insuffisant pour devenir Gold.');
        }

        $walletModel->retirer_solde($userId, $price);
        (new UserModel())->update($userId, ['est_gold' => 1]);
        session()->set('is_gold', true);

        $transactions = session('demo_wallet_transactions') ?? [];
        $transactions[] = ['label' => 'Activation Gold', 'amount' => '-' . number_format((float) $price, 0, ',', ' ') . ' Ar', 'status' => 'Valide'];
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

        if (! array_key_exists($codeSaisi, $demoCodes)) {
            return redirect()->back()->with('error', 'Code invalide ou deja utilise.');
        }

        $usedCodes = session('demo_used_codes') ?? [];
        if (in_array($codeSaisi, $usedCodes, true)) {
            return redirect()->back()->with('error', 'Code invalide ou deja utilise.');
        }

        $amount = $demoCodes[$codeSaisi];
        $userId = (int) session('user_id');
        if ($userId > 0) {
            $walletModel = new WalletModel();
            $walletModel->ajouter_solde($userId, $amount);
        } else {
            session()->set('demo_wallet_balance', (int) (session('demo_wallet_balance') ?? 0) + $amount);
        }

        $transactions = session('demo_wallet_transactions') ?? [];
        $transactions[] = ['label' => 'Recharge par code ' . $codeSaisi, 'amount' => '+' . number_format((float) $amount, 0, ',', ' ') . ' Ar', 'status' => 'Valide'];
        session()->set('demo_wallet_transactions', $transactions);
        $usedCodes[] = $codeSaisi;
        session()->set('demo_used_codes', $usedCodes);

        return redirect()->to('/wallet')->with('success', 'Votre compte a ete credite de ' . $amount . ' Ar');
    }

    protected function getGoldSettings(): array
    {
        $defaults = [
            'prix_gold' => 30000,
            'duree_gold' => 30,
            'reduction_gold' => 15,
        ];

        $current = (new ParametreModel())->orderBy('id', 'DESC')->first();

        return array_merge($defaults, $current ?? []);
    }
}
