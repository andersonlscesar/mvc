<?php
namespace App\Http;

use Closure;
use Exception;
use ReflectionFunction;
use App\Http\Middleware\Queue;

class Router
{
    private $url;
    private $prefix;
    private $routes = [];
    private $request;
    private $contentType = 'text/html';

    public function __construct($url)
    {
        $this->request  = new Request($this);
        $this->url      = $url;
        $this->setPrefix();
     
    }

    public function setContentType($contentType) 
    {
        $this->contentType = $contentType;
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

        $params['middlewares'] = $params['middlewares'] ?? [];

        $params['variables'] = [];
        $patternVariables = '/{(.*?)}/';

        if(preg_match_all($patternVariables, $route, $matches)) {
            $route = preg_replace($patternVariables, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        $route = rtrim($route, '/');

        $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';
        $this->routes[$patternRoute][$method] = $params;
      
    }

    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    private function getUri()
    {
        $uri = $this->request->getUri();
        $explodeUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        return rtrim(end($explodeUri), '/');
    }

    private function getRoute()
    {
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();

        foreach($this->routes as $pattern => $method) {
            if(preg_match($pattern, $uri, $matches)) {
                if(isset($method[$httpMethod])) {
                    unset($matches[0]);
                    $keys = $method[$httpMethod]['variables'];
                    $method[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $method[$httpMethod]['variables']['request'] = $this->request;
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
            $reflection = new ReflectionFunction($route['controller']);
            foreach($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }
            
         
            return (new Queue($route['middlewares'], $route['controller'], $args))->next($this->request);

        } catch(Exception $e) {
            return new Response($e->getCode(), $this->getErrorMessage($e->getMessage()), $this->contentType);
        }
    }

    private function getErrorMessage($message) 
    {
        switch($this->contentType) {
            case 'application/json':
                return [
                    'error' => $message
                ];
                break;
            default: 
                return $message;
        }
    }

    public function getCurrentURL()
    {   
        return $this->url.$this->getUri();
    }

    public function redirect($route)
    {
        header('Location: '.getenv('URL').'/'.$route);
        exit;
    }


}