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

use Symfony\Component\HttpFoundation\Response;

/**
 * BusinessLogic\BaseController
 *
 * @category Framework
 * @package  SilexSetup
 * @author   Fabio Cicerchia <info@fabiocicerchia.it>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/fabiocicerchia/Silex-Setup
 * @abstract
 **/
abstract class BaseController implements \Silex\ServiceProviderInterface
{
    // {{{ properties
    /**
     * @static
     * @access public
     * @var    object
     */
    public static $instance = null;

    /**
     * @access protected
     * @var    string
     */
    protected $application = null;

    /**
     * @access protected
     * @var    string
     */
    protected $environment = null;

    /**
     * @access protected
     * @var    object
     */
    protected $request = null;

    /**
     * @access protected
     * @var    object
     */
    protected $response = null;

    /**
     * @static
     * @access protected
     * @var    object
     */
    protected $twig = null;
    // }}}

    // {{{ getInstance
    /**
     * getInstance
     *
     * @static
     * @access public
     * @return object
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    // }}}

    // {{{ register
    /**
     * register
     *
     * @param Silex\Application $app The instance of Silex Application
     *
     * @access public
     * @throw  Exception
     * @return void
     */
    public function register(\Silex\Application $app)
    {
        throw new Exception('This method needs to be redefined!');
    }
    // }}}

    // {{{ __construct
    /**
     * __construct
     *
     * @param Silex\Application &$app The instance of Silex Application
     *
     * @access public
     * @return void
     */
    public function __construct(\Silex\Application &$app)
    {
        $this->application = new LogicApplication($app);
        //$this->environment = $env;

        $this->request  = &$this->application->request;
        $this->response = new Response();
        $this->twig     = &$app['twig'];
    }
    // }}}

    // {{{ getInternalApplication
    /**
     * getInternalApplication
     *
     * @access public
     * @return string
     */
    public function getInternalApplication()
    {
        return $this->application;
    }
    // }}}

    // {{{ preExecute
    /**
     * preExecute
     *
     * @access public
     * @return void
     */
    public function preExecute()
    {
    }
    // }}

    // {{{ postExecute
    /**
     * postExecute
     *
     * @access public
     * @return void
     */
    public function postExecute()
    {
    }
    // }}}
}
