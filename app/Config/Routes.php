<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');

$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::login');

$routes->get('/register', 'Auth::register');
$routes->post('/register/step1', 'Auth::registerStep1');

$routes->get('/register/step2', 'Auth::registerStep2');
$routes->post('/register/step2', 'Auth::processRegisterStep2');

$routes->get('/logout', 'Auth::logout');
