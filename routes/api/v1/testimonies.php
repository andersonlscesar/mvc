<?php
use App\Http\Response;
use App\Controller\Api;

$router->get('/api/v1/testimonies', [
    'middlewares'   => ['api', 'cache'],
    fn($request) => new Response(200, Api\Testimony::getTestimonies($request), 'application/json')
]);

$router->get('/api/v1/testimonies/{id}', [
    'middlewares'   => ['api'],
    fn($request, $id) => new Response(200, Api\Testimony::getTestimony($request, $id), 'application/json')
]);

$router->post('/api/v1/testimonies', [
    'middlewares'   => ['api', 'user-basic-auth'],
    fn($request) => new Response(201, Api\Testimony::setNewTestimony($request), 'application/json')
]);

$router->put('/api/v1/testimonies/{id}', [
    'middlewares'   => ['api', 'user-basic-auth'],
    fn($request, $id) => new Response(200, Api\Testimony::setEditTestimony($request, $id), 'application/json')
]);

$router->delete('/api/v1/testimonies/{id}', [
    'middlewares'   => ['api', 'user-basic-auth'],
    fn($id) => new Response(200, Api\Testimony::setDeleteTestimony($id), 'application/json')
]);

// Rota de consulta do usuário atual

$router->get('/api/v1/jwt/me', [
    'middlewares'   => ['api', 'jwt-auth'],
    fn($request) => new Response(200, ['success' => true ], 'application/json')
]);