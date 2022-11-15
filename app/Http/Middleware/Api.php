<?php
namespace App\Http\Middleware;

class Api 
{
    public function handle($request, $next)
    {
        // Altera o contenttype
        $request->getRouter()->setContentType('application/json');
        return $next($request);
    }
}