<?php
declare(strict_types = 1);

namespace App\Lib\Middleware;


class Router {
	/** @var array<array<array|string>> */
	private $routes = array();

	/**
	 * Register router HTTP request.
	 *
	 * @param array<array|string|int> $route
	 * @return void
	 */
	public function register(array $route): void {
		$method = strval($route['method']);
		$this->routes[$method] = empty($this->routes[$method]) ? array() : $this->routes[$method];
		array_push($this->routes[$method], $route);
	}

	/**
	 * Dispatch request to predefined routes.
	 *
	 * @param \App\Lib\Http\Request $request
	 * @return array<array|string>
	 */
	public function dispatch(\App\Lib\Http\Request $request): array {
		foreach((array)$this->routes[$request->getMethod()] as $route) {
			$uri = implode("/", $request->getUri()->getPath());

			if(is_array($route) && array_key_exists("pattern", $route) && preg_match($route['pattern'], $uri, $matches)) {
				$params = array();
				foreach($route["action"]["params"] as $param) {
					array_push($params, is_numeric($matches[$param]) ? (int)$matches[$param] : $matches[$param]);
				}

				return array("action" => (string)$route["action"]["method"], "params" => $params);
			}
		}
		throw new \Exception("Route nout found!");
	}
}