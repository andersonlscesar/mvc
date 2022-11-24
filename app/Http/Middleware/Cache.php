<?php
namespace App\Http\Middleware;

class Cache 
{
    private function isCacheable($request) 
    {

    }
    public function handle($request, $next)
    {
        if(!$this->isCacheable($request)) return $next($request);

        die('cache');
    }
}