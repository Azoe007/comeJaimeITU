<?php

namespace App\Controllers;

use App\Models\ObjectifHistoryModel;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    private UserModel $userModel;
    private ObjectifHistoryModel $objectifHistoryModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->objectifHistoryModel = new ObjectifHistoryModel();
    }

    public function index()
    {
        $userId = $this->currentUserId();
        if ($userId === 0) {
            return redirect()->to(base_url('login'))->with('error', 'Veuillez vous connecter pour acceder a votre profil.');
        }

        $profile = $this->userModel->getProfile($userId, (bool) session('is_gold'));
        if (! $profile) {
            session()->destroy();
            return redirect()->to(base_url('login'))->with('error', 'Votre session utilisateur est introuvable.');
        }

        return view('profile/index', [
            'pageTitle' => 'Mon Profil - Health Coach',
            'account' => $profile['account'],
            'health' => $profile['health'],
            'user' => $profile['user'],
            'currentObjectif' => $this->objectifHistoryModel->latestForUser($userId),
        ]);
    }

    public function update()
    {
        $userId = $this->currentUserId();
        if ($userId === 0) {
            return redirect()->to(base_url('login'))->with('error', 'Veuillez vous connecter pour modifier votre profil.');
        }

        if (! $this->validate($this->userModel->profileValidationRules($userId), $this->userModel->profileValidationMessages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'nom' => trim((string) $this->request->getPost('nom')),
            'prenom' => trim((string) $this->request->getPost('prenom')),
            'email' => trim((string) $this->request->getPost('email')),
            'genre' => (string) $this->request->getPost('genre'),
            'date_naissance' => (string) $this->request->getPost('date_naissance'),
        ];

        $newPassword = (string) $this->request->getPost('password');
        if ($newPassword !== '') {
            $userData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $healthData = [
            'taille' => (float) $this->request->getPost('taille'),
            'poids' => (float) $this->request->getPost('poids'),
        ];

        if (! $this->userModel->updateProfile($userId, $userData, $healthData)) {
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue pendant la mise a jour du profil.');
        }

        session()->set([
            'user_nom' => $userData['nom'],
            'user_prenom' => $userData['prenom'],
            'user_email' => $userData['email'],
        ]);

        return redirect()->to(base_url('profile'))->with('success', 'Profil utilisateur mis a jour avec succes.');
    }

    private function currentUserId(): int
    {
        return (int) session('user_id');
    }
}
