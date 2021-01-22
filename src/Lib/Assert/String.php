<?php
declare(strict_types = 1);
namespace App\Lib\Assert;


/**
 * Test string for email address
 * 
 * @return bool
 */
public function isEmail(string $email):bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
