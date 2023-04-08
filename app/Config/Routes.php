<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/register/(:any)', 'Home::createUser');
$routes->post('/register', 'Home::createUser');
$routes->get('/admin-login', 'Home::userLogin');
$routes->get('/assistant-login', 'Home::userLogin');
$routes->get('/employee-login', 'Home::userLogin');
$routes->post('/user-login', 'Home::userLogin');
$routes->get('/logout', 'Home::userLogout');
$routes->get('/user-dashboard', 'Dashboard::home');
$routes->get('/dashboard', 'Dashboard::home');
$routes->get('/add-user', 'Dashboard::createUser');
$routes->post('/add-user', 'Dashboard::createUser');
$routes->get('/edit-user/(:any)', 'Dashboard::createUser');
$routes->get('/edit-profile/(:any)', 'Dashboard::createUser');
$routes->get('/delete-user/(:any)', 'Dashboard::deleteUser');
$routes->get('/users', 'Dashboard::userList');
$routes->get('/sms-details', 'Dashboard::smsList');
$routes->post('/send-sms', 'Dashboard::sendSms');
$routes->get('/send-sms', 'Dashboard::sendSms');

$routes->get('/clients', 'Dashboard::clientList');
// $routes->get('/client-registration', 'Dashboard::clientRegistration');
$routes->get('/client-registration', 'Dashboard::clientRegistration');
$routes->post('/client-registration', 'Dashboard::clientRegistration');
$routes->post('/client-registration/fileUpload', 'Dashboard::uploadDocs');
$routes->get('/edit-client/(:any)', 'Dashboard::clientRegistration');
$routes->get('/view-file/(:any)', 'Dashboard::viewOrDownloadFile');
$routes->post('/save-notes', 'Dashboard::saveNotes');
$routes->post('/update-file-status', 'Dashboard::updateFileStatus');
$routes->post('/delete-notes', 'Dashboard::deleteNotes');
$routes->post('/allot-client', 'Dashboard::allotClientToEmployee');
$routes->get('/delete-client/(:any)', 'Dashboard::deleteClient');
$routes->post('/delete-file', 'Dashboard::deleteFile');
use App\Controllers\Pages;

// $routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);

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
