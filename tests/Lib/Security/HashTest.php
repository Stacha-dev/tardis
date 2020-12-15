<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Security\Hash;

final class HashTest extends TestCase
{
  /** @var string */
	private const SAMPLE_TEXT = 'test_string';

    /**
     * Test is successfull if hash string is returned
     *
     * @return void
     */
    public function testHashCanBeGenerated():void
    {
		$this->assertNotEmpty(Hash::getHash(self::SAMPLE_TEXT));
	}
}
