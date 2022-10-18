<?php
namespace App\Http\Middleware;

use App\Session\Admin\Login as SessionLogin;

class RequireAdminLogin
{
    public function handle($request, $next)
    {
        if(!SessionLogin::isLogged())
        {
            $request->getRouter()->redirect('admin/login');
        }

        return $next($request);
        
    }
}
