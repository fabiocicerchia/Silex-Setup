<?php

namespace BusinessLogic;

class LogicApplication {
  protected $app = null;

  public function __construct(\Silex\Application &$app) {
    $this->app = $app;
  }

  public function bindRoutes($routes) {
    $app = $this->app;

    $app->before(function() use ($app) { $app['blogic']->preExecute(); });

    foreach($routes as $name => $options) {
      if (!empty($options['url'])) {
        $this->setRoute($name, $options);
      }
    }

    $app->after(function() use ($app) { $app['blogic']->postExecute(); });
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

      $app['blogic']->$method();
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