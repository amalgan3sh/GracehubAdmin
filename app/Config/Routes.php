<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/select_dashboard_type', 'Home::SelectDashboard');

$routes->get('login', 'AuthController::index');
$routes->post('verify_login', 'AuthController::VerifyLogin');

$routes->get('register', 'AuthController::register');
$routes->get('/logout', 'AuthController::logout');

$routes->post('registerUser', 'AuthController::registerUser');

$routes->get('register-user', 'ApiController::registerUser');
$routes->get('super_admin_dashboard', 'AuthController::adminDashboard');



