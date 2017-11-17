<?php declare(strict_types=1);

namespace Ellipse\Router\FastRoute\Exceptions;

use RuntimeException;

use Ellipse\Router\Exceptions\RouterAdapterExceptionInterface;

class RouteNameAlreadyMappedException extends RuntimeException implements RouterAdapterExceptionInterface
{
    public function __construct(string $name)
    {
        $msg = "The route name '%s' is already mapped";

        parent::__construct(sprintf($msg, $name));
    }
}
