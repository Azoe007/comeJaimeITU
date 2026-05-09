<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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
            'account'   => $profile['account'],
            'health'    => $profile['health'],
            'user'      => $profile['user'],
        ]);
    }

    public function update()
    {
        $userId = $this->currentUserId();

        if ($userId === 0) {
            if ($this->request->isAJAX()) {
                return $this->jsonResponse([
                    'success'  => false,
                    'message'  => 'Veuillez vous connecter pour modifier votre profil.',
                    'redirect' => base_url('login'),
                ], 401);
            }

            return redirect()->to(base_url('login'))->with('error', 'Veuillez vous connecter pour modifier votre profil.');
        }

        $profile = $this->userModel->getProfile($userId, (bool) session('is_gold'));

        if (! $profile) {
            session()->destroy();

            if ($this->request->isAJAX()) {
                return $this->jsonResponse([
                    'success'  => false,
                    'message'  => 'Votre session utilisateur est introuvable.',
                    'redirect' => base_url('login'),
                ], 404);
            }

            return redirect()->to(base_url('login'))->with('error', 'Votre session utilisateur est introuvable.');
        }

        if (! $this->validate(
            $this->userModel->profileValidationRules($userId),
            $this->userModel->profileValidationMessages()
        )) {
            if ($this->request->isAJAX()) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Veuillez corriger les champs indiques.',
                    'errors'  => $this->validator->getErrors(),
                ], 422);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'nom'            => trim((string) $this->request->getPost('nom')),
            'prenom'         => trim((string) $this->request->getPost('prenom')),
            'email'          => trim((string) $this->request->getPost('email')),
            'genre'          => (string) $this->request->getPost('genre'),
            'date_naissance' => (string) $this->request->getPost('date_naissance'),
        ];

        $newPassword = (string) $this->request->getPost('password');

        if ($newPassword !== '') {
            $userData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $healthData = [
            'taille' => (float) $this->request->getPost('taille'),
            'poids'  => (float) $this->request->getPost('poids'),
        ];

        if (! $this->userModel->updateProfile($userId, $userData, $healthData)) {
            if ($this->request->isAJAX()) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Une erreur est survenue pendant la mise a jour du profil.',
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue pendant la mise a jour du profil.');
        }

        session()->set([
            'user_nom'    => $userData['nom'],
            'user_prenom' => $userData['prenom'],
            'user_email'  => $userData['email'],
        ]);

        if ($this->request->isAJAX()) {
            $updatedProfile = $this->userModel->getProfile($userId, (bool) session('is_gold'));

            return $this->jsonResponse([
                'success' => true,
                'message' => 'Profil utilisateur mis a jour avec succes.',
                'user'    => $updatedProfile['user'] ?? null,
            ]);
        }

        return redirect()->to(base_url('profile'))->with('success', 'Profil utilisateur mis a jour avec succes.');
    }

    private function currentUserId(): int
    {
        return (int) session('user_id');
    }

    private function jsonResponse(array $payload, int $statusCode = 200)
    {
        return $this->response
            ->setStatusCode($statusCode)
            ->setJSON(array_merge($payload, [
                'csrf' => [
                    'name' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]));
    }
}
