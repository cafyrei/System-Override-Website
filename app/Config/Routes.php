<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages\Home::index');

// Routes for each page
// $routes->get('/about', 'Pages::about');
$routes->get('feedback', 'Pages\Feedback::feedback');        