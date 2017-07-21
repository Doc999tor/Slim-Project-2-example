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

    protected function getLoggedInAdmin() {
    	$session = new \RKA\Session();
        if (isset($session->name)) {
            return [
                "name" => $session->name,
                "role" => $session->role,
                "img" => $session->img
            ];
    	} else {
    	    throw new Exception("Session is empty", 1);
            return false;
    	}

    }
}