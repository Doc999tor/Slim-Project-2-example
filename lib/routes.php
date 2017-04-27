<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
    return $response->withRedirect('/school');
});

$app->get('/school', 'SchoolCtrl:home');
$app->get('/{ent:courses|students|admins}/edit/{id:\d+}', 'SchoolCtrl:editForm');
$app->get('/{ent:courses|students|admins}/add', 'SchoolCtrl:addForm');
