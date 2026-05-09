<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('profile', static function () {
    return view('profile/index', [
        'pageTitle' => 'Mon Profil - Health Coach',
    ]);
});
$routes->get('plans', static function () {
    return view('plans/index', [
        'pageTitle' => 'Suggestions de regimes - Health Coach',
    ]);
});
$routes->get('wallet', 'WalletController::index');
$routes->post('wallet/recharger', 'WalletController::recharger');
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
    $routes->get('regimes', static function () {
        return view('admin/regimes', [
            'pageTitle' => 'CRUD Regimes - Health Coach',
            'pageHeading' => 'Gestion des regimes',
            'breadcrumb' => 'Regimes',
            'activeMenu' => 'regimes',
        ]);
    });
    $routes->get('sports', static function () {
        return view('admin/sports', [
            'pageTitle' => 'CRUD Sports - Health Coach',
            'pageHeading' => 'Gestion des activites sportives',
            'breadcrumb' => 'Sports',
            'activeMenu' => 'sports',
        ]);
    });
    $routes->get('codes', static function () {
        return view('admin/codes', [
            'pageTitle' => 'Validation des codes - Health Coach',
            'pageHeading' => 'Validation des codes',
            'breadcrumb' => 'Codes',
            'activeMenu' => 'codes',
        ]);
    });
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
