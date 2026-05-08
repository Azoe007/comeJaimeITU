<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

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
