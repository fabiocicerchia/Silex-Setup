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

namespace App;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * BusinessLogic\LogicApplication
 *
 * @category Framework
 * @package  SilexSetup
 * @author   Fabio Cicerchia <info@fabiocicerchia.it>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/fabiocicerchia/Silex-Setup
 **/
class Logic
{
    // {{{ properties
    /**
     * @access protected
     * @var    Silex\Application
     */
    protected $app = null;
    // }}}

    // {{{ register
    /**
     * register
     *
     * @param Silex\Application &$app The instance of Silex Application
     *
     * @access public
     * @return void
     */
    public function __construct(\Silex\Application &$app)
    {
        $this->app = $app;
    }
    // }}}

    // {{{ bindRoutesAndLoad
    /**
     * bindRoutesAndLoad
     *
     * @param array $routes The routes array directives
     *
     * @access public
     * @return void
     */
    public function bindRoutesAndLoad(array $routes)
    {
        $app = &$this->app;

        $app->before(
            function () use ($app) {
                $app['business_logic']->preExecute();
            }
        );

        foreach ($routes as $name => $options) {
            if (!empty($options['url'])) {
                $this->setRoute($name, $options);
            }
        }

        $app->after(
            function () use ($app) {
                $app['business_logic']->postExecute();
            }
        );
    }
    // }}}

    // {{{ setRoute
    /**
     * setRoute
     *
     * @param string $name    The route name
     * @param array  $options The options relative to route
     *
     * @access protected
     * @return void
     */
    protected function setRoute($name, array $options)
    {
        $this->initValues($options);

        // Bind lambda function
        $funct = call_user_func(
            array($this->app, $options['method']),
            $options['url'],
            $this->getLambdaFunction()
        );
        $funct->bind($name);

        // Set route asserts
        foreach ($options['assert'] as $param => $pattern) {
            $funct->assert($param, $pattern);
        }

        // Set route values
        foreach ($options['value'] as $param => $pattern) {
            $funct->value($param, $pattern);
        }
    }
    // }}}

    // {{{ getLambdaFunction
    /**
     * getLambdaFunction
     *
     * @access protected
     * @return function
     */
    protected function getLambdaFunction()
    {
        $app = &$this->app;

        return (function () use ($app) {
            $route   = $app['request']->attributes->get('_route');
            $method  = preg_replace_callback(
                '/_([a-z])/',
                function ($matches) {
                    strtoupper($matches[0]);
                },
                $route
            );
            $method .= "Execute";

            $has_extenstion = extension_loaded('xhprof');
            $run_alternate  = !$app['debug'] && mt_rand(1, 10000) === 1;
            $profile = $has_extenstion && ($run_alternate || $app['debug']);
            if ($profile) {
                $xhprof_path = __DIR__ . '/../../lib/XHProf/xhprof_lib/utils/';
                include_once $xhprof_path . 'xhprof_lib.php';
                include_once $xhprof_path . 'xhprof_runs.php';
                xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
            }

            $layout    = $app['twig']->loadTemplate('main.html.twig');
            $variables = $app['business_logic']->$method();
            $app['response']->setContent($layout->render((array)$variables));

            if (false && $profile) {
                $profiler_namespace = $config['project']['name'];
                $xhprof_data = xhprof_disable();
                $xhprof_runs = new XHProfRuns_Default();

                $keys = array($_SERVER['REQUEST_METHOD'], $route, date('Ymd_His'));
                $run_id = implode('_', $keys);
                $xhprof_runs->save_run($xhprof_data, $profiler_namespace, $run_id);

                if ($app['debug']) {
                    $host = $_SERVER['HTTP_HOST'];
                    $url = 'http://' . $host . '/XHProf/?run=%s&source=%s';
                    $p_url = sprintf($url, $run_id, $profiler_namespace);
                    echo '<a href="'. $p_url .'" target="_blank">XHProf Output</a>';
                }
            }

            return $app['response'];
        });
    }
    // }}}

    // {{{ initValues
    /**
     * initValues
     *
     * @param array &$options The options of the route
     *
     * @access protected
     * @return array
     */
    protected function initValues(array &$options)
    {
        if (empty($options['method'])) {
            $options['method'] = 'get';
        }

        if (empty($options['assert'])) {
            $options['assert'] = array();
        }

        if (empty($options['value'])) {
            $options['value'] = array();
        }

        return $options;
    }
    // }}}
}
