<?php

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected UserModel $userModel;
    protected RoleModel $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function index(): string
    {
        return view('auth/login', [
            'pageTitle' => 'Connexion - Health Coach',
            'pageHeading' => 'Connexion',
            'breadcrumb' => 'Connexion',
        ]);
    }

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

        $isGold = $this->userModel->refreshGoldStatus((int) $user['id']);

        session()->set([
            'user_id' => $user['id'],
            'user_nom' => $user['nom'],
            'user_prenom' => $user['prenom'],
            'user_email' => $user['email'],
            'role_id' => $user['role_id'],
            'is_gold' => $isGold,
            'isLoggedIn' => true,
        ]);

        $redirectAfterAuth = session('redirect_after_auth');
        if (is_string($redirectAfterAuth) && $redirectAfterAuth !== '') {
            session()->remove('redirect_after_auth');
            return redirect()->to($redirectAfterAuth)->with('success', 'Connexion reussie.');
        }

        return redirect()->to(base_url('/'))->with('success', 'Connexion reussie.');
    }

    public function register(): string
    {
        return view('auth/register_step1', [
            'pageTitle' => 'Inscription - Health Coach',
            'pageHeading' => 'Creer un compte - Etape 1',
            'breadcrumb' => 'Inscription',
        ]);
    }

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
        session()->set('register_step1', [
            'nom' => trim((string) $this->request->getPost('nom')),
            'prenom' => trim((string) $this->request->getPost('prenom')),
            'email' => trim((string) $this->request->getPost('email')),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'date_naissance' => (string) $this->request->getPost('date_naissance'),
            'genre' => (string) $this->request->getPost('genre'),
            'role_id' => $roleId,
        ]);

        return redirect()->to(base_url('register/step2'));
    }

    public function registerStep2(): string
    {
        return view('auth/register_step2', [
            'pageTitle' => 'Inscription - Etape 2 - Health Coach',
            'pageHeading' => 'Completer le profil - Etape 2',
            'breadcrumb' => 'Inscription',
        ]);
    }

    public function processRegisterStep2()
    {
        $step1Data = session()->get('register_step1');
        if (! is_array($step1Data) || $step1Data === []) {
            return redirect()->to(base_url('register'))->with('error', 'Veuillez completer l etape 1.');
        }

        $rules = ['taille' => 'required|numeric', 'poids' => 'required|numeric'];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = $this->userModel->createUserWithHealth($step1Data, [
            'taille' => (float) $this->request->getPost('taille'),
            'poids' => (float) $this->request->getPost('poids'),
        ]);

        if ($userId === null) {
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de l inscription.');
        }

        session()->remove('register_step1');
        session()->set([
            'user_id' => $userId,
            'user_nom' => $step1Data['nom'],
            'user_prenom' => $step1Data['prenom'],
            'user_email' => $step1Data['email'],
            'role_id' => $step1Data['role_id'],
            'is_gold' => false,
            'isLoggedIn' => true,
        ]);

        $redirectAfterAuth = session('redirect_after_auth');
        if (is_string($redirectAfterAuth) && $redirectAfterAuth !== '') {
            session()->remove('redirect_after_auth');
            return redirect()->to($redirectAfterAuth)->with('success', 'Compte cree avec succes.');
        }

        return redirect()->to(base_url('/'))->with('success', 'Compte cree avec succes.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'))->with('success', 'Vous etes deconnecte.');
    }

    public function checkEmail()
    {
        $email = trim((string) $this->request->getGet('email'));
        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON(['available' => false, 'message' => 'Adresse email invalide.']);
        }

        $exists = $this->userModel->getUserByEmail($email) !== null;
        return $this->response->setJSON([
            'available' => ! $exists,
            'message' => $exists ? 'Cet email est deja utilise.' : 'Email disponible.',
        ]);
    }

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
