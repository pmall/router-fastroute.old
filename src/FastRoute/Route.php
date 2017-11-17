<?php declare(strict_types=1);

namespace Ellipse\Router\FastRoute;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Ellipse\Router\Handler;

class Route
{
    /**
     * The route name.
     *
     * @var string
     */
    private $name;

    /**
     * The route handler.
     *
     * @var \Ellipse\Router\Handler
     */
    private $handler;

    /**
     * Set up a route with the given name and handler.
     *
     * @param string                    $name
     * @param \Ellipse\Router\Handler   $handler
     */
    public function __construct(string $name, Handler $handler)
    {
        $this->name = $name;
        $this->handler = $handler;
    }

    /**
     * Return the route name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Return the route handler.
     *
     * @return string
     */
    public function getHandler(): Handler
    {
        return $this->handler;
    }

    /**
     * Make the route a callable to ensure compatibility.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return $this->handler->handle($request);
    }
}
