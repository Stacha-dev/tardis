<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Middleware\RouteFactory;

final class RouterTest extends TestCase
{
	/** @var int */
	private const SAMPLE_ROUTE_VERSION = 1;

	/** @var string */
	private const SAMPLE_ROUTE_METHOD_GET = 'GET';

	/** @var string */
	private const SAMPLE_ROUTE_METHOD_POST = "POST";

	/** @var string */
	private const SAMPLE_ROUTE_PATTERN = '@^(?<version>[0-9]+)/article/(?<id>[0-9]+)$@';

	/** @var string */
	private const SAMPLE_ROUTE_ACTION = 'getAll';

	/** @var array<string> */
	private const SAMPLE_ROUTE_PARAMS = ['id'];

	/** @var boolean */
	private const SAMPLE_ROUTE_PROTECTED = false;

	/** @var string */
	private const SAMPLE_REQUEST_METHOD_GET = "GET";

	/** @var string */
	private const SAMPLE_REQUEST_URI = "/api/1/article/1/";

	/** @var string */
	private const SAMPLE_REQUEST_ADDR = "127.0.0.1";

	/** @var \App\Lib\Http\Request */
	private $sampleGetRequest;

	public function setUp(): void
	{
		$_SERVER['HTTPS'] = self::SAMPLE_ROUTE_VERSION;
		$_SERVER['REQUEST_METHOD'] = self::SAMPLE_REQUEST_METHOD_GET;
		$_SERVER['REQUEST_URI'] = self::SAMPLE_REQUEST_URI;
		$_SERVER['REMOTE_ADDR'] = self::SAMPLE_REQUEST_ADDR;
		$this->sampleGetRequest = \App\Lib\Http\RequestFactory::fromGlobals();
	}

	/**
	 * Test is successful if route is registered and request is dispatched
	 *
	 * @return void
	 */
	public function testRegisteredRouteCanBeDispatched()
	{
		$router = new  \App\Lib\Middleware\Router;
		$route = RouteFactory::fromConstants(self::SAMPLE_ROUTE_VERSION, self::SAMPLE_ROUTE_METHOD_GET, self::SAMPLE_ROUTE_PATTERN, self::SAMPLE_ROUTE_ACTION, self::SAMPLE_ROUTE_PARAMS, self::SAMPLE_ROUTE_PROTECTED);
		$router->register($route);
		$this->assertCount(1, $router->getRoutes());
		$this->assertSame($router->dispatch($this->sampleGetRequest), $route);
	}

	/**
	 * Test is successful if route is registered and request is not dispatched
	 *
	 * @return void
	 */
	public function testRegisteredRouteCanNotBeDispatched()
	{
		$router = new  \App\Lib\Middleware\Router;
		$route = RouteFactory::fromConstants(self::SAMPLE_ROUTE_VERSION, self::SAMPLE_ROUTE_METHOD_POST, self::SAMPLE_ROUTE_PATTERN, self::SAMPLE_ROUTE_ACTION, self::SAMPLE_ROUTE_PARAMS, self::SAMPLE_ROUTE_PROTECTED);
		$router->register($route);
		$this->expectException("Exception");
		$router->dispatch($this->sampleGetRequest);
	}
}
