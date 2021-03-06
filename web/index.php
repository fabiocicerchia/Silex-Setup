<?php

// Autoloader
define('ROOT_PATH', __DIR__ . '/..');
require_once ROOT_PATH . '/vendor/autoload.php';

// Get Silex Application
$app = require_once ROOT_PATH . '/app/app.php';

// Include Business Logic
require_once ROOT_PATH . '/app/bootstrap.php';

if ($app['debug']) {
    return $app->run();
}

$app['http_cache']->run();
