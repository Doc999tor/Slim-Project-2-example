<?php
namespace Lib\Controllers;

use \Slim\Container as Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class SchoolCtrl {
    private $container;
    private $view;
    private $db;

    public function __construct(Container $container) {
        $this->container = $container;
        $this->view = $container->get('view');
        $this->db = $container->get('db');
    }
    public function home(Request $request, Response $response): Response {
        $path = 'home';
        $courses = \Lib\Entities\Course::selectAll($this->db);
        $students = \Lib\Entities\Student::selectAll($this->db);

        $response = $response->withHeader('X-Robots-Tag', 'noindex, nofollow');
        return $this->view->render($response, "{$path}.html", [
            'path' => $path,
            'data' => [
                "courses" => [
                    "title" => "courses",
                    "arr" => $courses,
                ],
                "students" => [
                    "title" => "students",
                    "arr" => $students,
                ],
            ],
            "admin" => [
                "name" => "war",
                "role" => "sales",
                "img" => "war.jpg"
            ],
        ]);
    }
}