<?php
namespace App\Http;

use Closure;
use Exception;

class Router
{
    private $url;
    private $prefix;
    private $routes = [];
    private $request;

    public function __construct($url)
    {
        $this->request  = new Request;
        $this->url      = $url;
        $this->setPrefix();
     
    }

    private function setPrefix()
    {
        $parseUrl = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';
    }

    private function addRoute($method, $route, $params = [])
    {
        foreach($params as $key => $value) {
            if($value instanceof Closure) {
                unset($params[$key]);
                $params['controller'] = $value;
            }
        }
        $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';
        $this->routes[$patternRoute][$method] = $params;
      
    }

    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    private function getUri()
    {
        $uri = $this->request->getUri();
        $explodeUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        return end($explodeUri);
    }

    private function getRoute()
    {
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();
        
        foreach($this->routes as $pattern => $method) {
            if(preg_match($pattern, $uri)) {
                if(isset($method[$httpMethod])) {
                    return $method[$httpMethod];
                }

                throw new Exception('Método não permitido', 405);
            }
        }

        throw new Exception('Página não encontrada', 404);
    }

    public function run() 
    {
        try {
            $route = $this->getRoute();

            if(!isset($route['controller'])) {
                throw new Exception('Erro da aplicação', 500);
            }

            $args = [];
            return call_user_func_array($route['controller'], $args);

        } catch(Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}