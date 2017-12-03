<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

use FastRoute\Dispatcher;

use Ellipse\Router\Handler;
use Ellipse\Router\Match;
use Ellipse\Router\FastRoute\Route;
use Ellipse\Router\FastRoute\Mapper;
use Ellipse\Router\FastRoute\Matcher;
use Ellipse\Router\Exceptions\NotFoundException;
use Ellipse\Router\Exceptions\MethodNotAllowedException;

describe('Matcher', function () {

    beforeEach(function () {

        $this->mapper = mock(Mapper::class);

        $this->matcher = new Matcher($this->mapper->get());

    });

    describe('->match()', function () {

        beforeEach(function () {

            $this->request = mock(ServerRequestInterface::class);
            $this->uri = mock(UriInterface::class);
            $this->dispatcher = mock(Dispatcher\GroupCountBased::class);

            allow(Dispatcher\GroupCountBased::class)->toBe($this->dispatcher->get());

            $this->request->getUri->returns($this->uri);
            $this->uri->getPath->returns('/path');
            $this->request->getMethod->returns('GET');

        });

        it('should return a match fot the given request', function () {

            $route = mock(Route::class);
            $handler = mock(Handler::class)->get();

            $route->getName->returns('name');
            $route->getHandler->returns($handler);

            $this->dispatcher->dispatch->with('GET', '/path')->returns([
                Dispatcher::FOUND, $route->get(), ['attribute'],
            ]);

            $test = $this->matcher->match($this->request->get());

            $match = new Match('name', $handler, ['attribute']);

            expect($test)->toEqual($match);

        });

        it('should fail when no route is matching the given request', function () {

            $this->dispatcher->dispatch->returns([Dispatcher::NOT_FOUND]);

            $test = function () {

                $this->matcher->match($this->request->get());

            };

            $exception = new NotFoundException('GET', '/path');

            expect($test)->toThrow($exception);

        });

        it('should fail when the given request method is not accepted for its path', function () {

            $this->dispatcher->dispatch->returns([Dispatcher::METHOD_NOT_ALLOWED, ['POST']]);

            $test = function () {

                $this->matcher->match($this->request->get());

            };

            $exception = new MethodNotAllowedException('/path', ['POST']);

            expect($test)->toThrow($exception);

        });

    });

});
