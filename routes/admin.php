<?php
use App\Http\Response;
use App\Controller\Admin;

$router->get('/admin', [    
    fn() => new Response(200,'Admin :*')
]);

$router->get('/admin/login', [    
    fn($request) => new Response(200, Admin\Login::renderContent($request))
]);

$router->post('/admin/login', [    
    fn($request) => new Response(200, Admin\Login::setLogin($request))
]);
