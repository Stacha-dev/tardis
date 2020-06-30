<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    private $router;

    public function setUp(): void
    {
        $this->router = new  \App\Lib\Middleware\Router;
    }

	/**
	 * Test is successfull if route is registered and instance of Router is returned.
	 *
	 * @return void
	 */
    public function testRouteCanBeRegistered(): void
    {
        $route = array(
            "version" => 1,
            "method" => "GET",
            "pattern" => "@^(?<version>[0-9])/article$@",
            "action" => array("method" => "getAll", "params" => array()));
        $this->assertInstanceOf("App\Lib\Middleware\Router", $this->router->register($route));
    }
}
