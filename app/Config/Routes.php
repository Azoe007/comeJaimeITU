<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('objectif/diagnostic', 'ObjectifController::diagnostic');
$routes->post('objectif/diagnostic', 'ObjectifController::saveDiagnostic');
$routes->get('objectif/intention', 'ObjectifController::intention');
$routes->post('objectif/intention', 'ObjectifController::saveIntention');
$routes->get('objectif/commande', 'SuggestionController::commande');
$routes->post('objectif/commande/payer', 'SuggestionController::payer');

$routes->get('suggestion', 'SuggestionController::index');
$routes->get('suggestion/(:segment)', 'SuggestionController::detail/$1');
$routes->post('suggestion/(:segment)/save', 'SuggestionController::saveSelection/$1');

$routes->get('profile', 'ProfileController::index');
$routes->post('profile', 'ProfileController::update');
$routes->get('mon-objectif', 'MonObjectifController::index');

$routes->get('plans', static function () {
    return view('plans/index', ['pageTitle' => 'Suggestions de regimes - Health Coach']);
});

$routes->get('wallet', 'WalletController::index');
$routes->post('wallet/recharger', 'WalletController::recharger');
$routes->post('wallet/acheterGold', 'WalletController::acheterGold');

$routes->get('code', 'CodeController::index');

// Routes Admin - Sans filtrage (login accessible)
$routes->get('admin/login', 'Admin::loginPage');
$routes->post('admin/login', 'Admin::login');
$routes->get('admin/logout', 'Admin::logout');

// Routes Admin - Avec filtrage AuthFilter
$routes->group('admin', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Admin::dashboard');
    $routes->get('users', 'Admin::users');
    $routes->get('users/(:num)', 'Admin::userDetail/$1');
    $routes->get('finances', 'Admin::finances');
    $routes->get('programmes', 'Admin::programmes');
    $routes->get('health', 'Admin::health');
    
    // Routes CRUD - Regimes
    $routes->get('regimes', 'AdminRegimeController::index');
    $routes->post('regimes', 'AdminRegimeController::store');
    $routes->post('regimes/(:num)/update', 'AdminRegimeController::update/$1');
    $routes->post('regimes/(:num)/delete', 'AdminRegimeController::delete/$1');
    
    // Routes CRUD - Sports
    $routes->get('sports', 'AdminSportController::index');
    $routes->post('sports', 'AdminSportController::store');
    $routes->post('sports/(:num)/update', 'AdminSportController::update/$1');
    $routes->post('sports/(:num)/delete', 'AdminSportController::delete/$1');
    
    // Routes CRUD - Codes et Settings
    $routes->get('codes', 'CodeController::adminIndex');
    $routes->get('settings', static function () {
        return view('admin/settings', [
            'pageTitle' => 'Parametres - Health Coach',
            'pageHeading' => 'Parametres metier',
            'breadcrumb' => 'Parametres',
            'activeMenu' => 'settings',
        ]);
    });
});

$routes->group('', static function ($routes) {
    $routes->get('login', 'Auth::index');
    $routes->post('login', 'Auth::login');

    $routes->group('register', static function ($routes) {
        $routes->get('/', 'Auth::register');
        $routes->post('step1', 'Auth::registerStep1');
        $routes->get('step2', 'Auth::registerStep2');
        $routes->post('step2', 'Auth::processRegisterStep2');
        $routes->get('check-email', 'Auth::checkEmail');
    });

    $routes->get('logout', 'Auth::logout');
});
