<?php declare(strict_types=1);

namespace Ellipse\Router\FastRoute\Exceptions;

use RuntimeException;

use Ellipse\Router\Exceptions\RouterAdapterExceptionInterface;

class RouteNameNotMappedException extends RuntimeException implements RouterAdapterExceptionInterface
{
    public function __construct(string $name)
    {
        $msg = "The route name '%s' is not mapped";

        parent::__construct(sprintf($msg, $name));
    }
}
