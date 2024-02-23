<?php
declare(strict_types=1);
namespace Lampredotto\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\Uri;

class SessionAuthMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        error_log("SessionAuthMiddleware invoked");

        // Bypass middleware for the login page
        $path = $request->getUri()->getPath();
        if ($path === '/login') {
            return $handler->handle($request);
        }

        // Access session data
        if (!isset($_SESSION['user'])) {
            return (new Response())
                ->withStatus(302)
                ->withHeader('Location', '/login');
        }
        error_log("LOGGED");

        return $handler->handle($request);
    }
}
