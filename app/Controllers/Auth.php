<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserHealthModel;
use App\Models\HealthHistoryModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $userHealthModel;
    protected $healthHistoryModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userHealthModel = new UserHealthModel();
        $this->healthHistoryModel = new HealthHistoryModel();
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
        // À implémenter
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
        // À implémenter
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
        // À implémenter
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        // À implémenter
    }
}
