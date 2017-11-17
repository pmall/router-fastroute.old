<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Message\ServerRequestInterface;

use Ellipse\Router\Adapter\Handler;
use Ellipse\Router\Adapter\Match;
use Ellipse\Router\Adapter\RouterAdapterInterface;
use Ellipse\Router\Adapter\FastRoute\Mapper;
use Ellipse\Router\Adapter\FastRoute\Matcher;
use Ellipse\Router\Adapter\FastRoute\UrlGenerator;
use Ellipse\Router\Adapter\FastRoute\RouterAdapter;

describe('RouterAdapter', function () {

    beforeEach(function () {

        $this->mapper = mock(Mapper::class);
        $this->matcher = mock(Matcher::class);
        $this->generator = mock(UrlGenerator::class);

        $this->router = new RouterAdapter(
            $this->mapper->get(),
            $this->matcher->get(),
            $this->generator->get()
        );

    });

    it('should implement RouterAdapterInterface', function () {

        expect($this->router)->toBeAnInstanceOf(RouterAdapterInterface::class);

    });

    describe('->register()', function () {

        it('should proxy the mapper ->register() method', function () {

            $handler = mock(Handler::class)->get();

            $this->router->register('name', ['GET'], '/pattern', $handler);

            $this->mapper->register->calledWith('name', ['GET'], '/pattern', $handler);

        });

    });

    describe('->match()', function () {

        it('should proxy the matcher ->match() method', function () {

            $request = mock(ServerRequestInterface::class)->get();
            $match = mock(Match::class)->get();

            $this->matcher->match->with($request)->returns($match);

            $test = $this->router->match($request);

            expect($test)->toBe($match);

        });

    });

    describe('->generate()', function () {

        it('should proxy the url generator ->generate() method', function () {

            $this->generator->generate->with('name', ['attribute'])->returns('url');

            $test = $this->router->generate('name', ['attribute']);

            expect($test)->toEqual('url');

        });

    });

});
