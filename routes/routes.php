<?php
use App\Http\Response;
use App\Controller\Pages;

$router->get('/', [
    
    fn() => new Response(200, Pages\Home::renderContent())
]);

$router->get('/sobre', [
    fn() => new Response(200, Pages\Sobre::renderContent())
]);


$router->get('/depoimentos', [
    fn($request) => new Response(200, Pages\Depoimento::renderContent($request))
]);

// Rota para cadastro de dados

$router->post('/depoimentos', [
    fn($request) => new Response(200, Pages\Depoimento::insertTestimony($request))
]);

