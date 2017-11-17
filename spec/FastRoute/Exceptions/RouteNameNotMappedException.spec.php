<?php

use Ellipse\Router\Adapter\Exceptions\RouterAdapterExceptionInterface;
use Ellipse\Router\Adapter\FastRoute\Exceptions\RouteNameNotMappedException;

describe('RouteNameNotMappedException', function () {

    it('should implement RouterAdapterExceptionInterface', function () {

        $test = new RouteNameNotMappedException('name');

        expect($test)->toBeAnInstanceOf(RouterAdapterExceptionInterface::class);

    });

});
