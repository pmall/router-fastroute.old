<?php declare(strict_types=1);

namespace Ellipse\Router;

use FastRoute\RouteParser;
use FastRoute\DataGenerator;
use FastRoute\RouteCollector;

use Ellipse\Router\FastRoute\Mapper;
use Ellipse\Router\FastRoute\Matcher;
use Ellipse\Router\FastRoute\UrlGenerator;
use Ellipse\Router\FastRoute\RouterAdapter;

class FastRouteFactory
{
    /**
     * Return a fast route adapter.
     *
     * @return \Ellipse\Router\RouterAdapterInterface
     */
    public function __invoke(): RouterAdapterInterface
    {
        $parser = new RouteParser\Std;
        $generator = new DataGenerator\GroupCountBased;

        $collector = new RouteCollector($parser, $generator);

        $mapper = new Mapper($parser, $collector);
        $matcher = new Matcher($mapper);
        $generator = new UrlGenerator($mapper);

        return new RouterAdapter($mapper, $matcher, $generator);
    }
}
