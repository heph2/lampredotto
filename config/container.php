<?php

use Psr\Container\ContainerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Response;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    'logger' => function (ContainerInterface $container) {
        $settings = $container->get('settings');

        $loggerSettings = $settings['logger'];
        $logger = new Logger($loggerSettings['name']);

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
        $logger->pushHandler($handler);

        return $logger;
    },

    'view' => function (ContainerInterface $container) {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        return new Environment($loader);
    },
    
    'pdo' => function (ContainerInterface $container) {
        $settings = $container->get('settings');

        $host = $settings['db']['host'];
        $dbname = $settings['db']['database'];
        $username = $settings['db']['username'];
        $password = $settings['db']['password'];
        $charset = $settings['db']['charset'];
        $flags = $settings['db']['flags'];
        $dsn = "pgsql:host=$host;port=5432;dbname=$dbname";
        return new PDO($dsn, $username, $password);
    },
    ServerRequestInterface::class => function () {
        return ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
        );
    },
    ResponseInterface::class => function () {
        return new Response();
    },
];