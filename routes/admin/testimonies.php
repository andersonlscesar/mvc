<?php
use App\Http\Response;
use App\Controller\Admin;

$router->get('/admin/depoimentos', [    
    'middlewares' => ['required-admin-login'], 
    fn($request) => new Response(200, Admin\Testimony::renderContent($request))
]);

//Rota de cadastro de novo depoimento

$router->get('/admin/depoimentos/new', [    
    'middlewares' => ['required-admin-login'], 
    fn($request) => new Response(200, Admin\Testimony::getNewTestimony($request))
]);

$router->post('/admin/depoimentos/new', [    
    'middlewares' => ['required-admin-login'], 
    fn($request) => new Response(200, Admin\Testimony::setNewTestimony($request))
]);

// Rota de edição
$router->get('/admin/depoimentos/{id}/edit', [    
    'middlewares' => ['required-admin-login'], 
    fn($request, $id) => new Response(200, Admin\Testimony::getEditTestimony($request, $id))
]);


$router->post('/admin/depoimentos/{id}/edit', [    
    'middlewares' => ['required-admin-login'], 
    fn($request, $id) => new Response(200, Admin\Testimony::setEditTestimony($request, $id))
]);

//exclusão

$router->get('/admin/depoimentos/{id}/delete', [    
    'middlewares' => ['required-admin-login'], 
    fn($request, $id) => new Response(200, Admin\Testimony::getDeleteTestimony($request, $id))
]);

$router->post('/admin/depoimentos/{id}/delete', [    
    'middlewares' => ['required-admin-login'], 
    fn($request, $id) => new Response(200, Admin\Testimony::setDeleteTestimony($request, $id))
]);


