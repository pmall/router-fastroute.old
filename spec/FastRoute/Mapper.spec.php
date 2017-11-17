<?php

use function Eloquent\Phony\Kahlan\mock;
use function Eloquent\Phony\Kahlan\anInstanceOf;

use FastRoute\RouteParser;
use FastRoute\RouteCollector;

use Ellipse\Router\Handler;
use Ellipse\Router\FastRoute\Route;
use Ellipse\Router\FastRoute\Mapper;
use Ellipse\Router\FastRoute\Exceptions\RouteNameAlreadyMappedException;
use Ellipse\Router\FastRoute\Exceptions\RouteNameNotMappedException;

describe('Mapper', function () {

    beforeEach(function () {

        $this->parser = mock(RouteParser::class);
        $this->collector = mock(RouteCollector::class);

        $this->mapper = new Mapper($this->parser->get(), $this->collector->get());

    });

    describe('->register()', function () {

        it('should call the fast route collector ->addRoute() method with the given parameters', function () {

            $handler = mock(Handler::class)->get();

            $this->mapper->register('', ['GET'], '/pattern1', $handler);

            $this->collector->addRoute->calledWith(['GET'], '/pattern1', anInstanceOf(Route::class));

        });

        it('should not fail when the given name is empty', function () {

            $handler1 = mock(Handler::class)->get();
            $handler2 = mock(Handler::class)->get();

            $test = function () use ($handler1, $handler2) {

                $this->mapper->register('', ['GET'], '/pattern', $handler1);
                $this->mapper->register('', ['GET'], '/pattern', $handler2);

            };

            $exception = new RouteNameAlreadyMappedException('');

            expect($test)->not->toThrow($exception);

        });

        it('should fail when the name is not empty and already mapped', function () {

            $handler1 = mock(Handler::class)->get();
            $handler2 = mock(Handler::class)->get();

            $test = function () use ($handler1, $handler2) {

                $this->mapper->register('name', ['GET'], '/pattern', $handler1);
                $this->mapper->register('name', ['GET'], '/pattern', $handler2);

            };

            $exception = new RouteNameAlreadyMappedException('name');

            expect($test)->toThrow($exception);

        });

    });

    describe('->has()', function () {

        it('should return true when the route name is mapped', function () {

            $handler = mock(Handler::class)->get();

            $this->mapper->register('name', ['GET'], '/pattern', $handler);

            $test = $this->mapper->has('name');

            expect($test)->toBe(true);

        });

        it('should return false when the route name is not mapped', function () {

            $handler = mock(Handler::class)->get();

            $this->mapper->register('name', ['GET'], '/pattern', $handler);

            $test = $this->mapper->has('notmapped');

            expect($test)->toBe(false);

        });

    });

    describe('->get()', function () {

        it('should return the data associated with the pattern', function () {

            $handler = mock(Handler::class)->get();

            $this->mapper->register('name', ['GET'], '/pattern', $handler);

            $this->parser->parse->returns(['data']);

            $test = $this->mapper->get('name');

            expect($test)->toEqual(['data']);

        });

        it('should fail when the name is not mapped', function () {

            $test = function () {

                $this->mapper->get('notmapped');

            };

            $exception = new RouteNameNotMappedException('notmapped');

            expect($test)->toThrow($exception);

        });

    });

});
