<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Lib\Authorization\AuthorizationFactory;

final class AuthorizationTest extends TestCase
{
    /**
     * Test is successfull if instance of App\Lib\Configuration\Configuration is created
     *
     * @return void
     */
    public function testInstanceCanBeCreated():void
    {
        $this->assertInstanceOf("App\Lib\Authorization\Jwt", AuthorizationFactory::fromType('JWT'));
    }

    /**
     * Test is successfull if exception is cached
     *
     * @return void
     */
    public function testInstanceCanNotBeCreated():void
    {
        $this->expectException("Exception");
        AuthorizationFactory::fromType('test');
    }

    /**
     * Test is successfull if token is returned
     *
     * @return void
     */
    public function testAuthorizationTokenIsReturned():void
    {
        $authorization = AuthorizationFactory::fromType('JWT');
        $this->assertNotEmpty($authorization->getToken());
    }

    /**
     * Test is successfull if token is decoded
     *
     * @return void
     */
    public function testAuthorizationTokenIsDecoded():void
    {
        $authorization = AuthorizationFactory::fromType('JWT');
        $jwt = $authorization->getToken();
        $this->assertInstanceOf('\stdClass', $authorization->authorize($jwt));
    }
}
