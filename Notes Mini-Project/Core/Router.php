<?php

namespace Core;

use Core\Middleware\Auth;
use Core\Middleware\Guest;
use Core\Middleware\Middleware;

class Router
{
    protected $routes = [];   // Stores all registered routes

    public function route($url, $method)
    {
        // Loop through all routes and find a match based on URI + HTTP method
        foreach ($this->routes as $route) {

            // Check if both the URI and HTTP method match the current request
            if ($route['uri'] === $url && $route['method'] === strtoupper($method)) {

                //=============Before make map to associate middleware keys with their classes (make it dynamic)================== 
                // If route requires the user to be a guest (not logged in), run Guest middleware

                // if ($route['middleware'] === 'guest') {
                //     (new Guest)->handle();
                // }

                // // If route requires authentication, run Auth middleware

                // if ($route['middleware'] === 'auth') {
                //     (new Auth)->handle();
                // }


                //=============After make map to associate middleware keys with their classes (make it dynamic)==================               
                Middleware::resolve($route['middleware']);

                // Load the controller file associated with this route
                return require base_path($route['controller']);
            }
        }

        // No route matched → show 404 page
        $this->abort();
    }

    // Register a GET route
    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }

    // Register a POST route
    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }

    // Register a PUT route
    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }

    // Register a PATCH route
    public function patch($uri, $controller)
    {
        return  $this->add('PATCH', $uri, $controller);
    }

    // Register a DELETE route
    public function delete($uri, $controller)
    {
        return  $this->add('DELETE', $uri, $controller);
    }

    // Store the route in the routes array
    protected function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'method' => $method,
            'controller' => $controller,
            'middleware' => null
        ];

        // Same as the above array but shorter:
        // $this->routes[] = compact('method', 'uri', 'controller');
        //
        // compact() creates an associative array using variable names as keys.
        // It's basically the opposite of extract().
        return $this;
    }


    // add middleware in each routes array has only() in its route
    public function only($middleware)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $middleware;
        return $this;
    }


    // Render an error page and stop execution
    function abort($code = 404)
    {
        http_response_code($code);
        require base_path("views/{$code}.php");
        die();
    }
}
