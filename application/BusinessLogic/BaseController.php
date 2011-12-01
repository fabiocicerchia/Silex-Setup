<?php

namespace BusinessLogic;

abstract class BaseController implements \Silex\ServiceProviderInterface {
  public static $instance = null;
  protected $application  = null;
  protected $request      = null;
  protected $response     = null;
  protected $twig         = null;

  public static function getInstance() {
    if (empty(self::$instance)) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  public function register(\Silex\Application $app)
  {
    throw new Exception('This method needs to be redefined!');
  }

  public function __construct(\Silex\Application &$app) {
    $this->application = new LogicApplication($app);

    $this->request  = &$this->application->request;
    $this->response = &$this->application->response;
    //$this->twig     = &$this->application['twig'];
  }

  public function getInternalApplication() {
    return $this->application;
  }

  public function preExecute() { }

  public function postExecute() { }
}