<?php declare(strict_types=1);

namespace Ellipse\Router\Adapter;

use FastRoute\RouteParser;
use FastRoute\DataGenerator;
use FastRoute\RouteCollector;

use Ellipse\Router\Adapter\FastRoute\Mapper;
use Ellipse\Router\Adapter\FastRoute\Matcher;
use Ellipse\Router\Adapter\FastRoute\UrlGenerator;
use Ellipse\Router\Adapter\FastRoute\RouterAdapter;

class FastRouteFactory implements RouteCollectionFactoryInterface
{
    /**
     * @inheritdoc
     */
    public function __invoke(array $definitions): RouteCollection
    {
        $parser = new RouteParser\Std;
        $generator = new DataGenerator\GroupCountBased;

        $collector = new RouteCollector($parser, $generator);

        $mapper = new Mapper($parser, $collector);
        $matcher = new Matcher($mapper);
        $generator = new UrlGenerator($mapper);

        $adapter = new RouterAdapter($mapper, $matcher, $generator);

        $definition = new DefinitionCollection($definitions);

        return new RouteCollection($adapter, $definition);
    }
}
