<?php

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    /**
     * Affiche la page de connexion
     */
    public function index(): string
    {
        return view('auth/login', [
            'pageTitle' => 'Connexion - Health Coach',
            'pageHeading' => 'Connexion',
            'breadcrumb' => 'Connexion',
        ]);
    }

    /**
     * Traite la connexion
     */
    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');
        $user = $this->userModel->getUserByEmail($email);

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email ou mot de passe incorrect.');
        }

        $session = session();
        $session->set([
            'user_id' => $user['id'],
            'user_nom' => $user['nom'],
            'user_prenom' => $user['prenom'],
            'user_email' => $user['email'],
            'role_id' => $user['role_id'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to(base_url('/'))->with('success', 'Connexion réussie.');
    }

    /**
     * Affiche la page d'inscription - Étape 1
     */
    public function register(): string
    {
        return view('auth/register_step1', [
            'pageTitle' => 'Inscription - Health Coach',
            'pageHeading' => 'Créer un compte - Étape 1',
            'breadcrumb' => 'Inscription',
        ]);
    }

    /**
     * Traite l'étape 1 d'inscription
     */
    public function registerStep1()
    {
        $rules = [
            'nom' => 'required|max_length[100]',
            'prenom' => 'required|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            'genre' => 'required|in_list[M,F,Autre]',
            'date_naissance' => 'required|valid_date',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $roleId = $this->getDefaultRoleId();

        $registrationData = [
            'nom' => trim((string) $this->request->getPost('nom')),
            'prenom' => trim((string) $this->request->getPost('prenom')),
            'email' => trim((string) $this->request->getPost('email')),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'date_naissance' => (string) $this->request->getPost('date_naissance'),
            'genre' => (string) $this->request->getPost('genre'),
            'role_id' => $roleId,
        ];

        session()->set('register_step1', $registrationData);

        return redirect()->to(base_url('register/step2'));
    }

    /**
     * Affiche la page d'inscription - Étape 2
     */
    public function registerStep2(): string
    {
        return view('auth/register_step2', [
            'pageTitle' => 'Inscription - Étape 2 - Health Coach',
            'pageHeading' => 'Compléter le profil - Étape 2',
            'breadcrumb' => 'Inscription',
        ]);
    }

    /**
     * Traite l'étape 2 d'inscription
     */
    public function processRegisterStep2()
    {
        $step1Data = session()->get('register_step1');

        if (! is_array($step1Data) || empty($step1Data)) {
            return redirect()->to(base_url('register'))->with('error', 'Veuillez d’abord compléter l’étape 1.');
        }

        $rules = [
            'taille' => 'required|numeric',
            'poids' => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $healthData = [
            'taille' => (float) $this->request->getPost('taille'),
            'poids' => (float) $this->request->getPost('poids'),
        ];

        $userId = $this->userModel->createUserWithHealth($step1Data, $healthData);

        if ($userId === null) {
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de l’inscription.');
        }

        session()->remove('register_step1');

        session()->set([
            'user_id' => $userId,
            'user_nom' => $step1Data['nom'],
            'user_prenom' => $step1Data['prenom'],
            'user_email' => $step1Data['email'],
            'role_id' => $step1Data['role_id'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to(base_url('/'))->with('success', 'Compte créé avec succès.');
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('/login'))->with('success', 'Vous êtes déconnecté.');
    }

    /**
     * Vérifie la disponibilité d'un email en AJAX
     */
    public function checkEmail()
    {
        $email = trim((string) $this->request->getGet('email'));

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'available' => false,
                'message' => 'Adresse email invalide.',
            ]);
        }

        $exists = $this->userModel->getUserByEmail($email) !== null;

        return $this->response->setJSON([
            'available' => ! $exists,
            'message' => $exists ? 'Cet email est déjà utilisé.' : 'Email disponible.',
        ]);
    }

    /**
     * Retourne l'identifiant du rôle utilisateur par défaut.
     */
    protected function getDefaultRoleId(): int
    {
        $role = $this->roleModel->where('nom_role', 'utilisateur')->first();

        if (! $role) {
            $this->roleModel->insert(['nom_role' => 'utilisateur']);

            return (int) $this->roleModel->getInsertID();
        }

        return (int) $role['id'];
    }
}
