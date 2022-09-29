<?php
require_once __DIR__.'/vendor/autoload.php';

use App\Http\Router;
use App\Utils\View;

define('URL', 'http://localhost/mvc');

View::loadGlobalVars([
    'URL' => URL
]);


$router = new Router(URL);

include_once __DIR__.'/routes/routes.php';

$router->run()->sendResponse();

