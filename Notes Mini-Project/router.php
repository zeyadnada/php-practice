<?php

$url = parse_url($_SERVER['REQUEST_URI'])['path'];
$routes = require('routes.php');

function routeToController($url, $routes)
{
    // if ($url === '/') {
    //     require 'controllers/index.php';
    // } elseif ($url === '/about') {
    //     require 'controllers/about.php';
    // } elseif ($url === '/contact') {
    //     require 'controllers/contact.php';
    // } else {
    //     http_response_code(404);
    //     abort();
    // }

    //the above code can be replaced with the below code because it more clean, dynamic and scalable 

    if (array_key_exists($url, $routes)) {
        require $routes[$url];
    } else {
        http_response_code(404);
        abort();
    }
}

function abort($code = 404)
{
    http_response_code(404);
    require "views/{$code}.php";
    die();
}

routeToController($url, $routes);