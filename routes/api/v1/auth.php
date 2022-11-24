<?php
use App\Http\Response;
use App\Controller\Api;


$router->post('/api/v1/auth', [
    'middlewares'   => ['api'],

    fn($request) => new Response(201, Api\Auth::generateToken($request), 'application/json')
]);