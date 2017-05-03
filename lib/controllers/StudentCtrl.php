<?php
namespace Lib\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class StudentCtrl extends Controller {
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

    public function editForm(Request $request, Response $response, $args) {
        $id = (int)filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $student = \Lib\Entities\Student::selectOne($this->db, $id);
        $courses = \Lib\Entities\Course::selectAll($this->db);

        return $this->view->render($response, "students/edit.html", [
            "student" => $student,
            "courses" => $courses,
        ]);
    }
    public function addForm(Request $request, Response $response) {
        $courses = \Lib\Entities\Course::selectAll($this->db);
        return $this->view->render($response, "students/edit.html", [
            "student" => ["id" => "", "name" => "", "img" => ""],
            "courses" => $courses,
        ]);
    }

    public function add(Request $request, Response $response) {
        $details = $request->getParsedBody();
        $files = $request->getUploadedFiles()['image'];

        $name = filter_var($details['name'], FILTER_SANITIZE_STRING) ?? null;
        $course_id = filter_var($details['course'], FILTER_SANITIZE_NUMBER_INT) ?? null;

        $student = new \Lib\Entities\Student(null, $name, $course_id);
        $student->save($this->db, $files);

        return $response->withStatus(201);
    }
    public function edit(Request $request, Response $response, $args) {
        $details = $request->getParsedBody();
        $files = $request->getUploadedFiles()['image'];

        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $name = filter_var($details['name'], FILTER_SANITIZE_STRING) ?? null;

        $student = new \Lib\Entities\Student($id, $name);
        $student->edit($this->db, $files);

        return $response->withStatus(200);
    }
}