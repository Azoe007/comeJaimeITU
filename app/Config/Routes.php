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

$routes->group('admin', static function ($routes) {
    $routes->get('login', static function () {
        return view('admin/login');
    });
    $routes->get('/', static function () {
        return view('admin/dashboard', [
            'pageTitle' => 'Dashboard - Health Coach',
            'pageHeading' => 'Tableau de bord',
            'breadcrumb' => 'Administration',
            'activeMenu' => 'dashboard',
        ]);
    });
    $routes->get('regimes', 'AdminRegimeController::index');
    $routes->post('regimes', 'AdminRegimeController::store');
    $routes->post('regimes/(:num)/update', 'AdminRegimeController::update/$1');
    $routes->post('regimes/(:num)/delete', 'AdminRegimeController::delete/$1');
    $routes->get('sports', 'AdminSportController::index');
    $routes->post('sports', 'AdminSportController::store');
    $routes->post('sports/(:num)/update', 'AdminSportController::update/$1');
    $routes->post('sports/(:num)/delete', 'AdminSportController::delete/$1');
    $routes->get('codes', 'CodeController::adminIndex');
    $routes->get('parametres', 'AdminParametreController::index');
    $routes->post('parametres', 'AdminParametreController::save');
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
