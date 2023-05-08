<?php

namespace Core\Routing;

use Core\HttpFoundation\Request;
use Core\Routing\Route;

class Router
{

    private static array $instances = [];

    private array $routes = [];

    public static function getInstance(array $routes = []): Router
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            global $database_settings;
            self::$instances[$cls] = new static($routes);
        }

        return self::$instances[$cls];
    }

    public function __construct(array $routes = [])
    {
        foreach ($routes as $route) {
            $this->add($route);
        }
    }
    public function add(Route $route)
    {
        $this->routes[$route->getName()] = $route;
    }

    public function dispatch(string $uri, string $method)
    {
        try {
            $request = new Request($uri);
            $route = $this->matchUrl($request->getPath(), $method);
            [$handlerController, $handlerMethod] = $route->getHandler();
            $controller = new $handlerController;
            echo $controller->{$handlerMethod}($request);
        } catch (\Exception $e) {
            header("HTTP/1.0 404 Not Found");
        }
    }

    public function redirect(string $name, Request $request)
    {
        try {
            $route = $this->matchName($name);
            [$handlerController, $handlerMethod] = $route->getHandler();
            $controller = new $handlerController;
            echo $controller->{$handlerMethod}($request);
        } catch (\Exception $e) {
            header("HTTP/1.0 404 Not Found");
        }
    }

    private function matchUrl(string $path, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route->getPath() == $path && $route->getMethod() == $method) {
                return $route;
            }
        }
    }

    private function matchName(string $name)
    {
        foreach ($this->routes as $route) {
            if ($route->getName() == $name) {
                return $route;
            }
        }
    }
}