<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Authorization\AuthorizationFactory;

final class AuthorizationTest extends TestCase
{
    /**
     * Test is successful if instance of App\Lib\Configuration\Configuration is created
     *
     * @return void
     */
    public function testInstanceCanBeCreated()
    {
        $this->assertInstanceOf("App\Lib\Authorization\Jwt", AuthorizationFactory::fromType('JWT'));
    }

    /**
     * Test is successful if exception is cached
     *
     * @return void
     */
    public function testInstanceCanNotBeCreated()
    {
        $this->expectException("Exception");
        AuthorizationFactory::fromType('test');
    }

    /**
     * Test is successful if token is returned
     *
     * @return void
     */
    public function testAuthorizationTokenIsReturned()
    {
        $authorization = AuthorizationFactory::fromType('JWT');
        $this->assertNotEmpty($authorization->getToken());
    }

    /**
     * Test is successful if token is decoded
     *
     * @return void
     */
    public function testAuthorizationTokenIsDecoded()
    {

        $authorization = AuthorizationFactory::fromType('JWT');
        $jwt = $authorization->getToken();
        $this->assertInstanceOf('\stdClass', $authorization->authorize('Bearer ' . $jwt));
    }
}
