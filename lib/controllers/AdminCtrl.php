<?php
namespace Lib\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class AdminCtrl extends Controller {
    public function editForm(Request $request, Response $response, $args) {
        $id = (int)filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $admin = \Lib\Entities\Admin::selectOne($this->db, $id);
        return $this->view->render($response, "admins/edit.html", [
            "admin" => $admin,
        ]);
    }
    public function add(Request $request, Response $response) {
        return $this->view->render($response, "form.html", [
            "entity" => ["id" => "", "name" => "", "img" => ""]
        ]);
    }
}