<?php declare(strict_types=1);

namespace Ellipse\Router\Adapter\FastRoute;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Router\Adapter\RouterAdapterInterface;

use Ellipse\Router\Adapter\Handler;
use Ellipse\Router\Adapter\Match;

class RouterAdapter implements RouterAdapterInterface
{
    /**
     * The mapper.
     *
     * @var \Ellipse\Router\Adapter\FastRoute\Mapper
     */
    private $mapper;

    /**
     * The matcher.
     *
     * @var \Ellipse\Router\Adapter\FastRoute\Matcher
     */
    private $matcher;

    /**
     * The url generator.
     *
     * @var \Ellipse\Router\Adapter\FastRoute\UrlGenerator
     */
    private $generator;

    /**
     * Set up a router adapter with the given mapper, matcher and url generator.
     *
     * @param \Ellipse\Router\Adapter\FastRoute\Mapper          $mapper
     * @param \Ellipse\Router\Adapter\FastRoute\Matcher         $matcher
     * @param \Ellipse\Router\Adapter\FastRoute\UrlGenerator    $generator
     */
    public function __construct(Mapper $mapper, Matcher $matcher, UrlGenerator $generator)
    {
        $this->mapper = $mapper;
        $this->matcher = $matcher;
        $this->generator = $generator;
    }

    /**
     * @inheritdoc
     */
    public function register(string $name, array $method, string $pattern, Handler $handler)
    {
        return $this->mapper->register($name, $method, $pattern, $handler);
    }

    /**
     * @inheritdoc
     */
    public function match(ServerRequestInterface $request): Match
    {
        return $this->matcher->match($request);
    }

    /**
     * @inheritdoc
     */
    public function generate(string $name, array $parameters = []): string
    {
        return $this->generator->generate($name, $parameters);
    }
}
