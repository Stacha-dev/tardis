<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Configuration\ConfigurationFactory;

final class ConfigurationTest extends TestCase
{
    /**
     * Test is successful if instance of App\Lib\Configuration\Configuration is created
     *
     * @return void
     */
    public function testInstanceCanBeCreated()
    {
        $this->assertInstanceOf("App\Lib\Configuration\Configuration", ConfigurationFactory::fromFileName('api'));
    }

    /**
     * Test is successful if exception is cached
     *
     * @return void
     */
    public function testInstanceCanNotBeCreated()
    {
        $this->expectException("Exception");
        ConfigurationFactory::fromFileName('test');
    }

    /**
     * Test is successful if segment is returned
     *
     * @return void
     */
    public function testSegmentCanBeReturned()
    {
        $configuration = ConfigurationFactory::fromFileName('api');
        $this->assertSame(4, count($configuration->getSegment('Access-Control')));
    }

    /**
     * Test is successful if exception is cached
     *
     * @return void
     */
    public function testSegmentCanNotBeReturned()
    {
        $this->expectException("Exception");
        $configuration = ConfigurationFactory::fromFileName('api');
        $configuration->getSegment('test');
    }

    /**
     * Test is successful if exception is cached
     *
     * @return void
     */
    public function testSegmentCanNotBeSet()
    {
        $this->expectException("Exception");
        $configuration = ConfigurationFactory::fromFileName('api');
        $configuration->setSegment('test');
    }

    /**
     * Test is successful if configuration is returned
     *
     * @return void
     */
    public function testConfigurationCanBeReturned()
    {
        $configuration = ConfigurationFactory::fromFileName('api');
        $this->assertSame('3600', $configuration->get('Max-Age'));
    }

    /**
     * Test is successful if exception is cached
     *
     * @return void
     */
    public function testConfigurationCanNotBeReturned()
    {
        $this->expectException("Exception");
        $configuration = ConfigurationFactory::fromFileName('api');
        $configuration->get('test');
    }
}
