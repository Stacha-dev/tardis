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
    public static function isEmail(string $str): bool
    {
        return filter_var($str, FILTER_VALIDATE_EMAIL) === false ? false : true;
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


    /**
     * Test if string is date
     *
     * @return bool
     */
    public static function isTimestamp(string $str): bool
    {
        $ts = \App\Lib\Util\Timestamp::timestampToArray($str);
        if (checkdate($ts['m'], $ts['d'], $ts['y']) &&
            $ts['h'] >= 0 && $ts['h'] <= 23 &&
            $ts['i'] >= 0 && $ts['i'] <= 59 &&
            $ts['s'] >= 0 && $ts['s'] <= 59) {
            return true;
        } else {
            return false;
        }
    }
}
