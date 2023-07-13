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
$routes->addRedirect('/public', '/');
$routes->addRedirect('/public/(:any)', '/$1');
$routes->match(['get', 'post'], '/login', 'Login::index');
$routes->get('/api/(:any)', 'Api::$1');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/logout', 'Dashboard::logout');
$routes->match(['get', 'post'], '/password/(:any)', 'Dashboard::change_password/$1');
$routes->match(['get', 'post'], '/upline/(:any)', 'Dashboard::change_upline/$1');

//super admin
$routes->get('/super_admin', 'Admin::index/dashboard');
$routes->get('/super_admin/(:any)', 'Admin::index/$1');

//admin
$routes->get('/admin', 'Admin::index/dashboard');
$routes->get('/admin/(:any)', 'Admin::index/$1');
$routes->match(['get', 'post'], '/register_operator', 'Admin::register_operator');
$routes->match(['get', 'post'], '/settings', 'Admin::settings');
$routes->match(['get', 'post'], '/reports', 'Admin::reports');
$routes->match(['get', 'post'], '/news', 'Admin::news');


//operator
$routes->get('/operator', 'Operator::index/dashboard');
$routes->get('/operator/(:any)', 'Operator::index/$1');
$routes->match(['get', 'post'], '/register_super_agent', 'Operator::register_super_agent');
$routes->match(['get', 'post'], '/operator_profile', 'Operator::operator_profile');
$routes->match(['get', 'post'], '/operator_news', 'Operator::news');

//super_agent
$routes->get('/super_agent', 'SuperAgent::index/dashboard');
$routes->get('/super_agent/(:any)', 'SuperAgent::index/$1');
$routes->match(['get', 'post'], '/register_agent', 'SuperAgent::register_agent');
$routes->match(['get', 'post'], '/super_agent_profile', 'SuperAgent::super_agent_profile');
$routes->match(['get', 'post'], '/super_agent_news', 'SuperAgent::news');


//agent
$routes->get('/agent', 'Agent::index/dashboard');
$routes->get('/agent/(:any)', 'Agent::index/$1');
$routes->match(['get', 'post'], '/agent_profile', 'Agent::agent_profile');

//player
$routes->match(['get', 'post'], '/register/(:any)', 'Login::player/$1');

$routes->get('/player/(:any)', 'Player::index/$1');
$routes->match(['get', 'post'], '/edit_player/(:any)', 'Player::edit_player/$1');


//API
$routes->get('/api', 'Api::index');
$routes->post('/api/import_report', 'Api::import_report');
$routes->post('/api/process_commission', 'Api::process_commission');
$routes->post('/api/search_operator', 'Api::search_operator');
$routes->post('/api/update_operator', 'Api::update_operator');
$routes->post('/api/search_super_agent', 'Api::search_super_agent');
$routes->post('/api/update_super_agent', 'Api::update_super_agent');
$routes->post('/api/search_agent', 'Api::search_agent');
$routes->post('/api/update_agent', 'Api::update_agent');
$routes->get('/api/get_transaction_count', 'Api::get_transaction_count');
$routes->get('/api/check_processing', 'Api::check_processing');
$routes->get('/api/auto_pair', 'Api::auto_pair');

//Payouts
$routes->get('/payouts/(:any)', 'Payout::index/$1');
$routes->match(['get', 'post'], '/process_payout/(:any)', 'Payout::process_payout/$1');

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
