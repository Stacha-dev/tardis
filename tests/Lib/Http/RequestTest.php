<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{
    /** @var \App\Lib\Http\Request */
    private $request;

    public function setUp(): void
    {
        $_SERVER['HTTPS'] = "on";
        $_SERVER['REQUEST_METHOD'] = "GET";
        $_SERVER['REQUEST_URI'] = "/api/1/article/";
        $_SERVER['REMOTE_ADDR'] = "1.1.1.1";
        $this->request = \App\Lib\Http\RequestFactory::fromGlobals();
    }
    /**
     * Test is successfull if instance of App\Lib|Http\Request is created.
     *
     * @return void
     */
    public function testRequestObjectCanBeCreated(): void
    {
        $_SERVER['HTTPS'] = "on";
        $_SERVER['REQUEST_METHOD'] = "GET";
        $_SERVER['REQUEST_URI'] = "/api/1/article/aa";
        $_SERVER['REMOTE_ADDR'] = "1.1.1.1";
        $this->assertInstanceOf("App\Lib\Http\Request", \App\Lib\Http\RequestFactory::fromGlobals());
    }

    /**
     * Test is sucessfull if instance of App\Lib\Http\Body is returned.
     *
     * @return void
     */
    public function testRequestBodyIsReturned(): void
    {
        $this->assertInstanceOf("App\Lib\Http\Body", $this->request->getBody());
    }

    /**
     * Test is sucessful if request method is GET.
     *
     * @return void
     */
    public function testRequestMethodIsReturned(): void
    {
        $this->assertSame($this->request->getMethod(), "GET");
    }

    /**
     * Test is sucessful if resource name "article" is returned.
     *
     * @return void
     */
    public function testRequestResourceIsReturned(): void
    {
        $this->assertSame($this->request->getResource(), "article");
    }
}
