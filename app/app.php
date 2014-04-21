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

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

// Init the Silex application
$app = new Application();

// CUSTOM CONFIGURATION ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$httpProtocol = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') ? 'https' : 'http';

// ENVIRONMENT ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Setup the environment
$env = getenv('APP_ENV') ?: 'dev';

// ERROR REPORTING ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
error_reporting(0);
if ($env == 'dev') {
    error_reporting(E_ALL | E_STRICT);
}

// CONFIGURATION ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Some configuration
$config = Yaml::parse(ROOT_PATH . '/app/configs/config.yml');
$config = !isset($config[$env])
          ? array_merge_recursive((array) $config[$env], $config['all'])
          : $config['all'];

// TRANSLATIONS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$translator_messages = array();
foreach ($config['translator']['messages'] as $lang => $file) {
    $translator_messages[$lang] = ROOT_PATH . '/app/translations/' . $file;
}

// MISCELLANEOUOS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$app['cache.path']             = ROOT_PATH . '/tmp/cache/app';
$app['debug']                  = (bool)$config['debug'];
$app['env']                    = $env;
$app['http_cache.cache_dir']   = $app['cache.path'] . '/http';
$app['locale']                 = $config['locale']['default'];
$app['response']               = new Response();
$app['session.default_locale'] = $app['locale'];
$app['translator.messages']    = $translator_messages;

// Return application
return $app;
