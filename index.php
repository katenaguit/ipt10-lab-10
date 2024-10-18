<?php

require "vendor/autoload.php";
require "init.php";

// Database connection object (from init.php (DatabaseConnection))
global $conn;

try {



    // Create Router instance
    $router = new \Bramus\Router\Router();

    // Define routes
    $router->get('/registration-form', '\App\Controllers\RegistrationController@showRegisterForm');
    $router->post('/register', '\App\Controllers\RegistrationController@register');

    $router->get('/login-form', '\App\Controllers\LoginController@showLoginForm');
    $router->post('/login', '\App\Controllers\LoginController@login');
    $router->get('/welcome', '\App\Controllers\HomeController@welcome');
    $router->get('/logout', '\App\Controllers\LoginController@logout');
    
    $router->get('/', '\App\Controllers\HomeController@index');

    // Run it!
    $router->run();

} catch (Exception $e) {

    echo json_encode([
        'error' => $e->getMessage()
    ]);

}
