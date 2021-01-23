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
}
