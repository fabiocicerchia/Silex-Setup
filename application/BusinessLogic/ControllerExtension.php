<?php

namespace BusinessLogic;

use Silex\Application;

/*

$app['url_generator']->generate('homepage')

$sql = "SELECT * FROM posts WHERE id = ?";
$post = $app['db']->fetchAssoc($sql, array((int) $id));
http://www.doctrine-project.org/docs/dbal/2.0/en/

$app['request']->server->get('PHP_AUTH_PW')

$response = new Response();
$response->headers->set('WWW-Authenticate', sprintf('Basic realm="%s"', 'site_login'));
$response->setStatusCode(401, 'Please sign in.');
return $response;

$app['session']->get('user')

http://silex-project.org/doc/extensions/validator.html

*/
class ControllerExtension extends BaseController {
    public function register(\Silex\Application $app)
    {
        $app['business_logic'] = $app->share(function() use ($app) { return new \BusinessLogic\ControllerExtension($app); });
    }

    public function homepageExecute() {
        echo "<h1>It works!</h1>";
        exit;
    }
}
