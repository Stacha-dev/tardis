<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Controller\Base;
use App\Bootstrap;

final class BaseTest extends TestCase
{
    private $base;

    protected function setUp(): void
    {
        $this->base = new Base(Bootstrap::getEntityManager());
    }

    /**
     * Test is successfull if instance of App\Controller\Base is created.
     *
     * @return void
     */
    public function testClassConstruct(): void
    {
        $this->assertInstanceOf("App\Controller\Base", $this->base);
    }

    /**
     * Test is successfull if default routes can be registered.
     *
     * @return void
     */
    public function testDefaultRoutesCanBeRegistered(): void
    {
        $router = new \App\Lib\Middleware\Router;
        $this->base->registerDefaultRoutes($router);
        $this->assertNotCount(0, $router->getRoutes());
    }
}
