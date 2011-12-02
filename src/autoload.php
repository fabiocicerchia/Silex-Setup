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

$symfony_path = __DIR__ . '/../lib/Silex/vendor/Symfony/';
require_once $symfony_path . 'Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(
    array(
        'Symfony'        => __DIR__ . '/../lib/Silex/vendor',
        'Silex'          => __DIR__ . '/../lib/Silex/src',
        'SilexExtension' => __DIR__ . '/../lib/Silex-Extentions/src',
        'BusinessLogic'  => __DIR__ . '/../application',
    )
);
$loader->registerPrefixes(
    array(
        'Pimple' => __DIR__ . '/../lib/Silex/vendor/pimple/lib',
        'Twig_'  => array(
            __DIR__ . '/../lib/Silex/vendor/twig/lib',
            __DIR__ . '/../../lib/Twig-extentions/lib/'
        ),
    )
);
$loader->register();
