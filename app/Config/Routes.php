<?php

namespace Config;

// Create a new instance of our RouteCollection class.
use App\Controllers\AuthController;
use App\Controllers\BudgetHeaderController;
use App\Controllers\Dashboard;
use App\Controllers\FournisseurController;
use App\Controllers\MarketController;
use App\Controllers\PurchaseOrderController;
use App\Controllers\ServiceManagerController;

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
$routes->setDefaultController('AuthController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
/**
 * AUTH ROUTES
 */
//LOGIN
$routes->get('/', "AuthController::checkLogin");
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', "AuthController::logout");
$routes->post('/logout', "AuthController::logout");
$routes->get('/user/delete/(:num)', "AuthController::delete/$1");
// REGISTER
$routes->get('/register', "AuthController::register");
$routes->post('/register', "AuthController::register");
//DASHBOARD
$routes->get("/dashboard", "Dashboard::index");
$routes->get('/power-bi', "Dashboard::powerBi");
$routes->get('/delete-notif/(:num)', "Dashboard::deleteNotification/$1");
// BH
$routes->get("/budget-headers", "BudgetHeaderController::index");
$routes->post("/budget-headers/add", "BudgetHeaderController::add");
$routes->get('/budget-header/(:num)', "BudgetHeaderController::show/$1");
$routes->get('/budget-header/delete/(:num)', "BudgetHeaderController::delete/$1");
$routes->get('/budget-header/(:num)', "BudgetHeaderController::show/$1");
$routes->post("budget-headers/updateHeaders", "BudgetHeaderController::updateHeaders");
$routes->post("budget-headers/transfer", "BudgetHeaderController::transfer");
$routes->post("/budget-headers/ask-credit", "BudgetHeaderController::askCredit");
$routes->post("/budget-headers/accept-virement", "BudgetHeaderController::acceptVirement");

// PO
$routes->get('/purchase-orders', 'PurchaseOrderController::index');
$routes->post('/purchase-order/add', "PurchaseOrderController::add");
$routes->get('/purchase-order/edit/(:num)', "PurchaseOrderController::show/$1");
$routes->post('/purchase-order/edit/(:num)', "PurchaseOrderController::show/$1");
$routes->get('/purchase-order/delete/(:num)', "PurchaseOrderController::delete/$1");


//SERVICE MANAGER
$routes->get('/gestion-service', 'ServiceManagerController::index');

//MARKETS
$routes->post('/market/add', "MarketController::add");
$routes->get('/market/delete/(:num)', "MarketController::delete/$1");
$routes->get('/market/edit/(:num)', "MarketController::edit/$1");
$routes->post('/market/edit/(:num)', "MarketController::edit/$1");
//Fournisseurs
$routes->post('/fournisseur/add', "FournisseurController::add");
$routes->get("/fournisseur/delete/(:num)", "FournisseurController::delete/$1");
$routes->get('/fournisseur/edit/(:num)', "FournisseurController::edit/$1");
$routes->post('/fournisseur/edit/(:num)', "FournisseurController::edit/$1");
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
