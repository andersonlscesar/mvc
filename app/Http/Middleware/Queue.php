<?php
namespace App\Http\Middleware;

use Exception;

class Queue
{
    private $middlewares = []; // fila de middlewares a serem executeados
    private $controller;
    private $controllerArgs = [];
    private static $map = []; // Mapeamente de middlewares
    private static $default = []; // Middlewares que devem ser carregados em todas as rotas

    public function __construct($middlewares, $controller, $controllerArgs)
    {
        $this->middlewares = array_merge(self::$default, $middlewares);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    public function next($request)
    {
        // Verifica se a fila de middlewares está vazia
        if(empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);     
        
        $middleware = array_shift($this->middlewares);

        // Verifica se o middleware está mapeado
        if(!isset(self::$map[$middleware])) {
            throw new Exception('Problema com o middleware', 500);
        }

        $queue = $this;
        $next = function($request) use($queue) {
            return $queue->next($request);
        };

        return (new self::$map[$middleware])->handle($request, $next);    
    }

    public static function setMap($map)
    {
        self::$map = $map;
    }

    public static function setDefault($default)
    {
        self::$default = $default;
    }
}