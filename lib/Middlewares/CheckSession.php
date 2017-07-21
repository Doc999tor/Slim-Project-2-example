<?php
namespace Lib\Middlewares;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class CheckSession {
    /**
     * CheckSession middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response, callable $next) {

        $route = $request->getAttribute('route');
        $route_name = $route->getName();

        $response->getBody()->write($route_name);

        $session = new \RKA\Session();
        $response->getBody()->write($session->get('name', 'default'));

        if (isset($session->name)) {
            $admin = [
                "name" => $session->name,
                "role" => $session->role,
                "img" => $session->img
            ];
        } else {
            if (strstr($route_name, 'home_page')) {
                // $response = $response->withRedirect('/login');
            } else {
                // $response = $response->withStatus(403);
            }
        }

        $response = $next($request, $response);
        $session = new \RKA\Session();
        $response->getBody()->write($session->get('name', 'default'));

        return $response;
    }
}
