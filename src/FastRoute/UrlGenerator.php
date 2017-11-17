<?php declare(strict_types=1);

namespace Ellipse\Router\Adapter\FastRoute;

use Ellipse\Router\Adapter\FastRoute\Exceptions\RouteNameAlreadyMappedException;
use Ellipse\Router\Adapter\FastRoute\Exceptions\RouteNameNotMappedException;
use Ellipse\Router\Adapter\FastRoute\Exceptions\WrongNumberOfParametersException;
use Ellipse\Router\Adapter\FastRoute\Exceptions\WrongParameterFormatException;

class UrlGenerator
{
    /**
     * The mapper.
     *
     * @var \Ellipse\Router\Adapter\FastRoute\Mapper
     */
    private $mapper;

    /**
     * Build an url generator with the given mapper.
     *
     * @param \Ellipse\Router\Adapter\FastRoute\Mapper $mapper
     */
    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * Return an url from the given route name and parameters.
     *
     * @param string    $name
     * @param array     $parameters
     * @return string
     */
    public function generate(string $name, array $parameters = []): string
    {
        // get the route data mapped to the given name.
        $data = $this->mapper->get($name);

        // get the route matching the given name and number of parameters.
        $route = $this->getRouteMatchingParameters($name, $data, $parameters);

        // create an url from this route and the given parameters.
        return $this->getUrl($route, $parameters);
    }

    /**
     * Return the route definition expecting a number of parameters equal to the
     * number of parameters.
     *
     * @param string    $name
     * @param array     $data
     * @param array     $parameters
     * @return array
     * @throws \Ellipse\Router\Adapter\FastRoute\Exceptions\WrongNumberOfParametersException
     */
    private function getRouteMatchingParameters(string $name, array $data, array $parameters): array
    {
        $nb2route = array_reduce($data, function ($map, $route) {

            $nb = count(array_filter($route, 'is_array'));

            return $map + [$nb => $route];

        }, []);

        $nb = count($parameters);

        if (! array_key_exists($nb, $nb2route)) {

            $allowed = array_keys($nb2route);

            throw new WrongNumberOfParametersException($name, $allowed, $nb);

        }

        return $nb2route[$nb];
    }

    /**
     * Return an url from route definition and parameters.
     *
     * @param array $route
     * @param array $parameters
     * @return string
     * @throws \Ellipse\Router\Adapter\FastRoute\Exceptions\WrongParameterFormatException
     */
    private function getUrl(array $route, array $parameters): string
    {
        return array_reduce($route, function ($url, $part) use (&$parameters) {

            if (! is_array($part)) return $url . $part;

            $format = $part[1];
            $value = (string) array_shift($parameters);

            // fail when the route parameters does not match the parameter format.
            if (preg_match('~^' . $format . '$~', $value) === 0) {

                throw new WrongParameterFormatException($format, $value);

            }

            return $url . $value;

        }, '');
    }
}
