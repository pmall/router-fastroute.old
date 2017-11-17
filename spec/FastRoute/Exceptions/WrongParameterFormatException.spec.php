<?php

use Ellipse\Router\Adapter\Exceptions\RouterAdapterExceptionInterface;
use Ellipse\Router\Adapter\FastRoute\Exceptions\WrongParameterFormatException;

describe('WrongParameterFormatException', function () {

    it('should implement RouterAdapterExceptionInterface', function () {

        $test = new WrongParameterFormatException('format', 'value');

        expect($test)->toBeAnInstanceOf(RouterAdapterExceptionInterface::class);

    });

});
