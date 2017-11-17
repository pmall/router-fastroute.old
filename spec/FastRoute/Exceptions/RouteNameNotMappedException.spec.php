<?php

use Ellipse\Router\Exceptions\RouterAdapterExceptionInterface;
use Ellipse\Router\FastRoute\Exceptions\RouteNameNotMappedException;

describe('RouteNameNotMappedException', function () {

    it('should implement RouterAdapterExceptionInterface', function () {

        $test = new RouteNameNotMappedException('name');

        expect($test)->toBeAnInstanceOf(RouterAdapterExceptionInterface::class);

    });

});
