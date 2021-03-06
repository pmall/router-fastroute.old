<?php

use Ellipse\Router\Exceptions\RouterAdapterExceptionInterface;
use Ellipse\Router\FastRoute\Exceptions\WrongNumberOfParametersException;

describe('WrongNumberOfParametersException', function () {

    it('should implement RouterAdapterExceptionInterface', function () {

        $test = new WrongNumberOfParametersException('name', [1, 2], 0);

        expect($test)->toBeAnInstanceOf(RouterAdapterExceptionInterface::class);

    });

});
