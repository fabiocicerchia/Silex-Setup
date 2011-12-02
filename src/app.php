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

// Include Business Logic
require_once __DIR__ . '/bootstrap.php';

// Use other namespaces
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

$silex_path = __DIR__ . '/../lib/Silex/';

// Registering Extensions
$app->register(new BusinessLogic\ControllerExtension($app));
$app->register(new UrlGeneratorServiceProvider());
$app->register(
    new DoctrineServiceProvider(),
    array(
        'db.options'           => $config['services']['doctrine'],
        'db.dbal.class_path'   => $silex_path . 'vendor/doctrine-dbal/lib',
        'db.common.class_path' => $silex_path . 'vendor/doctrine-common/lib'
    )
);

// Bind business logic to application
$app['business_logic']->getInternalApplication()->bindRoutes($config['routes']);

// Return application
return $app;
