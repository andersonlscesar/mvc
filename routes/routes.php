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
    fn() => new Response(200, Pages\Depoimento::renderContent())
]);

// Rota para cadastro de dados
