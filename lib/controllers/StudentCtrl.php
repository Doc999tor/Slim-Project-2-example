<?php
namespace Lib\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class StudentCtrl extends Controller {
    public function editForm(Request $request, Response $response, $args) {
        $id = (int)filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $student = \Lib\Entities\Student::selectOne($this->db, $id);
        return $this->view->render($response, "students/edit.html", [
            "student" => $student,
        ]);
    }
    public function add(Request $request, Response $response) {
        return $this->view->render($response, "students/edit.html", [
            "student" => ["id" => "", "name" => "", "img" => ""]
        ]);
    }
    public function show(Request $request, Response $response, $args) {
        $path = 'students';
        $id = (int)filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $student = \Lib\Entities\Student::selectOne($this->db, $id);
        $course = \Lib\Entities\Course::selectOne($this->db, $student->id);

        return $this->view->render($response, "{$path}/show.html", [
            "path" => $path,
            "student" => $student,
            "course"  => $course,
        ]);
    }
}