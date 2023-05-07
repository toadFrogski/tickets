<?php

namespace Core\Routing;

use Core\HttpFoundation\Request;
use Core\Routing\Route;

class Router
{
    private array $routes = [];

    public function __construct(array $routes = []) {
        foreach ( $routes as $route) {
            $this->add($route);
        }
    }
    public function add(Route $route)
    {
        $this->routes[$route->getName()] = $route;
    }

    public function dispatch(string $uri, string $method) {
        try {
            $request = new Request($uri);
            $route = $this->match($request->getPath(), $method);
            [$handlerController, $handlerMethod] = $route->getHandler();
            $controller = new $handlerController;
            echo $controller->{$handlerMethod}($request);
        } catch (\Exception $e) {
            header("HTTP/1.0 404 Not Found");
        }
    }

    private function match(string $path, string $method) {
        foreach ($this->routes as $route) {
            if ($route->getPath() == $path && $route->getMethod() == $method) {
                return $route;
            }
        }
    }
}