<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Http\Body;

final class BodyTest extends TestCase
{
	/** @var string */
	private const JSON_CONTENT_TYPE = "application/json";

	/** @var string */
	private const FORM_DATA_CONTENT_TYPE = "multipart/form-data";

	/**
	 * Test is successful if instance of URI can be created
	 *
	 * @return void
	 */
	public function testInstanceUriCanBeCreated()
	{
		$uri = new Body();
		$this->assertInstanceOf("App\Lib\Http\Body", $uri);
	}

	/**
	 * Test is successful if content type can be setted
	 *
	 * @return void
	 */
	public function testContentTypeCanBeSetted()
	{
		$_SERVER['CONTENT_TYPE'] = self::JSON_CONTENT_TYPE;
		$jsonContentType = new Body();
		$this->assertEquals($jsonContentType->getContentType(), self::JSON_CONTENT_TYPE);
		$_SERVER['CONTENT_TYPE'] = self::FORM_DATA_CONTENT_TYPE;
		$formDataContentType = new Body();
		$this->assertEquals($formDataContentType->getContentType(), self::FORM_DATA_CONTENT_TYPE);
	}

	/**
	 * Test is successful if body params can be setted
	 *
	 * @return void
	 */
	public function testBodyPayloadCanBeReturned()
	{
		$body = new Body();
		$this->assertEquals(count($body->getBody()), 0);
		$this->assertEquals(count($body->getFiles()), 0);
		$this->assertNull($body->getBodyData("", null));
	}
}
