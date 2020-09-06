<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Middleware\RouteFactory;

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
        $this->assertInstanceOf("App\Lib\Middleware\Router", $this->router->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9])/article$@", "getAll", array(), false)));
        $this->assertCount(1, $this->router->getRoutes());
    }
}
