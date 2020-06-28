<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Bootstrap;

final class BootstrapTest extends TestCase
{
    /**
     * Test is successfull when instance og \Doctrine\ORM\EntityManager is returned.
     *
     * @return void
     */
    public function testEntityManagerCanBeCreated(): void
    {
        $this->assertInstanceOf("\Doctrine\ORM\EntityManager", Bootstrap::getEntityManager());
    }

    /**
    * Test is successfull when instance og App\Controller\App is returned.
    *
    * @return void
    */
    public function testAppCanBoot(): void
    {
        $_SERVER['HTTPS'] = "on";
        $_SERVER['REQUEST_METHOD'] = "GET";
        $_SERVER['REQUEST_URI'] = "/1/article/";
        $_SERVER['REMOTE_ADDR'] = "192.168.0.1";
        $this->assertInstanceOf("App\Controller\App", Bootstrap::boot());
    }
}
