<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ObjectifHistoryModel;
use App\Models\TransactionModel;
use App\Models\ProgrammeModel;
use App\Models\RegimeModel;
use App\Models\WalletModel;
use App\Models\HealthHistoryModel;

class Admin extends BaseController
{
    protected UserModel $userModel;
    protected ObjectifHistoryModel $objectifHistoryModel;
    protected TransactionModel $transactionModel;
    protected ProgrammeModel $programmeModel;
    protected RegimeModel $regimeModel;
    protected WalletModel $walletModel;
    protected HealthHistoryModel $healthHistoryModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->objectifHistoryModel = new ObjectifHistoryModel();
        $this->transactionModel = new TransactionModel();
        $this->programmeModel = new ProgrammeModel();
        $this->regimeModel = new RegimeModel();
        $this->walletModel = new WalletModel();
        $this->healthHistoryModel = new HealthHistoryModel();
    }

    /**
     * Page de connexion admin
     */
    public function loginPage(): string
    {
        if (session('isLoggedIn') && session('role_id') == 1) {
            return redirect()->to(base_url('admin'));
        }

        return view('admin/login_page', [
            'pageTitle' => 'Connexion Admin - Health Coach',
        ]);
    }

    /**
     * Traiter la connexion admin
     */
    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');
        $user = $this->userModel->getUserByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email ou mot de passe incorrect.');
        }

        // Vérifier que l'utilisateur est admin
        if ($user['role_id'] != 1) {
            return redirect()->back()->with('error', 'Accès refusé. Vous n\'êtes pas administrateur.');
        }

        session()->set([
            'user_id' => $user['id'],
            'user_nom' => $user['nom'],
            'user_prenom' => $user['prenom'],
            'user_email' => $user['email'],
            'role_id' => $user['role_id'],
            'is_gold' => (bool) ($user['est_gold'] ?? false),
            'isLoggedIn' => true,
            'is_admin' => true,
        ]);

        return redirect()->to(base_url('admin'))->with('success', 'Connexion admin réussie.');
    }

    /**
     * Déconnexion admin
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('admin/login'))->with('success', 'Déconnexion réussie.');
    }

    /**
     * Tableau de bord principal
     */
    public function dashboard(): string
    {
        $usersBuilder = clone $this->userModel->builder();
        $totalUsersGold = $usersBuilder
            ->where('est_gold', 1)
            ->countAllResults();

        $stats = [
            'total_users' => $this->userModel->countAll() ?? 0,
            'total_users_gold' => $totalUsersGold ?? 0,
            'total_transactions' => $this->transactionModel->countAll() ?? 0,
            'total_programmes' => $this->programmeModel->countAll() ?? 0,
            'revenue_total' => ($this->transactionModel
                ->where('etat', 'valide')
                ->selectSum('montant')
                ->first()['montant'] ?? 0),
        ];

        $graphData = [
            'users_by_month' => $this->getUsersRegistrationByMonth() ?? [],
            'revenue_by_month' => $this->getRevenueByMonth() ?? [],
            'programmes_by_regime' => $this->getProgrammesByRegime() ?? [],
            'objectifs_distribution' => $this->getObjectifsDistribution() ?? [],
            'transactions_by_status' => $this->getTransactionsByStatus() ?? [],
            'users_by_genre' => $this->getUsersByGenre() ?? [],
        ];

        $recentData = [
            'recent_users' => $this->userModel->orderBy('id', 'DESC')->limit(5)->findAll() ?? [],
            'recent_transactions' => ($this->transactionModel
                ->select('transactions.*, users.nom, users.prenom')
                ->join('users', 'users.id = transactions.id_user')
                ->orderBy('transactions.id', 'DESC')
                ->limit(5)
                ->findAll() ?? []),
        ];

        return view('admin/dashboard', [
            'pageTitle' => 'Dashboard - Health Coach',
            'pageHeading' => 'Tableau de bord',
            'breadcrumb' => 'Administration',
            'activeMenu' => 'dashboard',
            'stats' => $stats,
            'graphData' => $graphData,
            'recentData' => $recentData,
        ]);
    }

    /**
     * Page détails utilisateurs
     */
    public function users(): string
    {
        $users = $this->userModel
            ->select('users.*, role.nom_role as role_name')
            ->join('role', 'role.id = users.role_id', 'left')
            ->findAll() ?? [];

        return view('admin/users', [
            'pageTitle' => 'Gestion Utilisateurs - Health Coach',
            'pageHeading' => 'Gestion des utilisateurs',
            'breadcrumb' => 'Utilisateurs',
            'activeMenu' => 'users',
            'users' => $users,
        ]);
    }

    /**
     * Détails d'un utilisateur
     */
    public function userDetail($userId): string
    {
        $user = $this->userModel->find($userId);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $userStats = [
            'programmes' => $this->programmeModel->where('id_user', $userId)->countAllResults() ?? 0,
            'transactions' => $this->transactionModel->where('id_user', $userId)->countAllResults() ?? 0,
            'health_records' => $this->healthHistoryModel->where('user_id', $userId)->countAllResults() ?? 0,
            'total_spent' => ($this->transactionModel
                ->where('id_user', $userId)
                ->where('etat', 'valide')
                ->selectSum('montant')
                ->first()['montant'] ?? 0),
        ];

        $userProgrammes = $this->programmeModel
            ->select('programmes.*, regimes.description as regime_name')
            ->join('regimes', 'regimes.id = programmes.id_regime', 'left')
            ->where('programmes.id_user', $userId)
            ->findAll() ?? [];

        $userTransactions = $this->transactionModel
            ->where('id_user', $userId)
            ->orderBy('id', 'DESC')
            ->findAll() ?? [];

        $healthHistory = $this->healthHistoryModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll() ?? [];

        return view('admin/user_detail', [
            'pageTitle' => 'Détails Utilisateur - Health Coach',
            'pageHeading' => 'Détails de ' . $user['prenom'] . ' ' . $user['nom'],
            'breadcrumb' => 'Utilisateurs',
            'activeMenu' => 'users',
            'user' => $user,
            'stats' => $userStats,
            'programmes' => $userProgrammes,
            'transactions' => $userTransactions,
            'healthHistory' => $healthHistory,
        ]);
    }

    /**
     * Page finances et transactions
     */
    public function finances(): string
    {
        $transactions = $this->transactionModel
            ->select('transactions.*, users.nom, users.prenom, users.email, regimes.description as regime_name')
            ->join('users', 'users.id = transactions.id_user')
            ->join('programmes', 'programmes.id = transactions.id_programme', 'left')
            ->join('regimes', 'regimes.id = programmes.id_regime', 'left')
            ->orderBy('transactions.id', 'DESC')
            ->findAll() ?? [];

        $wallets = $this->walletModel
            ->select('wallets.*, users.nom, users.prenom, users.email')
            ->join('users', 'users.id = wallets.id_user')
            ->orderBy('wallets.solde', 'DESC')
            ->findAll() ?? [];

        $stats = [
            'revenue_total' => ($this->transactionModel
                ->where('etat', 'valide')
                ->selectSum('montant')
                ->first()['montant'] ?? 0),
            'pending_revenue' => ($this->transactionModel
                ->where('etat', 'en cours')
                ->selectSum('montant')
                ->first()['montant'] ?? 0),
            'failed_transactions' => $this->transactionModel->where('etat', 'echec')->countAllResults() ?? 0,
            'total_wallets_balance' => ($this->walletModel->selectSum('solde')->first()['solde'] ?? 0),
        ];

        return view('admin/finances', [
            'pageTitle' => 'Finances et Transactions - Health Coach',
            'pageHeading' => 'Gestion finances',
            'breadcrumb' => 'Finances',
            'activeMenu' => 'finances',
            'transactions' => $transactions,
            'wallets' => $wallets,
            'stats' => $stats,
        ]);
    }

    /**
     * Page programmes et régimes
     */
    public function programmes(): string
    {
        $programmes = $this->programmeModel
            ->select('programmes.*, users.nom, users.prenom, regimes.description as regime_name')
            ->join('users', 'users.id = programmes.id_user')
            ->join('regimes', 'regimes.id = programmes.id_regime', 'left')
            ->orderBy('programmes.id', 'DESC')
            ->findAll() ?? [];

        $regimes = $this->regimeModel->findAll() ?? [];

        $stats = [
            'total_programmes' => $this->programmeModel->countAll() ?? 0,
            'active_programmes' => ($this->programmeModel
                ->where('date_debut <=', date('Y-m-d'))
                ->where('date_fin >=', date('Y-m-d'))
                ->countAllResults() ?? 0),
            'top_regime' => $this->getTopRegime(),
            'average_programme_price' => ($this->programmeModel->selectAvg('prix_total')->first()['prix_total'] ?? 0),
        ];

        return view('admin/programmes', [
            'pageTitle' => 'Programmes et Régimes - Health Coach',
            'pageHeading' => 'Gestion des programmes',
            'breadcrumb' => 'Programmes',
            'activeMenu' => 'programmes',
            'programmes' => $programmes,
            'regimes' => $regimes,
            'stats' => $stats,
        ]);
    }

    /**
     * Page statistiques santé
     */
    public function health(): string
    {
        $healthData = $this->healthHistoryModel
            ->select('health_history.*, users.nom, users.prenom')
            ->join('users', 'users.id = health_history.user_id')
            ->orderBy('health_history.created_at', 'DESC')
            ->findAll() ?? [];

        $objectifs = $this->objectifHistoryModel
            ->select('objectif_history.*, users.nom, users.prenom, objectifs.nom as objectif_name')
            ->join('users', 'users.id = objectif_history.id_user')
            ->join('objectifs', 'objectifs.id = objectif_history.id_objectif', 'left')
            ->findAll() ?? [];

        $stats = [
            'avg_weight' => ($this->healthHistoryModel->selectAvg('poids')->first()['poids'] ?? 0),
            'avg_height' => ($this->healthHistoryModel->selectAvg('taille')->first()['taille'] ?? 0),
            'max_weight' => ($this->healthHistoryModel->selectMax('poids')->first()['poids'] ?? 0),
            'min_weight' => ($this->healthHistoryModel->selectMin('poids')->first()['poids'] ?? 0),
        ];

        return view('admin/health', [
            'pageTitle' => 'Statistiques Santé - Health Coach',
            'pageHeading' => 'Statistiques santé',
            'breadcrumb' => 'Santé',
            'activeMenu' => 'health',
            'healthData' => $healthData,
            'objectifs' => $objectifs,
            'stats' => $stats,
        ]);
    }

    // ===== Helpers pour les graphes =====

    protected function getUsersRegistrationByMonth()
    {
        try {
            $db = \Config\Database::connect();
            $result = $db->query('SELECT DATE(created_at) as day, COUNT(*) as count FROM users GROUP BY DATE(created_at) ORDER BY day DESC LIMIT 30')->getResultArray();
            return $result;
        } catch (\Exception $e) {
            return [];
        }
    }

    protected function getRevenueByMonth()
    {
        try {
            $db = \Config\Database::connect();
            $result = $db->query('SELECT DATE(created_at) as day, SUM(montant) as revenue FROM transactions WHERE etat="valide" GROUP BY DATE(created_at) ORDER BY day DESC LIMIT 30')->getResultArray();
            return $result;
        } catch (\Exception $e) {
            return [];
        }
    }

    protected function getProgrammesByRegime()
    {
        $result = $this->programmeModel
            ->select('regimes.description as regime_name, COUNT(*) as count')
            ->join('regimes', 'regimes.id = programmes.id_regime')
            ->groupBy('regimes.id, regimes.description')
            ->findAll();

        return $result ?? [];
    }

    protected function getObjectifsDistribution()
    {
        $result = $this->objectifHistoryModel
            ->select('objectifs.nom, COUNT(*) as count')
            ->join('objectifs', 'objectifs.id = objectif_history.id_objectif')
            ->groupBy('objectifs.id, objectifs.nom')
            ->findAll();

        return $result ?? [];
    }

    protected function getTransactionsByStatus()
    {
        $result = $this->transactionModel
            ->select('etat, COUNT(*) as count')
            ->groupBy('etat')
            ->findAll();

        return $result ?? [];
    }

    protected function getUsersByGenre()
    {
        $result = $this->userModel
            ->select('genre, COUNT(*) as count')
            ->groupBy('genre')
            ->findAll();

        return $result ?? [];
    }

    protected function getTopRegime()
    {
        $result = $this->programmeModel
            ->select('regimes.description, COUNT(*) as count')
            ->join('regimes', 'regimes.id = programmes.id_regime')
            ->groupBy('regimes.id, regimes.description')
            ->orderBy('count', 'DESC')
            ->limit(1)
            ->first();

        return $result ?? ['description' => 'N/A'];
    }
}
