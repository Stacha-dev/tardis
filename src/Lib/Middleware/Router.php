<?php

declare(strict_types=1);

namespace App\Lib\Middleware;

class Router
{
    /**
     * @var array<array<\App\Lib\Middleware\Route>>
     */
    private $routes = array();

    /**
     * Register router HTTP request.
     *
     * @param  \App\Lib\Middleware\Route $route
     * @return \App\Lib\Middleware\Router
     */
    public function register(\App\Lib\Middleware\Route $route): \App\Lib\Middleware\Router
    {
        $this->routes[$route->getMethod()] = empty($this->routes[$route->getMethod()]) ? array() : $this->routes[$route->getMethod()];
        array_push($this->routes[$route->getMethod()], $route);
        return $this;
    }

    /**
     * Returns all registered routes.
     *
     * @return array<array>
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Dispatch request to predefined routes.
     *
     * @param  \App\Lib\Http\Request $request
     * @return \App\Lib\Middleware\Route
     */
    public function dispatch(\App\Lib\Http\Request $request): \App\Lib\Middleware\Route
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();
        $uri = implode("/", $path);
        $version = (int)array_shift($path);
        $routes = $this->getRoutes();

        if (array_key_exists($method, $routes)) {
            foreach ($routes[$method] as $route) {
                if (preg_match($route->getPattern(), $uri, $matches) && $route->getVersion() === $version) {
                    $params = array();
                    foreach ($route->getParams() as $param) {
                        $params[$param] = is_numeric($matches[$param]) ? (int)$matches[$param] : $matches[$param];
                    }
                    $route->setParams($params);
                    return $route;
                }
            }
        }
        throw new \Exception("Route not found!");
    }
}
