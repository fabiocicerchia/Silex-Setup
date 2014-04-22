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

use Silex\Provider\WebProfilerServiceProvider;

// WEB PROFILER ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (PHP_SAPI !== 'cli') {
    $app['security.authentication_providers'] = array();
    $app->register(
        new WebProfilerServiceProvider(),
        array(
            'profiler.cache_dir'    => ROOT_PATH . '/tmp/cache/profiler',
            'profiler.mount_prefix' => '/_profiler'
        )
    );
}
