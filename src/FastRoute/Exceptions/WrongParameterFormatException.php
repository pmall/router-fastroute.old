<?php declare(strict_types=1);

namespace Ellipse\Router\Adapter\FastRoute\Exceptions;

use RuntimeException;

use Ellipse\Router\Adapter\Exceptions\RouterAdapterExceptionInterface;

class WrongParameterFormatException extends RuntimeException implements RouterAdapterExceptionInterface
{
    public function __construct(string $format, string $value)
    {
        $msg = "The given value '%s' does not match the route parameter format '%s'";

        parent::__construct(sprintf($msg, $value, $format));
    }
}
