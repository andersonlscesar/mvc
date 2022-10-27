<?php
use App\Http\Response;
use App\Controller\Admin;

$router->get('/admin/login', [   
    'middlewares' => ['required-admin-logout'], 
    fn($request) => new Response(200, Admin\Login::renderContent($request))
]);


$router->post('/admin/login', [    
    'middlewares' => ['required-admin-logout'], 
    fn($request) => new Response(200, Admin\Login::setLogin($request))
]);


$router->get('/admin/logout', [    
    'middlewares' => ['required-admin-login'], 
    fn($request) => new Response(200,Admin\Login::setLogout($request))
]);
