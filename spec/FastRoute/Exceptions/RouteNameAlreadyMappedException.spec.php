<?php

use Ellipse\Router\Exceptions\RouterAdapterExceptionInterface;
use Ellipse\Router\FastRoute\Exceptions\RouteNameAlreadyMappedException;

describe('RouteNameAlreadyMappedException', function () {

    it('should implement RouterAdapterExceptionInterface', function () {

        $test = new RouteNameAlreadyMappedException('name');

        expect($test)->toBeAnInstanceOf(RouterAdapterExceptionInterface::class);

    });

});
