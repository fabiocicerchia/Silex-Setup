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

use Silex\Provider\TwigServiceProvider;

// TWIG ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if ($config['twig']['options']['cache'] === true) {
    $config['twig']['options']['cache'] = ROOT_PATH . '/tmp/cache/twig';
}

$app->register(
    new TwigServiceProvider(),
    array(
        'twig.options'  => $config['twig']['options'],
        'twig.path'     => array(
            ROOT_PATH . '/app/layouts',
            ROOT_PATH . '/app/views/partials',
            ROOT_PATH . '/app/views',
        )
    )
);

$app['twig'] = $app->share(
    $app->extend(
        'twig',
        function ($twig, $app) {
            // add custom globals, filters, tags, ...
            return $twig;
        }
    )
);
