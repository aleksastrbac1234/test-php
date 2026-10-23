<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function get($path, $action, $middleware = [])
    {
        $this->routes['GET'][$path] = [$action, $middleware];
    }

    public function post($path, $action, $middleware = [])
    {
        $this->routes['POST'][$path] = [$action, $middleware];
    }

    public function dispatch($method, $uri)
    {
        $path = parse_url($uri, PHP_URL_PATH);

        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);
            view('404');
            return;
        }

        [$action, $middleware] = $this->routes[$method][$path];

        foreach ($middleware as $class) {
            (new $class)->handle();
        }

        [$controller, $function] = $action;
        (new $controller)->$function();
    }
}
