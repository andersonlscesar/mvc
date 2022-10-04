<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\Utils\View;
use App\Common\Environment;

Environment::load(__DIR__.'/../.env');


define('URL', getenv('URL'));

View::loadGlobalVars([
    'URL' => URL
]);