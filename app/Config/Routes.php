<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ─── User Routes ──────────────────────────────────────
$routes->get('/',                   'HomeController::index');
$routes->get('/map',                'MapController::index');
$routes->get('/tempat/(:num)',      'TempatController::detail/$1');
$routes->post('/tempat/(:num)/review', 'ReviewController::store/$1');

// ─── API Routes (untuk Leaflet) ───────────────────────
$routes->get('/api/markers',        'Api\TempatApiController::markers');
$routes->get('/api/nearby',         'Api\TempatApiController::nearby');
$routes->get('/api/recommendation', 'Api\TempatApiController::recommendation');
$routes->get('/api/statistik',      'Api\TempatApiController::statistik');

// ─── Admin Routes ─────────────────────────────────────
// Auth
$routes->get('/admin/login',          'Admin\AuthController::login');
$routes->post('/admin/login/process', 'Admin\AuthController::process');
$routes->get('/admin/logout',         'Admin\AuthController::logout');
 
// Dashboard
$routes->get('/admin',                'Admin\DashboardController::index');
 
// Tempat CRUD
$routes->get('/admin/tempat',                  'Admin\TempatAdminController::index');
$routes->get('/admin/tempat/create',           'Admin\TempatAdminController::create');
$routes->post('/admin/tempat/store',           'Admin\TempatAdminController::store');
$routes->get('/admin/tempat/edit/(:num)',      'Admin\TempatAdminController::edit/$1');
$routes->post('/admin/tempat/update/(:num)',   'Admin\TempatAdminController::update/$1');
$routes->get('/admin/tempat/delete/(:num)',    'Admin\TempatAdminController::delete/$1');
$routes->get('/admin/tempat/toggle/(:num)',    'Admin\TempatAdminController::toggleStatus/$1');
$routes->get('/admin/review', 'Admin\ReviewAdminController::index');
$routes->get('/admin/review/delete/(:num)', 'Admin\ReviewAdminController::delete/$1');
$routes->get('/admin/review/toggle/(:num)', 'Admin\ReviewAdminController::toggleVisible/$1');
