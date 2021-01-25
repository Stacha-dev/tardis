<?php

declare(strict_types=1);

namespace App\Lib\Assert;

class Text
{
    /**
     * Test string for email address
     *
     * @return bool
     */
    public static function isEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) === false ? false : true;
    }

    
    /**
     * Test string for max length
     *
     * @return bool
     */
    public static function hasMax(int $lim, string $str): bool
    {
        return strlen($str) <= $lim;
    }


    /**
     * Test string for min length
     *
     * @return bool
     */
    public static function hasMin(int $lim, string $str): bool
    {
        return strlen($str) >= $lim;
    }
}
