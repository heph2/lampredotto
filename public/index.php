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

// Add DI container definitions
$containerBuilder->addDefinitions(dirname(__DIR__) . '/config/container.php');

// Create DI container instance
$container = $containerBuilder->build();

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', 'Lampredotto\HelloWorld');
    // $r->addRoute('GET', '/article/{id}', ['SuperBlog\Controller\ArticleController', 'show']);
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

        // We could do $container->get($controller) but $container->call()
        // does that automatically
        $container->call($controller, $parameters);
        break;
}

// $routes = simpleDispatcher(function (RouteCollector $r) {
//     $r->get('/hello', HelloWorld::class);
// });

// $middlewareQueue[] = new FastRoute($routes);
// $middlewareQueue[] = new RequestHandler($container);

// /** @noinspection PhpUnhandledExceptionInspection */
// $requestHandler = new Relay($middlewareQueue);
// $response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

// $emitter = new SapiEmitter();
// /** @noinspection PhpVoidFunctionResultUsedInspection */
// return $emitter->emit($response);
