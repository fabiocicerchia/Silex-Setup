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
    public function register(Application $app)
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
        return array('content' => 'It works!');
    }
    // }}}
}
