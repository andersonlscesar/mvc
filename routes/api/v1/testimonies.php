<?php
use App\Http\Response;
use App\Controller\Api;


$router->get('/api/v1/testimonies', [
    'middlewares'   => ['api'],

    fn($request) => new Response(200, Api\Testimony::getTestimonies($request), 'application/json')
]);

$router->get('/api/v1/testimonies/{id}', [
    'middlewares'   => ['api'],
    fn($request, $id) => new Response(200, Api\Testimony::getTestimony($request, $id), 'application/json')
]);