<?php
declare(strict_types=1);

namespace Lampredotto;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HelloWorld
{
    protected $logger;
    protected $view;

    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
        $this->view = $container->get('view');
    }

    public function __invoke(): void
    {
        $this->logger->info("Student page action dispatched");
        // echo $this->view->render('hello.twig', ['name' => 'Fabien']);
        echo $this->view->render('home_student.twig');
        // echo 'Hello, World!';
    }
    // public function __invoke(Request $request, Response $response, string $template, array $params = []): Response
    // {
    //     // return $this->view->render($response, $template, $params);
    //     echo $this->view->render('hello.twig', $params);
    // }
}
