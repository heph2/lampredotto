<?php
declare(strict_types=1);
session_start();

use DI\ContainerBuilder;
use FastRoute as Router;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Relay\Relay;
use Monolog\Processor\UidProcessor;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use function DI\create;
use function DI\get;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(dirname(__DIR__) . '/config/container.php');
$container = $containerBuilder->build();

$routeDispatcher = Router\simpleDispatcher(function (Router\RouteCollector $r) {
    $r->addRoute('GET', '/', 'Lampredotto\SettingsController');
    $r->addRoute('GET', '/login', 'Lampredotto\Controllers\LoginController');
    $r->addRoute('POST', '/login', ['Lampredotto\Controllers\LoginController', 'login']);
    $r->addRoute('GET', '/logout', ['Lampredotto\Controllers\LoginController', 'logout']);
    $r->addRoute('GET', '/student', 'Lampredotto\Controllers\StudentController');
    $r->addRoute('GET', '/student/exams', 'Lampredotto\Controllers\ExamController');
    $r->addRoute('POST', '/student/exams/enroll', ['Lampredotto\Controllers\ExamController', 'enroll']);
    $r->addRoute('POST', '/student/exams/delete', ['Lampredotto\Controllers\ExamController', 'unenroll']);
    $r->addRoute('GET', '/teacher', 'Lampredotto\Controllers\TeacherController');
    $r->addRoute('GET', '/teacher/exams', 'Lampredotto\Controllers\CalendarController');
    $r->addRoute('POST', '/teacher/exams/new', ['Lampredotto\Controllers\CalendarController', 'addExam']);
    $r->addRoute('POST', '/teacher/exams/delete', ['Lampredotto\Controllers\CalendarController', 'deleteExam']);
    $r->addRoute('GET', '/secretary', 'Lampredotto\Controllers\SecretaryController');
    $r->addRoute('POST', '/secretary/students/add', ['Lampredotto\Controllers\SecretaryController', 'addStudent']);
    // $r->addGroup('/teacher', function (Router\RouteCollector $r) {
    //     $r->addRoute('GET', '/', 'Lampredotto\TeacherController');
    //     $r->addRoute('GET', '/settings', 'Lampredotto\SettingsController');
    //     $r->addRoute('GET', '/settings/{id}', '');
    // });
    // $r->addGroup('/secretary', function (Router\RouteCollector $r) {
    //     $r->addRoute('GET', '/', 'Lampredotto\SecretaryController');
    //     $r->addRoute('GET', '/settings', 'Lampredotto\SettingsController');
    //     $r->addRoute('GET', '/settings/{id}', '');
    // });
    // $r->addGroup('/student', function (Router\RouteCollector $r) {
    //     $r->addRoute('GET', '/', 'Lampredotto\Controllers\StudentController');
    //     $r->addRoute('GET', '/settings', 'Lampredotto\SettingsController');
    //     $r->addRoute('GET', '/exams', 'Lampredotto\ExamController');
    // });
});

$middlewareQueue[] = new Middlewares\Emitter();
// $middlewareQueue[] = new Lampredotto\Middleware\PreventLoginRedirectMiddleware();
// $middlewareQueue[] = new Lampredotto\Middleware\SessionAuthMiddleware();
$middlewareQueue[] = new Lampredotto\Middleware\RoleMiddleware(
    new Lampredotto\Controllers\LoginController($container)
);
$middlewareQueue[] = new FastRoute($routeDispatcher);
$middlewareQueue[] = new RequestHandler($container);


$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle($request);

