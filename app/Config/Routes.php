<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();


// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


$routes->get('/', 'Login::index');
$routes->get('/login', 'Login::index');
$routes->post('/login', 'Login::index');
$routes->get('/api/(:any)', 'Api::$1');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/logout', 'Dashboard::logout');

//admin
$routes->get('/admin', 'Admin::index/dashboard');
$routes->get('/admin/(:any)', 'Admin::index/$1');
$routes->get('/register_operator', 'Admin::register_operator');
$routes->post('/register_operator', 'Admin::register_operator');
$routes->get('/settings', 'Admin::settings');
$routes->post('/settings', 'Admin::settings');
$routes->get('/reports', 'Admin::reports');
$routes->post('/reports', 'Admin::reports');


//operator
$routes->get('/operator', 'Operator::index/dashboard');
$routes->get('/operator/(:any)', 'Operator::index/$1');
$routes->get('/register_super_agent', 'Operator::register_super_agent');
$routes->post('/register_super_agent', 'Operator::register_super_agent');
$routes->get('/operator_profile', 'Operator::operator_profile');
$routes->post('/operator_profile', 'Operator::operator_profile');

//super_agent
$routes->get('/super_agent', 'SuperAgent::index/dashboard');
$routes->get('/super_agent/(:any)', 'SuperAgent::index/$1');
$routes->get('/register_agent', 'SuperAgent::register_agent');
$routes->post('/register_agent', 'SuperAgent::register_agent');
$routes->get('/super_agent_profile', 'SuperAgent::super_agent_profile');
$routes->post('/super_agent_profile', 'SuperAgent::super_agent_profile');


//agent
$routes->get('/agent', 'Agent::index/dashboard');
$routes->get('/agent/(:any)', 'Agent::index/$1');
$routes->get('/agent_profile', 'Agent::agent_profile');
$routes->post('/agent_profile', 'Agent::agent_profile');

//player
$routes->get('/register/(:any)', 'Login::player/$1');
$routes->post('/register/(:any)', 'Login::player/$1');

$routes->get('/player/(:any)', 'Player::index/$1');
$routes->get('/edit_player/(:any)', 'Player::edit_player/$1');
$routes->post('/edit_player/(:any)', 'Player::edit_player/$1');


//API
$routes->get('/api', 'Api::index');
$routes->post('/api/import_report', 'Api::import_report');
$routes->post('/api/process_commission', 'Api::process_commission');

//Payouts
$routes->get('/payouts/(:any)', 'Payout::index/$1');
$routes->get('/process_payout/(:any)', 'Payout::process_payout/$1');
$routes->post('/process_payout/(:any)', 'Payout::process_payout/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
