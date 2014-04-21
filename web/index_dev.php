<?php

// Autoloader
define('ROOT_PATH', __DIR__ . '/..');
require_once ROOT_PATH . '/vendor/autoload.php';

// Get Silex Application
$app = require_once ROOT_PATH . '/app/app.php';

// Include Business Logic
require_once ROOT_PATH . '/app/bootstrap.php';

return $app->run();
