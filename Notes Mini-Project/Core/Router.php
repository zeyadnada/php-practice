<?php

namespace Core;

class Router
{
    protected $routes = [];   // Stores all registered routes

    public function route($url, $method)
    {
        // Loop through all routes and find a match based on URI + HTTP method
        foreach ($this->routes as $route) {
            if ($route['uri'] === $url && $route['method'] === strtoupper($method)) {

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
        $this->add('GET', $uri, $controller);
    }

    // Register a POST route
    public function post($uri, $controller)
    {
        $this->add('POST', $uri, $controller);
    }

    // Register a PUT route
    public function put($uri, $controller)
    {
        $this->add('PUT', $uri, $controller);
    }

    // Register a PATCH route
    public function patch($uri, $controller)
    {
        $this->add('PATCH', $uri, $controller);
    }

    // Register a DELETE route
    public function delete($uri, $controller)
    {
        $this->add('DELETE', $uri, $controller);
    }

    // Store the route in the routes array
    protected function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'method' => $method,
            'controller' => $controller
        ];

        // Same as the above array but shorter:
        // $this->routes[] = compact('method', 'uri', 'controller');
        //
        // compact() creates an associative array using variable names as keys.
        // It's basically the opposite of extract().
    }

    // Render an error page and stop execution
    function abort($code = 404)
    {
        http_response_code($code);
        require base_path("views/{$code}.php");
        die();
    }
}
