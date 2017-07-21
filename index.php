<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$config = [
	'displayErrorDetails' => true,
	'determineRouteBeforeAppMiddleware' => true,
	'addContentLengthHeader' => false,
];

$config['db'] = include 'db_config.php';

// Create app
$app = new \Slim\App(["settings" => $config]);

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
	$view = new \Slim\Views\Twig('views', [
		'debug' => true,
		'cache' => false
	]);
	$view->addExtension(new \Slim\Views\TwigExtension(
		$container['router'],
		$container['request']->getUri()
	));
	$view->addExtension(new Twig_Extension_Debug());
	return $view;
};

$container['db'] = function ($c) {
	$db = $c['settings']['db'];
	try {
		$pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'], $db['user'], $db['pass']);
		// $pdo = new PDO("sqlsrv:Server=" . $db['host'] . ";Database=" . $db['dbname']);
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
		die();
	}
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$pdo->setAttribute(PDO::ATTR_PERSISTENT, true);
	return $pdo;
};

$app->add(new \RKA\SessionMiddleware());
// $app->add(new \Lib\Middlewares\CheckSession());

$container['LoginCtrl'] = function ($container) {
	return new \Lib\Controllers\LoginCtrl($container);
};
$container['SchoolCtrl'] = function ($container) {
	return new \Lib\Controllers\SchoolCtrl($container);
};
$container['AdministrationCtrl'] = function ($container) {
	return new \Lib\Controllers\AdministrationCtrl($container);
};
$container['CourseCtrl'] = function ($container) {
	return new \Lib\Controllers\CourseCtrl($container);
};
$container['StudentCtrl'] = function ($container) {
	return new \Lib\Controllers\StudentCtrl($container);
};
$container['AdminCtrl'] = function ($container) {
	return new \Lib\Controllers\AdminCtrl($container);
};

require 'lib/routes.php';

$app->run();