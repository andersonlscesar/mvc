<?php
use App\Http\Response;
use App\Controller\Admin;

$router->get('/admin', [    
    'middlewares' => ['required-admin-login'], 
    fn($request) => new Response(200, Admin\Home::renderContent($request))
]);

