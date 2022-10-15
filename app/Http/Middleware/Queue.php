<?php
namespace App\Http\Middleware;

class Queue
{
    private $middlewares = []; // fila de middlewares a serem executeados
    private $controller;
    private $controllerArgs = [];
    private static $map = []; // Mapeamente de middlewares

    public function __construct($middlewares, $controller, $controllerArgs)
    {
        $this->middlewares = $middlewares;
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    public function next($request)
    {
        
    }

    public static function setMap($map)
    {
        self::$map = $map;
    }
}