<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ---------------------------------------------------------------------
// Public site
// ---------------------------------------------------------------------
$routes->get('/', 'Pages\Home::index');
$routes->get('about', 'Pages\About::about');
$routes->get('learn', 'Pages\Learn::learn');
$routes->get('gallery', 'Pages\Gallery::fetch');
$routes->get('patches', 'Pages\Patches::fetch');

$routes->get('feedback', 'Pages\Feedback::feedback');
$routes->post('feedback', 'Pages\Feedback::submit');

$routes->get('animations/cyber_preloader', 'Pages\AnimationController::cyber_preloader');

// ---------------------------------------------------------------------
// Admin: authentication (the only admin routes reachable while logged out)
// ---------------------------------------------------------------------
$routes->get('admin-login', 'Admin\Auth::loginForm');
$routes->post('admin/login', 'Admin\Auth::login');
$routes->post('admin/logout', 'Admin\Auth::logout');

// ---------------------------------------------------------------------
// Admin: everything else. ONE filter guards the whole group, so a new
// route added here is protected by default. All mutations are POST
// (CSRF-checked by the global csrf filter).
// ---------------------------------------------------------------------
$routes->group('admin', [
    'namespace' => 'App\Controllers\Admin',
    'filter'    => 'adminAuth',
], static function (RouteCollection $routes): void {
    $routes->get('/', 'Dashboard::index');

    $routes->post('feedback/(:num)/reviewed', 'Feedback::markReviewed/$1');
    $routes->post('feedback/(:num)/delete', 'Feedback::delete/$1');

    $routes->post('gallery', 'Gallery::save');
    $routes->post('gallery/(:num)/delete', 'Gallery::delete/$1');

    $routes->post('patches', 'Patches::save');
    $routes->post('patches/(:num)/delete', 'Patches::delete/$1');
});
