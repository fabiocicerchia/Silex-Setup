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

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Silex\ControllerProviderInterface;
use Silex\Application;
use App\Utils\DocBlockParser;
use App\Utils\Inflection;

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
abstract class Base implements ControllerProviderInterface
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

    /**
     * @access protected
     * @var    boolean
     */
    protected $isAjax = false;
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
    public function __construct(Application &$app)
    {
        $this->application = $app;
        $this->response    = $app['response'];
        $this->twig        = $app['twig'];
        $this->isAjax      = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                             && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    // }}}

    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];

        $refClass = new \ReflectionClass($this);
        $methods  = $refClass->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            $methodName = $method->getName();
            if (preg_match('/action.+$/', $methodName) > 0) {
                $this->registerMethod($methodName, $this, $controller);
            }
        }

        return $controller;
    }

    protected function registerMethod($methodName, $class, &$controller)
    {
        $docBlock = DocBlockParser::parseMethod($class, $methodName);
        if (!isset($docBlock['route'])) {
            return;
        }

        $route      = $docBlock['route'];
        $httpMethod = strtolower($docBlock['httpMethod']);
        $name       = substr($methodName, 6);

        $funct = $controller->$httpMethod(
            $route,
            array($this, $methodName)
        )->bind(Inflection::tableize($name));

        // Set route asserts
        if (isset($docBlock['assert'])) {
            foreach ($docBlock['assert'] as $item) {
                list($param, $pattern) = explode(' ', $item);
                $funct->assert($param, $pattern);
            }
        }

        // Set route values
        if (isset($docBlock['value'])) {
            foreach ($docBlock['value'] as $item) {
                list($param, $value) = explode(' ', $item);
                $funct->value($param, $value);
            }
        }

        //if (extension_loaded('xhprof')) {
        //    $app['monolog']->addInfo('Profiling started.');
        //    $app['xhprof']->start();
        //}

        //$app['monolog']->addInfo('Pre Execute.');
        //$app['business_logic']->preExecute();

        //$app['monolog']->addInfo(sprintf('Template Name: "%s".', $tplName . '.html.twig'));
        //$layout = $app['twig']->loadTemplate($tplName . '.html.twig');

        //$app['monolog']->addInfo(sprintf('Executing "%s".', $method));
        //$variables = $app['business_logic']->$method();

        //$app['response']->setContent($layout->render((array) $variables));
        ////$app['response']->send();

        //$app['monolog']->addInfo('Post Execute.');
        //$app['business_logic']->postExecute();

        //if (extension_loaded('xhprof')) {
        //    $app['xhprof']->end();
        //    $app['monolog']->addInfo('Profiling finished.');
        //}

        //return $app['response'];
    }

    public function boot(Application $app)
    {
    }

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
    // }}}

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
