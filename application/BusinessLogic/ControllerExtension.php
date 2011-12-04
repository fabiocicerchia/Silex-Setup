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

namespace BusinessLogic;

use Silex\Application;

/*

$app['url_generator']->generate('homepage')

$sql = "SELECT * FROM posts WHERE id = ?";
$post = $app['db']->fetchAssoc($sql, array((int) $id));
http://www.doctrine-project.org/docs/dbal/2.0/en/

$app['request']->server->get('PHP_AUTH_PW')

$response = new Response();
$response->headers->set(
    'WWW-Authenticate',
    sprintf('Basic realm="%s"', 'site_login')
);
$response->setStatusCode(401, 'Please sign in.');
return $response;

$app['session']->get('user')

http://silex-project.org/doc/extensions/validator.html

*/

/**
 * BusinessLogic\ControllerExtension
 *
 * @category Framework
 * @package  SilexSetup
 * @author   Fabio Cicerchia <info@fabiocicerchia.it>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/fabiocicerchia/Silex-Setup
 **/
class ControllerExtension extends BaseController
{
    // {{{ register
    /**
     * register
     *
     * @param Silex\Application $app The instance of Silex Application
     *
     * @access public
     * @return void
     */
    public function register(\Silex\Application $app)
    {
        $app['business_logic'] = $app->share(
            function() use ($app) {
                return new ControllerExtension($app);
            }
        );
    }
    // }}}

    // {{{ homepageExecute
    /**
     * homepageExecute
     *
     * @access public
     * @return void
     */
    public function homepageExecute()
    {
        $this->response->setCache(array('max_age' => 10, 's_maxage' => 10));
        $this->twig->loadTemplate('<h1>It works!</h1>');
    }
    // }}}
}
