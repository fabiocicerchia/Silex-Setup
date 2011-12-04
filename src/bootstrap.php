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

use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

// Setup the environment...
$env = getenv('APP_ENV') ?: 'dev';

// Some configuration
$config = Yaml::parse(__DIR__ . "/../application/Configs/config.yml");
$config = !isset($config[$env])
          ? array_merge_recursive((array)$config[$env], $config['all'])
          : $config['all'];

$translator_messages = array();
foreach ($config['translator']['messages'] as $lang => $file) {
    $translator_messages[$lang] = __DIR__ . '/../application/Locales/' . $file;
}
$app['translator.messages']    = $translator_messages;
$app['debug']                  = $config['debug'];
$app['locale']                 = $config['locale']['default'];
$app['session.default_locale'] = $app['locale'];
$app['cache.path']             = __DIR__ . '/../tmp/cache/app';
$app['http_cache.cache_dir']   = $app['cache.path'] . '/http';

$app->register(
    new TranslationServiceProvider(),
    array('locale_fallback' => $config['locale']['default'])
);
$app['translator.loader'] = new YamlFileLoader();

if ($config['twig']['options']['cache'] === true) {
    $config['twig']['options']['cache'] = __DIR__ . '/../tmp/cache/twig';
}
$app->register(
    new TwigServiceProvider(),
    array(
        'twig.options'  => $config['twig']['options'],
        'twig.path'     => array(
            __DIR__ . '/../application/Views/common',
            __DIR__ . '/../application/Views',
        )
    )
);

//$oldTwigConfiguration = isset($app['twig.configure'])
//                        ? $app['twig.configure']
//                        : function(){};
//$app['twig.configure'] = $app->protect(
//function($twig) use ($oldTwigConfiguration) {
//    $oldTwigConfiguration($twig);
//    $twig->addExtension(new Twig_Extensions_Extension_Debug());
//});

$silex_path = __DIR__ . '/../lib/Silex/vendor/silex/';

$app->register(
    new DoctrineServiceProvider(),
    array(
        'db.options'           => $config['database']['options'],
        'db.dbal.class_path'   => $silex_path . 'vendor/doctrine-dbal/lib',
        'db.common.class_path' => $silex_path . 'vendor/doctrine-common/lib',
    )
);

$app->register(new BusinessLogic\ControllerExtension($app));

// Bind business logic to application
$app['business_logic']->getInternalApplication()->bindRoutes($config['routes']);

// Set error handling
$app->error(
    function (\Exception $e) use ($app) {
        $code = ($e instanceof HttpException) ? $e->getStatusCode() : 500;
        $message = $e instanceof NotFoundHttpException
                   ? 'The requested page could not be found.'
                   : 'We are sorry, but something went terribly wrong.';
        return new Response(
            $app['twig']->render(
                'layout.html.twig',
                array('content' => $message)
            ),
            $code
        );
    }
);
