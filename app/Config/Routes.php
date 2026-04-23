<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages\Home::index');

// Routes for each page
// $routes->get('/about', 'Pages\Patches::about');
$routes->get('patches', 'Pages\Patches::index');
$routes->get('gallery', 'Pages\Gallery::fetch');

// Feedback
$routes->get('feedback', 'Pages\Feedback::feedback');        
$routes->post('admin/feedback/delete_feedback', 'Admin\Admin::delete_feedback');
$routes->post('admin/feedback/mark_reviewed', 'Admin\Admin::mark_reviewed');
$routes->post('feedback/send_feedback', 'Pages\Feedback::send_feedback');

// Admin routes
$routes->get('admin', 'Admin\Admin::admin');
$routes->post('admin/gallery/upload', 'Admin\Pages\AdminGallery::upload');
$routes->post('admin/gallery/delete/(:num)', 'Admin\Pages\AdminGallery::delete/$1');