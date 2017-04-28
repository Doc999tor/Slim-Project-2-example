<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
    return $response->withRedirect('/school');
});

$app->get('/school', 'SchoolCtrl:home');
$app->get('/administration', 'AdministrationCtrl:home');

$app->get('/courses/show/{id:\d+}', 'CourseCtrl:show');
$app->get('/courses/edit/{id:\d+}', 'CourseCtrl:editForm');
$app->get('/courses/addForm', 'CourseCtrl:add');
$app->post('/courses', 'CourseCtrl:add');
$app->put('/courses/{id:\d+}', 'CourseCtrl:put');
$app->delete('/courses/{id:\d+}', 'CourseCtrl:delete');

$app->get('/students/show/{id:\d+}', 'StudentCtrl:show');
$app->get('/students/edit/{id:\d+}', 'StudentCtrl:editForm');
$app->get('/students/addForm', 'StudentCtrl:add');
$app->post('/students', 'StudentCtrl:add');
$app->put('/students/{id:\d+}', 'StudentCtrl:put');
$app->delete('/students/{id:\d+}', 'StudentCtrl:delete');

$app->get('/admins/edit/{id:\d+}', 'AdminCtrl:editForm');
$app->get('/admins/addForm', 'AdminCtrl:add');
$app->post('/admins', 'AdminCtrl:add');
$app->put('/admins/{id:\d+}', 'AdminCtrl:put');
$app->delete('/admins/{id:\d+}', 'AdminCtrl:delete');
