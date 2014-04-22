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

use App\Utils\DocBlockParser;

//$app['security.encoder.digest'] = $app->share(function ($app) {
//    return new PlaintextPasswordEncoder();
//});

//$app->register(new TranslationServiceProvider());
//$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
//    $translator->addLoader('yaml', new YamlFileLoader());
//
//    $translator->addResource('yaml', __DIR__.'/../resources/locales/fr.yml', 'fr');
//
//    return $translator;
//}));

// REGISTER SERVICES ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$bootstrapFiles = glob(ROOT_PATH . '/app/bootstrap/*.php');
sort($bootstrapFiles);
foreach ($bootstrapFiles as $file) {
    include_once $file;
}

// Boot your application
$app->boot();

// MOUNT CONTROLLERS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$controllerFiles = glob(ROOT_PATH . '/app/Controllers/*.php');
foreach ($controllerFiles as $file) {
    $className = 'Controllers\\' . substr(basename($file), 0, -4);
    $docBlock  = DocBlockParser::parseClass($className);
    if (!isset($docBlock['mount'])) {
        continue;
    }

    $app->mount($docBlock['mount'], new $className($app));
}

// ERRORS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Set error handling
//$app->error(
//    function (\Exception $e, $code) use ($app) {
//        if ($app['debug']) {
//            return;
//        }
//
//        $page = 404 == $code ? '404.html.twig' : '500.html.twig';
//        return new Response($app['twig']->render($page, array('code' => $code)), $code);
//    }
//);
