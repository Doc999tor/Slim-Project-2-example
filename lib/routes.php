<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
    return $response->withRedirect('/school');
});

$app->get('/school', 'SchoolCtrl:home');

$app->get('/api/users', 'SchoolCtrl:get');
$app->post('/api/user', 'SchoolCtrl:post');

$app->options('/', 'SchoolCtrl:options');