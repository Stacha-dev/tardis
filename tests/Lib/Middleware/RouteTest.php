<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Middleware\RouteFactory;

final class RouteTest extends TestCase
{
    /** @var int */
    private const SAMPLE_ROUTE_VERSION = 1;

    /** @var string */
    private const SAMPLE_ROUTE_METHOD = 'GET';

    /** @var string */
    private const SAMPLE_ROUTE_PATTERN = '@^(?<version>[0-9]+)/article/(?<id>[0-9]+)$@';

    /** @var string */
    private const SAMPLE_ROUTE_ACTION = 'getAll';

    /** @var array<string> */
    private const SAMPLE_ROUTE_PARAMS = ['id'];

    /** @var boolean */
    private const SAMPLE_ROUTE_PROTECTED = false;


    /**
     * Test is successful if route is registered and instance of Route is returned.
     *
     * @return void
     */
    public function testRouteInstanceCanCreated()
    {
        $this->assertInstanceOf("App\Lib\Middleware\Route", RouteFactory::fromConstants(self::SAMPLE_ROUTE_VERSION, self::SAMPLE_ROUTE_METHOD, self::SAMPLE_ROUTE_PATTERN, self::SAMPLE_ROUTE_ACTION, self::SAMPLE_ROUTE_PARAMS, self::SAMPLE_ROUTE_PROTECTED));
    }

    /**
     * Test is successful if route is registered and params are equal
     *
     * @return void
     */
    public function testRouteParams()
    {
        $route = RouteFactory::fromConstants(self::SAMPLE_ROUTE_VERSION, self::SAMPLE_ROUTE_METHOD, self::SAMPLE_ROUTE_PATTERN, self::SAMPLE_ROUTE_ACTION, self::SAMPLE_ROUTE_PARAMS, self::SAMPLE_ROUTE_PROTECTED);
        $this->assertEquals($route->getVersion(), self::SAMPLE_ROUTE_VERSION);
        $this->assertEquals($route->getMethod(), self::SAMPLE_ROUTE_METHOD);
        $this->assertEquals($route->getPattern(), self::SAMPLE_ROUTE_PATTERN);
        $this->assertEquals($route->getAction(), self::SAMPLE_ROUTE_ACTION);
        $this->assertEquals($route->getParams(), self::SAMPLE_ROUTE_PARAMS);
        $this->assertFalse($route->isSecure());
    }
}
