<?php
use App\Http\Response;
use App\Controller\Api;


$router->get('/api/v1', [
    'middlewares'   => ['api'],

    fn($request) => new Response(200, Api\Api::getDetails($request), 'application/json')
]);