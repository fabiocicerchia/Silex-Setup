<?php

// Autoload
require_once __DIR__ . '/../src/autoload.php';

// Get Silex Application
$app = require_once __DIR__ . '/../src/app.php';

// Include Business Logic
require_once __DIR__ . '/../src/bootstrap.php';

if ($app['debug']) {
    return $app->run();
}

$app['http_cache']->run();
