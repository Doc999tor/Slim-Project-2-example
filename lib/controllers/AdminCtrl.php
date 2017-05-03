<?php
namespace Lib\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class AdminCtrl extends Controller {
    public function editForm(Request $request, Response $response, $args) {
        $id = (int)filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $admin = \Lib\Entities\Admin::selectOne($this->db, $id);
        $roles = \Lib\Entities\Admin::getRolesForAdminCreation($this->db);
        return $this->view->render($response, "admins/edit.html", [
            "admin" => $admin,
            "roles" => $roles,
        ]);
    }
    public function addForm(Request $request, Response $response) {
        $roles = \Lib\Entities\Admin::getRolesForAdminCreation($this->db);

        return $this->view->render($response, "admins/edit.html", [
            "admin" => ["id" => "", "name" => "", "img" => "", "role_name" => ""],
            "roles" => $roles
        ]);
    }

    public function add(Request $request, Response $response) {
        $details = $request->getParsedBody();
        $files = $request->getUploadedFiles()['image'];

        $name = filter_var($details['name'], FILTER_SANITIZE_STRING) ?? null;
        $password = filter_var($details['password'], FILTER_SANITIZE_STRING) ?? null;
        $role_id = filter_var($details['role'], FILTER_SANITIZE_NUMBER_INT) ?? null;

        $admin = new \Lib\Entities\Admin(null, $name, null, $password, $role_id);
        $admin->save($this->db, $files);

        return $response->withStatus(201);
    }
    public function edit(Request $request, Response $response, $args) {
        $details = $request->getParsedBody();
        $files = $request->getUploadedFiles()['image'];

        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $name = filter_var($details['name'], FILTER_SANITIZE_STRING) ?? null;

        $admin = new \Lib\Entities\Admin($id, $name);
        $admin->edit($this->db, $files);

        return $response->withStatus(200);
    }
}