<?php
declare(strict_types=1);

namespace Lampredotto\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Lampredotto\Models\User;

class LoginController
{
    protected $logger;
    protected $view;
    protected $response;
    protected $user;

    public function __construct(ContainerInterface $container) {
        $this->logger = $container->get('logger');
        $this->view = $container->get('view');
        $this->user = new User($container->get('pdo'));
        $this->response = $container->get(Response::class);
    }

    public function __invoke(Request $request): Response {
        $this->logger->info("Login page action dispatched");
        $html = $this->view->render('login.twig', []);
        $this->response->withStatus(200);
        $this->response->withHeader('Content-Type', 'text/html');
        $this->response->getBody()->write($html);
        return $this->response;
    }

    public function login(Request $request): Response {
        $body = $request->getParsedBody();
        $user_email = $body['email'];
        $user_pssw = $body['password'];
        $this->logger->info("User login attempt: " . $user_email . " - " . $user_pssw);
        $user_data = $this->user->getByEmail($user_email);
        $this->logger->info("User data: " . json_encode($user_data));
        $user_role = $this->user->getRole($user_data['id']);
        $this->logger->info("User role: " . $user_role['role']);
        
        if ($user_data) {
            $this->logger->info("User found!");
            if (password_verify($user_pssw, $user_data['password'])) {
                $this->logger->info("User found!");
                $_SESSION['user'] = $user_data['id'];
                $_SESSION['role'] = $user_role['role'];
                $this->logger->info("User current session: " . $_SESSION['user']);
                $this->logger->info("User current role: " . $_SESSION['role']);
                return $this->response
                    ->withHeader('Location', '/' . $user_role['role']) // redirect to the user home
                    ->withStatus(302);
            }
        }

        $this->logger->info("User login failed");
        
        unset($_SESSION["user"]);

        return $this->response
            ->withHeader('Location', '/login')
            ->withStatus(403);
    }

    public function logout(Request $request): Response {
        $this->logger->info("User logout");
        unset($_SESSION["user"]);
        unset($_SESSION["role"]);
        return $this->response
            ->withHeader('Location', '/login')
            ->withStatus(302);
    }
}