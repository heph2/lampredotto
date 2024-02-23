<?php
declare(strict_types=1);

namespace Lampredotto\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Lampredotto\Models\Secretary;

class SecretaryController
{
    protected $logger;
    protected $view;
    protected $response;
    private $secretary;

    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
        $this->view = $container->get('view');
        $this->secretary = new Secretary($container->get('pdo'));
        $this->response = $container->get(Response::class);
    }

    public function __invoke(Request $request): Response
    {
        $this->logger->info("Secretary page action dispatched");
        $user_id = $_SESSION['user'];
        $user_role = $_SESSION['role'];

        $secretaryData = $this->secretary->getById($user_id);
        $html = $this->view->render('home_secretary.twig', [
            'secretary' => $secretaryData,
            'role' => $user_role
        ]);
        $this->response->withStatus(200);
        $this->response->withHeader('Content-Type', 'text/html');
        $this->response->getBody()->write($html);
        return $this->response;
    }
}
