<?php

require_once __DIR__ . '/../lib/Silex/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'        => __DIR__ . '/../lib/Silex/vendor',
    'Silex'          => __DIR__ . '/../lib/Silex/src',
    'SilexExtension' => __DIR__ . '/../lib/Silex-Extentions/src',
    'BusinessLogic'  => __DIR__ . '/../application',
));
$loader->registerPrefixes(array(
    'Pimple' => __DIR__ . '/../lib/Silex/vendor/pimple/lib',
    'Twig_'  => array(__DIR__ . '/../lib/Silex/vendor/twig/lib', __DIR__ . '/../../lib/Twig-extentions/lib/'),
));
$loader->register();
