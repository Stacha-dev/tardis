<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Security\Hash;

final class HashTest extends TestCase
{
  /** @var string */
  private const SAMPLE_TEXT = 'test_string';
  
  /** @var string */
  private const SAMPLE_WRONG_TEXT = 'wrong_string';

  /** @var string */
  private const SAMPLE_LONG_INPUT = '123457890123456789012345678901234'; // chars more than 32

    /**
     * Test is successfull if hash string is returned
     *
     * @return void
     */
    public function testHashCanBeGenerated():void
    {
      $this->assertNotEmpty(Hash::getHash(self::SAMPLE_TEXT));
    }
    

    /**
     * Test if correct hash can be verified
     *
     * @return void
     */
    public function testHashCanBeVerified():void
    {
      $hash = Hash::getHash(self::SAMPLE_TEXT);
      $this->assertTrue(Hash::verifyHash(self::SAMPLE_TEXT, $hash));
    }


    /**
     * Test if wrong hash can be verified
     *
     * @return void
     */
    public function testHashCantBeVerified():void
    {
      $hash = Hash::getHash(self::SAMPLE_TEXT);
      $this->assertFalse(Hash::verifyHash(self::SAMPLE_WRONG_TEXT, $hash));
    }


    /**
     * Test if input string is too long
     *
     * @return void
     */
    public function testInputStringTooLong():void
    {
      $this->expectException("Exception");
      Hash::getHash(self::SAMPLE_LONG_INPUT);
    }
}
