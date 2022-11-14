<?php
use App\Http\Response;
use App\Controller\Admin;

$router->get('/admin/usuarios', [    
    'middlewares' => ['required-admin-login'], 
    fn($request) => new Response(200, Admin\Usuario::renderContent($request))
]);

//Rota de cadastro de novo usuario

$router->get('/admin/usuarios/new', [    
    'middlewares' => ['required-admin-login'], 
    fn($request) => new Response(200, Admin\Usuario::getNewUser($request))
]);

$router->post('/admin/usuarios/new', [    
    'middlewares' => ['required-admin-login'], 
    fn($request) => new Response(200, Admin\Usuario::setNewUser($request))
]);

// Rota de edição
$router->get('/admin/usuarios/{id}/edit', [    
    'middlewares' => ['required-admin-login'], 
    fn($request, $id) => new Response(200, Admin\Usuario::getEditUser($request, $id))
]);


$router->post('/admin/usuarios/{id}/edit', [    
    'middlewares' => ['required-admin-login'], 
    fn($request, $id) => new Response(200, Admin\Usuario::setEditUser($request, $id))
]);

//exclusão

$router->get('/admin/usuarios/{id}/delete', [    
    'middlewares' => ['required-admin-login'], 
    fn($request, $id) => new Response(200, Admin\Usuario::getDeleteUser($request, $id))
]);

$router->post('/admin/usuarios/{id}/delete', [    
    'middlewares' => ['required-admin-login'], 
    fn($request, $id) => new Response(200, Admin\Usuario::setDeleteUser($request, $id))
]);


