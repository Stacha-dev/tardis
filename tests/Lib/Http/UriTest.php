<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Http\Uri;

final class UriTest extends TestCase
{
	/**
	 * Test is successful if instance of URI can be created
	 *
	 * @return void
	 */
	public function testInstanceUriCanBeCreated()
	{
		$uri =  new Uri();
		$this->assertInstanceOf("App\Lib\Http\Uri", $uri);
	}
}
