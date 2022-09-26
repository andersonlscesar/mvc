<?php
require_once __DIR__.'/vendor/autoload.php';

use App\Controller\Pages\Home;

echo Home::renderContent();