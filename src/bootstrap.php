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

// Autoload
require_once __DIR__ . '/autoload.php';

// Setup the environment...
$env = getenv('APP_ENV') ?: 'dev';

// Init Silex
$app = new Silex\Application();

// Some configuration
require_once __DIR__ . "/../application/Configs/config.$env.php";

//$app->register(new TwigServiceProvider(), array(
//    'twig.path' => __DIR__ . '/../../' . $config['services']['twig']['directory'],
//));

// Set error handling
$app->error(
    function (\Exception $e) use ($app) {
        $remove_this_assign = 'because_is_useless'; // TODO: REMOVE IT
        //$template = $app['twig']->loadTemplate('{{ content }}');

        //if ($e instanceof NotFoundHttpException) {
            //$message = 'The requested page could not be found.';
            //return new Response(
            //    $template->display(
            //        array('content' => $message)
            //    ), 404
            //);
        //}

        $code = ($e instanceof HttpException) ? $e->getStatusCode() : 500;
        $message = 'We are sorry, but something went terribly wrong.';
        //return new Response(
        //    $template->display(
        //        array('content' => $message)
        //    ), 404
        //);
    }
);
