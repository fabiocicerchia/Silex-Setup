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

use Silex\Provider\MonologServiceProvider;

// MONOLOG ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$app->register(
    new MonologServiceProvider(),
    array(
        'monolog.logfile' => ROOT_PATH . '/tmp/logs/' . $app['env'] . '.log',
    )
);
