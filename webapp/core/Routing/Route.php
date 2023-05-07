<?php

namespace Core\Routing;

class Route
{

    /**
     * @var string $name
     */
    private string $name = '';


    /**
     * @var string $path
     */
    private string $path = '';

    /**
     * @var array<string> $handler
     */
    private array $handler = [];

    /**
     * Route constructor
     * @param string $path
     * @param array $handler
     *      $handler = [
     *          0 => (string) Controller name : ExampleController::class
     *          1 => (string) Method name
     *      ]
     */

    /**
     * @var string $method
     */
    private string $method;

    public function __construct(string $name, string $path, array $handler, string $method)
    {
        $this->name = $name;
        $this->path = $path;
        $this->handler = $handler;
        $this->method = $method;
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getHandler() : array {
        return $this->handler;
    }

    public function getMethod() : string {
        return $this->method;
    }

}