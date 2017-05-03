<?php
namespace Lib\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class LoginCtrl extends Controller {
    public function home(Request $request, Response $response): Response {
        $response = $response->withHeader('X-Robots-Tag', 'noindex, nofollow');
        return $this->view->render($response, "login.html");
    }

    public function login(Request $request, Response $response): Response {
        $details = $request->getParsedBody();
        $name = filter_var($details['name'], FILTER_SANITIZE_STRING) ?? null;
        $password = filter_var($details['password'], FILTER_SANITIZE_STRING) ?? null;

        $admin = \Lib\Entities\Admin::checkPassword($this->db, $name, $password);
        if (!empty($admin)) {
            $session = new \RKA\Session();
            $session->set('name', $admin->name);
            $session->set('role', $admin->role_name);
            $session->set('img', $admin->img);

            // echo "<pre>";
            // print_r($session->name);
            // echo "</pre>";
            // die();
            return $response->withRedirect('/school');
        } else {
            return $response->withRedirect('/login');
        }
    }
    public function logout(Request $request, Response $response): Response {
        \RKA\Session::destroy();
        return $response->withRedirect('/login');
    }
}