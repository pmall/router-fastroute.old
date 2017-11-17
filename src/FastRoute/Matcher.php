<?php declare(strict_types=1);

namespace Ellipse\Router\FastRoute;

use Psr\Http\Message\ServerRequestInterface;

use FastRoute\Dispatcher;

use Ellipse\Router\Match;
use Ellipse\Router\Exceptions\NotFoundException;
use Ellipse\Router\Exceptions\MethodNotAllowedException;

class Matcher
{
    /**
     * The mapper.
     *
     * @var \Ellipse\Router\FastRoute\Mapper
     */
    private $mapper;

    /**
     * Set up a matcher with the given mapper.
     *
     * @param \Ellipse\Router\FastRoute\Mapper $mapper
     */
    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * Return the route matching the given request.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Ellipse\Router\Match
     * @throws \Ellipse\Router\Exceptions\NotFoundException
     * @throws \Ellipse\Router\Exceptions\MethodNotAllowedException
     */
    public function match(ServerRequestInterface $request): Match
    {
        $uri = $request->getUri()->getPath();
        $method = $request->getMethod();

        $data = $this->mapper->getData();

        $dispatcher = new Dispatcher\GroupCountBased($data);

        $info = $dispatcher->dispatch($method, $uri);

        if ($info[0] == Dispatcher::METHOD_NOT_ALLOWED) {

            $allowed_methods = $info[1];

            throw new MethodNotAllowedException($uri, $allowed_methods);

        }

        if ($info[0] == Dispatcher::NOT_FOUND) {

            throw new NotFoundException($method, $uri);

        }

        $name = $info[1]->getName();
        $handler = $info[1]->getHandler();
        $attributes = $info[2];

        return new Match($name, $handler, $attributes);
    }
}
