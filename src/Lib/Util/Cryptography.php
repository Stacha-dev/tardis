<?php
declare(strict_types = 1);
namespace App\Lib\Util;

class Cryptography
{
    /**
     * Generates random string.
     *
     * @param integer $length
     * @return string
     */
    public static function random(int $length = 10): string
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * Hash content by provided key.
     *
     * @param string $content
     * @param string $key
     * @return string
     */
    public static function hashHmac(string $content, string $key): string
    {
        return hash_hmac("md5", $content, $key);
    }
}
