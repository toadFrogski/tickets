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
            if (empty($route)) {
                header('Location: /');
            }
            [$handlerController, $handlerMethod] = $route->getHandler();
            $controller = new $handlerController;
            echo $controller->{$handlerMethod}($request);
        } catch (\Exception $e) {
            header("Location: /");
        }
    }

    public function redirect(string $name)
    {
        $route = $this->matchName($name);
        header("Location:" . $route->getPath());
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