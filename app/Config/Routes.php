<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages\Home::index');

// Routes for each page
// $routes->get('/about', 'Pages::about');
$routes->get('gallery', 'Pages\Gallery::fetch');


// Feedback
$routes->get('feedback', 'Pages\Feedback::feedback');        
$routes->post('feedback/send_feedback', 'Pages\Feedback::send_feedback');




// Admin routes
$routes->get('admin', 'Admin\Admin::admin');
$routes->post('admin/gallery/upload', 'Admin\Pages\AdminGallery::upload');