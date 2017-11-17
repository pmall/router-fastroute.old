<?php

use function Eloquent\Phony\Kahlan\mock;

use FastRoute\RouteParser;

use Ellipse\Router\Adapter\FastRoute\Mapper;
use Ellipse\Router\Adapter\FastRoute\UrlGenerator;
use Ellipse\Router\Adapter\FastRoute\Exceptions\WrongNumberOfParametersException;
use Ellipse\Router\Adapter\FastRoute\Exceptions\WrongParameterFormatException;

describe('UrlGenerator', function () {

    beforeEach(function () {

        $this->parser = new RouteParser\Std;

        $this->mapper = mock(Mapper::class);

        $this->generator = new UrlGenerator($this->mapper->get());

    });

    describe('->generate()', function () {

        it('should return an url constructed with the given parameters', function () {

            $data = $this->parser->parse('/pattern[/{optional1}[/{optional2}]]');

            $this->mapper->get->with('name')->returns($data);

            $test1 = $this->generator->generate('name');

            expect($test1)->toEqual('/pattern');

            $test2 = $this->generator->generate('name', ['optional1']);

            expect($test2)->toEqual('/pattern/optional1');

            $test3 = $this->generator->generate('name', ['optional1', 'optional2']);

            expect($test3)->toEqual('/pattern/optional1/optional2');

        });

        it('should fail when a wrong number of parameters is given', function () {

            $data = $this->parser->parse('/pattern/{parameter1}/{parameter2}');

            $this->mapper->get->returns($data);

            $test = function () {

                $this->generator->generate('name', ['value']);

            };

            $exception = new WrongNumberOfParametersException('name', [2], 1);

            expect($test)->toThrow($exception);

        });

        it('should fail when a parameter does not match a specified route pattern', function () {

            $data = $this->parser->parse('/pattern/{parameter1}/{parameter2:[0-9]+}');

            $this->mapper->get->returns($data);

            $test = function () {

                $this->generator->generate('name', ['value1', 'value2']);

            };

            $exception = new WrongParameterFormatException('[0-9]+', 'value2');

            expect($test)->toThrow($exception);

        });

    });

});
