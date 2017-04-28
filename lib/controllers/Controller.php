<?php
namespace Lib\Controllers;
use \Slim\Container as Container;

class Controller {
    protected $container;
    protected $view;
    protected $db;

    public function __construct(Container $container) {
        $this->container = $container;
        $this->view = $container->get('view');
        $this->db = $container->get('db');
    }
}