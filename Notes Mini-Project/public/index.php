<?php

// require 'functions.php';
// require 'Database.php';
// require 'Response.php';
// require 'router.php';


// The BASE_PATH constant points to the project root directory.
// __DIR__ = /public
// __DIR__ . '/../' = go one level up → the real project root
const BASE_PATH = __DIR__ . '/../';


require BASE_PATH . 'Core/functions.php';

// ---------------------------------------------------------------------------------------------------------
// AUTOLOADER
// ---------------------------------------------------------------------------------------------------------

// spl_autoload_register() tells PHP:
// "Whenever you use a class that hasn't been loaded yet,
// automatically run this function to load the class file."
spl_autoload_register(function ($class) {

    // Convert namespace separators "\" into directory separators "/"
    // Example: "Core\Database" → "Core/Database"
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // Build the full path to the class file and require it
    // base_path("Core/Database.php")
    require base_path("{$class}.php");
});


session_start();

// --------------------------------------------------------------------------------------------------------
// ROUTER SETUP & REQUEST HANDLING
// --------------------------------------------------------------------------------------------------------

// This Router class contains the logic that decides which controller to call.
$router = new \Core\Router();

// Load the routes.php file.
// This file does NOT return anything — instead,
// it directly calls $router->get(), $router->post(), etc.
// to register all your application routes.
require base_path('routes.php');

// Extract only the path part from the current URL
$url = parse_url($_SERVER['REQUEST_URI'])['path'];

// Since HTML forms only support GET and POST, we use a hidden input named "_method"
// to simulate other HTTP methods like PUT or DELETE.
// If _method exists, use it; otherwise use the real request method.
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

// Let the router match the URL + method and call the correct controller
$router->route($url, $method);
