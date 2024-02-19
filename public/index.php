<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Lampredotto\HelloWorld;
use FastRoute\RouteCollector;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use function DI\create;
use function DI\get;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(dirname(__DIR__) . '/config/container.php');
$container = $containerBuilder->build();

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['Lampredotto\LoginController', 'login']);
    $r->addRoute('GET', '/student', 'Lampredotto\StudentController');
    $r->addRoute('GET', '/secretary', 'Lampredotto\SecretaryController');
    $r->addRoute('GET', '/teacher', 'Lampredotto\TeacherController');
});

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo '405 Method Not Allowed';
        break;

    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];
        $container->call($controller, $parameters);
        break;
}
