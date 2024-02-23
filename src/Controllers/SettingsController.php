<?php
declare(strict_types=1);

namespace Lampredotto;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SettingsController
{
    protected $logger;
    protected $view;
    protected $response;

    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
        $this->view = $container->get('view');
        $this->response = $container->get(Response::class);
    }

    public function __invoke(Request $request): Response
    {
        $this->response->withStatus(200);
        $this->response->withHeader('Content-Type', 'text/html');
        $this->response->getBody()->write('<!DOCTYPE html><html><head></head><body>Hello World</body></html>');
        
        return $this->response;
    }
    
}
