<?php

namespace Core\Middleware;

class Middleware
{
    // Map of middleware names to their corresponding class handlers
    const MAP = [
        'auth' => Auth::class,
        'guest' => Guest::class,
    ];

    // Resolve and execute the middleware by its key.

    public static function resolve($key)
    {
        // If no middleware key is provided (null or empty), simply skip middleware
        if (!$key) {
            return;
        }

        // Look up the middleware in the MAP; return false if not found
        $middleware = static::MAP[$key] ?? false;

        // If the middleware name isn't defined in the MAP, throw an exception
        if (!$middleware) {
            throw new \Exception("Middleware '{$key}' not found in the middleware map.");
        }

        // Instantiate the middleware class and execute its handle() method
        (new $middleware)->handle();
    }
}
