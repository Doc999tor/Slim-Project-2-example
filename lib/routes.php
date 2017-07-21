<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
    return $response->withRedirect('/login');
});

$app->get('/login', 'LoginCtrl:home');
$app->post('/login', 'LoginCtrl:login');
$app->get('/logout', 'LoginCtrl:logout');

# Home pages
$app->group('', function () use ($app) {
	$app->get('/school', 'SchoolCtrl:home')->setName('school_home_page');
	$app->get('/administration', 'AdministrationCtrl:home')->setName('admin_home_page');
})->add(new \Lib\Middlewares\CheckSession());

$app->group('/courses', function () use ($app) {
	$app->get('/add', 'CourseCtrl:addForm');
	$app->get('/show/{id:\d+}', 'CourseCtrl:show');
	$app->get('/edit/{id:\d+}', 'CourseCtrl:editForm');
	$app->post('', 'CourseCtrl:add');
	$app->post('/{id:\d+}', 'CourseCtrl:edit'); # PHP doesn't support for sending form data put requests. Just use post.
	$app->delete('/{id:\d+}', 'CourseCtrl:delete');
})->add(new \Lib\Middlewares\CheckSession());

$app->group('/students', function () use ($app) {
	$app->get('/show/{id:\d+}', 'StudentCtrl:show');
	$app->get('/edit/{id:\d+}', 'StudentCtrl:editForm');
	$app->get('/add', 'StudentCtrl:addForm');
	$app->post('', 'StudentCtrl:add');
	$app->post ('/{id:\d+}', 'StudentCtrl:edit');
	$app->delete('/{id:\d+}', 'StudentCtrl:delete');
})->add(new \Lib\Middlewares\CheckSession());

$app->group('/admins', function () use ($app) {
	$app->get('/edit/{id:\d+}', 'AdminCtrl:editForm');
	$app->get('/add', 'AdminCtrl:addForm');
	$app->post('', 'AdminCtrl:add');
	$app->post ('/{id:\d+}', 'AdminCtrl:edit');
	$app->delete('/{id:\d+}', 'AdminCtrl:delete');
})->add(new \Lib\Middlewares\CheckSession());