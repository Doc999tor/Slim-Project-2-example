<?php
namespace Lib\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class SchoolCtrl extends Controller {
    public function home(Request $request, Response $response): Response {
        $path = 'home';
        $courses = \Lib\Entities\Course::selectAll($this->db);
        $students = \Lib\Entities\Student::selectAll($this->db);

        $response = $response->withHeader('X-Robots-Tag', 'noindex, nofollow');
        return $this->view->render($response, "home.html", [
            'path' => $path,
            "sections" => ['courses', 'students'],
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