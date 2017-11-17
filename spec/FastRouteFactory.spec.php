<?php

use Ellipse\Router\RouteCollectionFactoryInterface;
use Ellipse\Router\RouteCollection;
use Ellipse\Router\FastRouteFactory;

describe('FastRouteFactory', function () {

    beforeEach(function () {

        $this->factory = new FastRouteFactory;

    });

    it('should implement RouteCollectionFactoryInterface', function () {

        expect($this->factory)->toBeAnInstanceOf(RouteCollectionFactoryInterface::class);

    });

    describe('->__invoke()', function () {

        it('should return a new instance of RouteCollection', function () {

            $test = ($this->factory)([]);

            expect($test)->toBeAnInstanceOf(RouteCollection::class);

        });

    });

});
