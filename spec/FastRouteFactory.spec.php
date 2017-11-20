<?php

use Ellipse\Router\FastRouteFactory;
use Ellipse\Router\FastRoute\RouterAdapter;

describe('FastRouteFactory', function () {

    beforeEach(function () {

        $this->factory = new FastRouteFactory;

    });

    describe('->__invoke()', function () {

        it('should return a new instance of RouterAdapter', function () {

            $test = ($this->factory)();

            expect($test)->toBeAnInstanceOf(RouterAdapter::class);

        });

    });

});
