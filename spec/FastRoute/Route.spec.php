<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Ellipse\Router\Handler;
use Ellipse\Router\FastRoute\Route;

describe('Route', function () {

    beforeEach(function () {

        $this->handler = mock(Handler::class);

        $this->route = new Route('name', $this->handler->get());

    });

    describe('->getName()', function () {

        it('should return the route name', function () {

            $test = $this->route->getName();

            expect($test)->toEqual('name');

        });

    });

    describe('->getHandler()', function () {

        it('should return the route handler', function () {

            $test = $this->route->getHandler();

            expect($test)->toEqual($this->handler->get());

        });

    });

    describe('->__invoke()', function () {

        it('should proxy the route handler ->handle() method', function () {

            $request = mock(ServerRequestInterface::class)->get();
            $response = mock(ResponseInterface::class)->get();

            $this->handler->handle->with($request)->returns($response);

            $test = ($this->route)($request);

            expect($test)->toBe($response);

        });

    });

});
