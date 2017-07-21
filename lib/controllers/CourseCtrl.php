<?php
namespace Lib\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class CourseCtrl extends Controller {
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

    public function editForm(Request $request, Response $response, $args) {
        $id = (int)filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $course = \Lib\Entities\Course::selectOne($this->db, $id);
        $students_count = \Lib\Entities\Student::countByCourse($this->db, $id);
        return $this->view->render($response, "courses/edit.html", [
            "course" => $course,
            "students_count" => $students_count,
            "action" => "edit",
        ]);
    }
    public function addForm(Request $request, Response $response) {
        return $this->view->render($response, "courses/edit.html", [
            "course" => ["id" => "", "name" => "", "img" => ""],
            "action" => "add",
        ]);
    }

    public function add(Request $request, Response $response) {
        $details = $request->getParsedBody();
        $files = $request->getUploadedFiles()['image'];

        $name = filter_var($details['name'], FILTER_SANITIZE_STRING) ?? null;
        $description = filter_var($details['description'], FILTER_SANITIZE_STRING) ?? null;

        $new_course = new \Lib\Entities\Course(null, $name, $description);
        $new_course->save($this->db, $files);

        return $response->withStatus(201);
    }
    public function edit(Request $request, Response $response, $args) {
        $details = $request->getParsedBody();
        $files = $request->getUploadedFiles()['image'];

        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $name = filter_var($details['name'], FILTER_SANITIZE_STRING) ?? null;
        $description = filter_var($details['description'], FILTER_SANITIZE_STRING) ?? null;

        $new_course = new \Lib\Entities\Course($id, $name, $description);
        $new_course->edit($this->db, $files);

        return $response->withStatus(200);
    }
}