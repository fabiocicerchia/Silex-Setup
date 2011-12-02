<?php

namespace BusinessLogic;

class LogicApplication {
    protected $app = null;

    public function __construct(\Silex\Application &$app) {
        $this->app = $app;
    }

    public function bindRoutes($routes) {
        $app = $this->app;

        $app->before(function() use ($app) { $app['business_logic']->preExecute(); });

        foreach($routes as $name => $options) {
            if (!empty($options['url'])) {
                $this->setRoute($name, $options);
            }
        }

        $app->after(function() use ($app) { $app['business_logic']->postExecute(); });
    }

    protected function setRoute($name, $options) {
        $this->initValues($options);

        // Bind lambda function
        $funct = call_user_func(array($this->app, $options['method']), $options['url'], $this->getLambdaFunction());
        $funct->bind($name);

        // Set route asserts
        foreach($options['assert'] as $param => $pattern) {
            $funct->assert($param, $pattern);
        }

        // Set route values
        foreach($options['value'] as $param => $pattern) {
            $funct->value($param, $pattern);
        }
    }

    protected function getLambdaFunction() {
        $app = $this->app;

        return (function() use ($app) {
            $route   = $app['request']->attributes->get('_route');
            $method  = preg_replace('/_([a-z])/e', 'strtoupper("\1")', $route);
            $method .= "Execute";

            $profile = (mt_rand(1, 10000) === 1) && extension_loaded('xhprof'); // TODO: IN DEV MAYBE LOG EACH TIME...
            if ($profile) {
                include_once __DIR__ . '/../../lib/XHProf/xhprof_lib/utils/xhprof_lib.php';
                include_once __DIR__ . '/../../lib/XHProf/xhprof_lib/utils/xhprof_runs.php';
                xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
            }

            $app['business_logic']->$method();

            if ($profile) {
                $profiler_namespace = 'myapp';  // namespace for your application // TODO: ADD THE CORRECT NAME FROM CONFIG
                $xhprof_data = xhprof_disable();
                $xhprof_runs = new XHProfRuns_Default();

                $run_id = implode('_', array($_SERVER['REQUEST_METHOD'], $route, date('Ymd_His')));
                $xhprof_runs->save_run($xhprof_data, $profiler_namespace, $run_id);
             
                // url to the XHProf UI libraries (change the host name and path)
                $profiler_url = sprintf('http://myhost.com/xhprof/xhprof_html/index.php?run=%s&source=%s', $run_id, $profiler_namespace); // TODO: ADD ALIAS TO VHOST
                echo '<a href="'. $profiler_url .'" target="_blank">Profiler output</a>';
            }
        });
    }

    protected function initValues(&$options) {
        if (!is_array($options)) {
            $options = array();
        }

        $options['method'] = !empty($options['method']) ? $options['method'] : 'get';
        $options['assert'] = !empty($options['assert']) ? $options['assert'] : array();
        $options['value']  = !empty($options['value']) ? $options['value'] : array();

        return $options;
    }
}
