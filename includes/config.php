<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\Utils\View;
use App\Common\Environment;
use App\Http\Middleware\Queue;

Environment::load(__DIR__.'/../.env');


define('URL', getenv('URL'));

View::loadGlobalVars([
    'URL' => URL
]);

// Define o mapeamento de middlewares

Queue::setMap([
    'maintenance'   => App\Http\Middleware\Maintenance::class
]);

// Define os middlewares que serão carregados em todas as rotas

Queue::setDefault([
    'maintenance'
]);