<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages\Home::index');

// Public Pages Context
$routes->get('about', 'Pages\About::about');
$routes->get('learn', 'Pages\Learn::learn');
$routes->get('gallery', 'Pages\Gallery::fetch');
$routes->get('patches', 'Pages\Patches::fetch');

// Public Feedback Submission
$routes->get('feedback', 'Pages\Feedback::feedback');
$routes->post('feedback/send_feedback', 'Pages\Feedback::send_feedback');

// Admin Auth Handling
$routes->get('admin-login', 'Admin\Admin::adminlogin');
$routes->post('admin/login/authenticate', 'Admin\Admin::authenticate');
$routes->get('admin/logout', 'Admin\Admin::logout');

// Protected Admin Dashboard Context & Management Actions
$routes->get('admin', 'Admin\Admin::admin');
$routes->post('admin/feedback/delete_feedback', 'Admin\Admin::delete_feedback');
$routes->post('admin/feedback/mark_reviewed', 'Admin\Admin::mark_reviewed');
$routes->post('admin/gallery/upload', 'Admin\Pages\AdminGallery::upload');
$routes->post('admin/gallery/delete/(:num)', 'Admin\Pages\AdminGallery::delete/$1');

// Protected Admin Patch Actions
$routes->post('patches/patches/upload', 'Admin\Pages\AdminPatch::upload');
$routes->get('patches/patches/delete/(:num)', 'Admin\Pages\AdminPatch::delete/$1');

// Animation Routes
$routes->get('animations/cyber_preloader', 'Pages\AnimationController::cyber_preloader');