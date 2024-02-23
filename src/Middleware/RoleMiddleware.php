<?php
namespace Lampredotto\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Nyholm\Psr7\Response;
use Lampredotto\Controllers\LoginController;

class RoleMiddleware implements MiddlewareInterface
{
    private $loginController;

    public function __construct(LoginController $loginController)
    {
        $this->loginController = $loginController;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        error_log("RoleAuthMiddleware invoked");
        $path = $request->getUri()->getPath();
        if ($path === '/login') {
            return $handler->handle($request);
        }        
        $userRole = $_SESSION['role'] ?? '';

        $rolePaths = [
            'student' => ['/student', '/student/exams', '/student/exams/enroll', '/student/exams/delete', '/student/settings', '/login'],
            'teacher' => ['/teacher', '/teacher/exams', '/teacher/exams/new', '/teacher/exams/delete', '/login'],
            'secretary'   => ['/secretary', '/login'],
        ];

        error_log("Role: " . $userRole);
        $validPaths = $rolePaths[$userRole] ?? [];
        
        if (!in_array($path, $validPaths)) {
            error_log("Access denied");
            error_log("Redirecting to /login");
            return (new Response())
                ->withStatus(302)
                ->withHeader('Location', '/login');
        }

        return $handler->handle($request);
    }
}