<?php
namespace Lib\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class AdministrationCtrl extends Controller {
    public function home(Request $request, Response $response): Response {
        $admin = $this->checkSession();

        $path = 'home';
        $admins = \Lib\Entities\Admin::selectAll($this->db);

        $response = $response->withHeader('X-Robots-Tag', 'noindex, nofollow');
        return $this->view->render($response, "home.html", [
            'path' => $path,
            "sections" => ['admins'],
            'data' => [
                "admins" => [
                    "title" => "Admins",
                    "arr" => $admins,
                ],
            ],
            "admin" => $admin,
        ]);
    }
}