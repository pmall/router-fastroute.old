<?php

use Ellipse\Router\Adapter\Exceptions\RouterAdapterExceptionInterface;
use Ellipse\Router\Adapter\FastRoute\Exceptions\RouteNameAlreadyMappedException;

describe('RouteNameAlreadyMappedException', function () {

    it('should implement RouterAdapterExceptionInterface', function () {

        $test = new RouteNameAlreadyMappedException('name');

        expect($test)->toBeAnInstanceOf(RouterAdapterExceptionInterface::class);

    });

});
