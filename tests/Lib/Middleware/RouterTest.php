<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Middleware\RouteFactory;

final class RouterTest extends TestCase
{
    /**
     * Test is successfull if route is registered and instance of Router is returned.
     *
     * @return void
     */
    public function testRouteCanBeRegistered(): void
    {
        $router = new  \App\Lib\Middleware\Router;
        $this->assertInstanceOf("App\Lib\Middleware\Router", $router->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9])/article$@", "getAll", array(), false)));
        $this->assertCount(1, $router->getRoutes());
    }
}
