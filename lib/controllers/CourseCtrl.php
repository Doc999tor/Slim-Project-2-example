<?php
namespace Lib\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class CourseCtrl extends Controller {
    public function editForm(Request $request, Response $response, $args) {
        $id = (int)filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $course = \Lib\Entities\Course::selectOne($this->db, $id);
        $students_count = \Lib\Entities\Student::countByCourse($this->db, $id);
        return $this->view->render($response, "courses/edit.html", [
            "course" => $course,
            "students_count" => $students_count
        ]);
    }
    public function addForm(Request $request, Response $response) {
        return $this->view->render($response, "courses/edit.html", [
            "course" => ["id" => "", "name" => "", "img" => ""]
        ]);
    }
    public function show(Request $request, Response $response, $args) {
        $path = 'courses';
        $id = (int)filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $course = \Lib\Entities\Course::selectOne($this->db, $id);
        $students = \Lib\Entities\Student::selectByCourse($this->db, $id);

        return $this->view->render($response, "{$path}/show.html", [
            "path" => $path,
            "course" => $course,
            "students" => $students,
        ]);
    }

    public function add(Request $request, Response $response) {
        return $response;
    }
}