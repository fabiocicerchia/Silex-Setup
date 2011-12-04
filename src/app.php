<?php
/**
 * SilexSetup
 *
 * PHP version 5
 *
 * @category Framework
 * @package  SilexSetup
 * @author   Fabio Cicerchia <info@fabiocicerchia.it>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/fabiocicerchia/Silex-Setup
 */

// Use other namespaces
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SymfonyBridgesServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app = new Silex\Application();

// Registering Extensions
$app->register(new HttpCacheServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new SymfonyBridgesServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new UrlGeneratorServiceProvider());

// Return application
return $app;
