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

use Symfony\Component\ClassLoader\UniversalClassLoader;

define('ROOT_PATH',    __DIR__ . '/..');
define('SILEX_PATH',   ROOT_PATH . '/lib/Silex');
define('SYMFONY_PATH', SILEX_PATH . '/vendor/Symfony');

require_once SYMFONY_PATH . '/Component/ClassLoader/UniversalClassLoader.php';

$loader = new UniversalClassLoader();
$loader->registerNamespaces(
    array(
        'Symfony'        => array(
            SILEX_PATH . '/vendor',
            __DIR__ . '/../lib/'
        ),
        'Silex'          => SILEX_PATH . '/src',
        'SilexExtension' => ROOT_PATH . '/lib/Silex-Extentions/src',
        'BusinessLogic'  => ROOT_PATH . '/application',
    )
);

$loader->registerPrefixes(
    array(
        'Pimple' => SILEX_PATH . '/vendor/pimple/lib',
        'Twig_'  => array(
            SILEX_PATH . '/vendor/twig/lib',
            ROOT_PATH . '/lib/Twig-extentions/lib/'
        ),
    )
);

$loader->register();
