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

use Oziks\Provider\XHProfServiceProvider;

// XHPROF ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (PHP_SAPI !== 'cli' && extension_loaded('xhprof')) {
    $app['xhprof.location'] = ROOT_PATH . '/vendor/facebook/xhprof';
    $app['xhprof.host'] = $httpProtocol . '://' . $_SERVER['HTTP_HOST'] . '/xhprof/';
    $app->register(new XHProfServiceProvider());
}
