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

namespace Controllers;

use Silex\Application;

/**
 * Controllers\Index
 *
 * @mount /
 *
 * @category Framework
 * @package  SilexSetup
 * @author   Fabio Cicerchia <info@fabiocicerchia.it>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/fabiocicerchia/Silex-Setup
 **/
class Index extends \App\Controllers\Base
{
    // {{{ actionIndex
    /**
     * actionIndex
     *
     * @route      /
     * @httpMethod GET
     *
     * @access     public
     * @param      \Silex\Application $app
     * @return     void
     */
    public function actionIndex(Application $app)
    {
        return $app['twig']->render('index.html.twig', array('content' => 'It works!'));
    }
    // }}}
}
