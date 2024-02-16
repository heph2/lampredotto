<?php

use Psr\Container\ContainerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

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
    // 'view' => function (ContainerInterface $container) {
    //     $settings = $container->get('settings');
    //     return Twig::create($settings['view']['template_path'], $settings['view']['twig']);
    // },
];