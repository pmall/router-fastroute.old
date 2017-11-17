<?php declare(strict_types=1);

namespace Ellipse\Router\Adapter\FastRoute\Exceptions;

use RuntimeException;

use Ellipse\Router\Adapter\Exceptions\RouterAdapterExceptionInterface;

class WrongNumberOfParametersException extends RuntimeException implements RouterAdapterExceptionInterface
{
    public function __construct(string $name, array $allowed, int $given)
    {
        $msg = "The route '%s' require %s parameters, %s given";

        $min = min($allowed);
        $max = max($allowed);

        $expected_str = $min == $max
            ? implode(' ', ['at least', $min])
            : implode(' ', ['between', $min, 'and', $max]);

        parent::__construct(sprintf($msg, $name, $expected_str, $given));
    }
}
