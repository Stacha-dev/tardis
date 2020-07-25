<?php
declare(strict_types = 1);
namespace App\Lib\Middleware;

use App\Lib\Middleware\Route;

class RouteFactory
{
    /**
     * Creates route from constatns
     *
     * @param integer $version
     * @param string $method
     * @param string $pattern
     * @param string $action
     * @param array<string> $params
     * @param bool $secure
     * @return \App\Lib\Middleware\Route
     */
    public static function fromConstants(int $version, string $method, string $pattern, string $action, array $params = [], bool $secure = false): \App\Lib\Middleware\Route
    {
        return new Route($version, $method, $pattern, $action, $params, $secure);
    }
}
