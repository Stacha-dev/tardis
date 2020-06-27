<?php
declare(strict_types = 1);
namespace App\Lib\Http;

use App\Lib\Http\Request;
use App\Lib\Http\Uri;
use App\Lib\Http\Body;

/**
 * Request factory creates instance of Request class.
 *
 * Example usage:
 * $request = RequestFactory::fromGlobals();
 */
class RequestFactory
{

    /**
     * Returns new instance of Uri class by URI.
     *
     * @param  string $uri
     * @static
     * @return \App\Lib\Http\Uri
     */
    private static function getUri(string $uri): \App\Lib\Http\Uri
    {
        return new Uri($uri);
    }

    /**
     * Returns new instance of Body class.
     *
     * @static
     * @return \App\Lib\Http\Body
     */
    private static function getBody(): \App\Lib\Http\Body
    {
        return new Body();
    }

    /**
     * Returns new instance of Request class from server globals.
     *
     * @static
     * @return \App\Lib\Http\Request
     */
    public static function fromGlobals(): \App\Lib\Http\Request
    {
        return new Request($_SERVER['HTTPS'] === 'on', $_SERVER['REQUEST_METHOD'], self::getUri($_SERVER['REQUEST_URI']), self::getBody(), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_ACCEPT'] ?? "");
    }
}
