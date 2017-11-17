<?php

use Ellipse\Router\Exceptions\RouterAdapterExceptionInterface;
use Ellipse\Router\FastRoute\Exceptions\WrongParameterFormatException;

describe('WrongParameterFormatException', function () {

    it('should implement RouterAdapterExceptionInterface', function () {

        $test = new WrongParameterFormatException('format', 'value');

        expect($test)->toBeAnInstanceOf(RouterAdapterExceptionInterface::class);

    });

});
