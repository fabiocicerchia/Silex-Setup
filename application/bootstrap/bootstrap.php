<?php

// Autoload
require_once __DIR__ . '/autoload.php';

// Setup the environment...
$env = getenv('APP_ENV') ?: 'dev';

// Init Silex
$app = new Silex\Application();

// Some configuration
require_once __DIR__ . "/../configs/config.$env.php";

//$app->register(new TwigServiceProvider(), array(
//    'twig.path'       => __DIR__ . '/../../' . $config['services']['twig']['directory'],
//));

// Set error handling
$app->error(function (\Exception $e) use ($app) {
  //$template = $app['twig']->loadTemplate('{{ content }}');

  if ($e instanceof NotFoundHttpException) {
    //return new Response($template->display(array('content' => 'The requested page could not be found.')), 404);
  }

  $code = ($e instanceof HttpException) ? $e->getStatusCode() : 500;
  //return new Response($template->display(array('content' => 'We are sorry, but something went terribly wrong.')), 404);
});