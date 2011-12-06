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

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;

// Setup the environment
$env = getenv('APP_ENV') ?: 'dev';

error_reporting(0);
if ($env == 'dev') {
    error_reporting(E_ALL | E_STRICT);
}

// Some configuration
$config = Yaml::parse(ROOT_PATH . '/application/Configs/config.yml');
$config = !isset($config[$env])
          ? array_merge_recursive((array)$config[$env], $config['all'])
          : $config['all'];

$translator_messages = array();
foreach ($config['translator']['messages'] as $lang => $file) {
    $translator_messages[$lang] = ROOT_PATH . '/application/Locales/' . $file;
}
$app['env']                    = $env;
$app['translator.messages']    = $translator_messages;
$app['debug']                  = (bool)$config['debug'];
$app['locale']                 = $config['locale']['default'];
$app['session.default_locale'] = $app['locale'];
$app['cache.path']             = ROOT_PATH . '/tmp/cache/app';
$app['http_cache.cache_dir']   = $app['cache.path'] . '/http';
$app['response']               = new Response();

$app->register(
    new TranslationServiceProvider(),
    array('locale_fallback' => $config['locale']['default'])
);
$app['translator.loader'] = new YamlFileLoader();

if ($config['twig']['options']['cache'] === true) {
    $config['twig']['options']['cache'] = ROOT_PATH . '/tmp/cache/twig';
}
$app->register(
    new TwigServiceProvider(),
    array(
        'twig.options'  => $config['twig']['options'],
        'twig.path'     => array(
            ROOT_PATH . '/application/Views/common',
            ROOT_PATH . '/application/Views',
        )
    )
);

$app->register(
    new DoctrineServiceProvider(),
    array(
        'db.options'           => $config['database']['options'],
        'db.dbal.class_path'   => SILEX_PATH . '/vendor/doctrine-dbal/lib',
        'db.common.class_path' => SILEX_PATH . '/vendor/doctrine-common/lib',
    )
);

// Register the Business Logic
$app->register(new BusinessLogic\ControllerExtension($app));

// Bind business logic to application
$business_logic = $app['business_logic']->getInternalApplication();
$business_logic->bindRoutesAndLoad($config['routes']);

// Set error handling
$app->error(
    function (\Exception $e) use ($app) {
        $code = ($e instanceof HttpException) ? $e->getStatusCode() : 500;
        $message = $e instanceof NotFoundHttpException
                   ? 'The requested page could not be found.'
                   : 'We are sorry, but something went terribly wrong.';

        $message .= $app['debug'] ? (' ' . $e->getMessage()) : '';

        $layout   = 'layout.html.twig';
        $template = $app['twig']->render($layout, array('content' => $message));
        return new Response($template, $code);
    }
);
