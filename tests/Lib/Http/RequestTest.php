<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Http\RequestFactory;
use App\Lib\Http\Request;
use App\Lib\Http\Body;
use App\Lib\Http\Uri;

final class RequestTest extends TestCase
{
    /** @var string */
    private const SAMPLE_REQUEST_METHOD_GET = "GET";

    /** @var string */
    private const SAMPLE_REQUEST_URI = "/api/1/article/1/";

    /** @var \App\Lib\Http\Request */
    private $request;

    public function setUp(): void
    {
        $_SERVER['REQUEST_METHOD'] = self::SAMPLE_REQUEST_METHOD_GET;
        $_SERVER['REQUEST_URI'] = self::SAMPLE_REQUEST_URI;
        $this->request = RequestFactory::fromGlobals();
    }
    /**
     * Test is successful if instance of App\Lib|Http\Request is created
     *
     * @return void
     */
    public function testRequestObjectCanBeCreated()
    {
        $this->assertInstanceOf("App\Lib\Http\Request", RequestFactory::fromGlobals());
    }

    /**
     * Test is successful if request params can be returned
     *
     * @return void
     */
    public function testRequestParamsCanBeReturned()
    {
        $this->assertEquals(self::SAMPLE_REQUEST_METHOD_GET, $this->request->getMethod());
        $this->assertEquals("article", $this->request->getResource());
        $this->assertEquals("", $this->request->getAuthorization());
        $this->assertInstanceOf('\App\Lib\Http\Body', $this->request->getBody());
    }

    /**
     * Test is successful if request accept can be setted
     *
     * @return void
     */
    public function testAcceptCanBeSetted()
    {
        $body = new Body();
        $uri = new Uri(self::SAMPLE_REQUEST_URI);
        $xmlRequest = new Request(true, self::SAMPLE_REQUEST_METHOD_GET, $uri, "", $body, "", "application/xml");
        $jsonRequest = new Request(true, self::SAMPLE_REQUEST_METHOD_GET, $uri, "", $body, "", "application/json");
        $htmlRequest = new Request(true, self::SAMPLE_REQUEST_METHOD_GET, $uri, "", $body, "", "text/html");

        $this->assertEquals("xml", $xmlRequest->getAccept());
        $this->assertEquals("json", $jsonRequest->getAccept());
        $this->assertEquals("html", $htmlRequest->getAccept());
    }

    /**
     * Test is successful if request with invalid request method can not be created
     *
     * @return void
     */
    public function testRequestWithInvalidMethodCanNotBeCreated()
    {
        $body = new Body();
        $uri = new Uri(self::SAMPLE_REQUEST_URI);
        $this->expectException("Exception");
        $request = new Request(true, "TEST", $uri, "", $body, "", "application/json");
    }
}
