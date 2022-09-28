<?php
require_once __DIR__.'/vendor/autoload.php';

use App\Controller\Pages\Home;
use App\Http\Request;
use App\Http\Response;
use App\Http\Router;

define('URL', 'http://localhost/mvc');

$router = new Router(URL);
$router->get('/', [
    fn() => new Response(200, Home::renderContent())
]);

$router->run()->sendResponse();

echo Home::renderContent();