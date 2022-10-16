<?php
include_once __DIR__.'/includes/config.php';

use App\Http\Router;

$router = new Router(URL);

include_once __DIR__.'/routes/routes.php';
include_once __DIR__.'/routes/admin.php';

$router->run()->sendResponse();


