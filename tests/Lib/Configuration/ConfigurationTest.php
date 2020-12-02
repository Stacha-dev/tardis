<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Lib\Configuration\ConfigurationFactory;

final class ConfigurationTest extends TestCase
{
    /**
     * Test is successfull if instance of App\Lib\Configuration\Configuration is created
     *
     * @return void
     */
    public function testInstanceCanBeCreated():void
    {
        $this->assertInstanceOf("App\Lib\Configuration\Configuration", ConfigurationFactory::fromFileName('api'));
    }

    /**
     * Test is successfull if exception is cached
     *
     * @return void
     */
    public function testInstanceCanNotBeCreated():void
    {
        $this->expectException("Exception");
        ConfigurationFactory::fromFileName('test');
    }

    /**
     * Test is successfull if segment is returned
     *
     * @return void
     */
    public function testSegmentCanBeReturned():void
    {
        $configuration = ConfigurationFactory::fromFileName('api');
        $this->assertSame(4, count($configuration->getSegment('Access-Control')));
    }

    /**
     * Test is successfull if exception is cached
     *
     * @return void
     */
    public function testSegmentCanNotBeReturned():void
    {
        $this->expectException("Exception");
        $configuration = ConfigurationFactory::fromFileName('api');
        $configuration->getSegment('test');
    }

    /**
     * Test is successfull if exception is cached
     *
     * @return void
     */
    public function testSegmentCanNotBeSet():void
    {
        $this->expectException("Exception");
        $configuration = ConfigurationFactory::fromFileName('api');
        $configuration->setSegment('test');
    }

    /**
     * Test is successfull if configuration is returned
     *
     * @return void
     */
    public function testConfigurationCanBeReturned():void
    {
        $configuration = ConfigurationFactory::fromFileName('api');
        $this->assertSame('3600', $configuration->get('Max-Age'));
    }

    /**
     * Test is successfull if exception is cached
     *
     * @return void
     */
    public function testConfigurationCanNotBeReturned():void
    {
        $this->expectException("Exception");
        $configuration = ConfigurationFactory::fromFileName('api');
        $configuration->get('test');
    }
}
