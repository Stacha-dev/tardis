<?php
declare(strict_types = 1);
namespace App\Lib\Authorization;

use App\Lib\Authorization\Jwt;
use Exception;

final class AuthorizationFactory
{
    /**
     * Creates authorization service by proidet type
     *
     * @param string $type
     * @return Jwt
     */
    public static function fromType(string $type)
    {
        $authorization = __NAMESPACE__ . "\\" . ucfirst(strtolower($type));
        if (!class_exists($authorization)) {
            throw new Exception(
                "Type '$type' has not been defined!"
            );
        }

        return new $authorization;
    }
}
