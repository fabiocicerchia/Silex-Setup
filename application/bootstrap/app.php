<?php

// Include Business Logic
require_once __DIR__ . '/bootstrap.php';

// Use other namespaces
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

// Registering Extensions
$app->register(new BusinessLogic\ControllerExtension($app));
$app->register(new UrlGeneratorServiceProvider());
$app->register(new DoctrineServiceProvider(), array(
  'db.options'           => $config['services']['doctrine'],
  'db.dbal.class_path'   => __DIR__ . '/../../lib/Silex/vendor/doctrine-dbal/lib',
  'db.common.class_path' => __DIR__ . '/../../lib/Silex/vendor/doctrine-common/lib'
));

// Bind business logic to application
$app['blogic']->getInternalApplication()->bindRoutes($config['routes']);

// Return application
return $app;