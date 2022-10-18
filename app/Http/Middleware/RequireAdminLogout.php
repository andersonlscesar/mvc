<?php
namespace App\Http\Middleware;

use App\Session\Admin\Login as SessionLogin;

class RequireAdminLogout
{
    public function handle($request, $next)
    {
        if(SessionLogin::isLogged())
        {
            $request->getRouter()->redirect('admin');
        }

        return $next($request);
        
    }
}