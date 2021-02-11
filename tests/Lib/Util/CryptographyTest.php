<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Util\Cryptography;

class CryptographyTest extends TestCase
{
    /**
     * Test is successful if random string is generated
     *
     * @return void
     */
    public function testRandomCanBeGenerated()
    {
        $randoms = array();
        foreach (range(1, 10) as $i) {
            $random = Cryptography::random(10);
            $this->assertIsString($random);
            $this->assertNotContains($random, $randoms);
            array_push($randoms, $random);
        }
    }

    /**
     * Test is successful if string is hashed
     *
     * @return void
     */
    public function testStringCanBeHashed()
    {
        $this->assertIsString(Cryptography::hashHmac("foo", "bar"));
    }
}
