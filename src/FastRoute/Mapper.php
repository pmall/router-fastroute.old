<?php declare(strict_types=1);

namespace Ellipse\Router\Adapter\FastRoute;

use FastRoute\RouteParser;
use FastRoute\DataGenerator;
use FastRoute\RouteCollector;

use Ellipse\Router\Adapter\Handler;
use Ellipse\Router\Adapter\FastRoute\Exceptions\RouteNameNotMappedException;
use Ellipse\Router\Adapter\FastRoute\Exceptions\RouteNameAlreadyMappedException;

class Mapper
{
    /**
     * The underlying fastroute parser.
     *
     * @var \FastRoute\RouteParser
     */
    private $parser;

    /**
     * The underlying fastroute collector.
     *
     * @var \FastRoute\RouteCollector
     */
    private $collector;

    /**
     * A map associating names to route data.
     *
     * @var array
     */
    private $map = [];

    /**
     * Set up a mapper with the given fastroute parser and route collector.
     *
     * @param FastRoute\RouteParser     $parser
     * @param FastRoute\RouteCollector  $collector
     */
    public function __construct(RouteParser $parser, RouteCollector $collector)
    {
        $this->parser = $parser;
        $this->collector = $collector;
    }

    /**
     * Return whether a route pattern is mapped to the given name.
     *
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->map);
    }

    /**
     * Return the route data mapped with the given name.
     *
     * @param string $name
     * @return array
     * @throws \Ellipse\Router\Adapter\FastRoute\Exceptions\RouteNameNotMappedException
     */
    public function get(string $name): array
    {
        // fail when no route data are mapped to the given name.
        if (! $this->has($name)) {

            throw new RouteNameNotMappedException($name);

        }

        $pattern = $this->map[$name];

        return $this->parser->parse($pattern);
    }

    /**
     * Proxy the collector ->getData() method.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->collector->getData();
    }

    /**
     * Register a handler to the mapper.
     *
     * @param string                            $name
     * @param array                             $methods
     * @param string                            $pattern
     * @param \Ellipse\Router\Adapter\Handler   $handler
     * @return mixed
     * @throws \Ellipse\Router\Adapter\FastRoute\Exceptions\RouteNameAlreadyMappedException
     */
    public function register(string $name, array $methods, string $pattern, Handler $handler)
    {
        // Associate the name with the pattern when its not empty.
        if ($name != '') {

            if ($this->has($name)) {

                throw new RouteNameAlreadyMappedException($name);

            }

            $this->map[$name] = $pattern;

        }

        $route = new Route($name, $handler);

        $this->collector->addRoute($methods, $pattern, $route);
    }
}
