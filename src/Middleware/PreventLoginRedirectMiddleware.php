<?php
namespace Lampredotto\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Nyholm\Psr7\Response;

class PreventLoginRedirectMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        error_log("PreventLoginRedirectMiddleware invoked");
        $path = $request->getUri()->getPath();

        // Check if user is already logged in and is accessing /login
        if (isset($_SESSION['user']) && $path === '/login') {
            return (new Response())
                ->withStatus(302)
                ->withHeader('Location', '/' . $_SESSION['role']);
        }

        return $handler->handle($request);
    }
}
