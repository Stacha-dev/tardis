<?php
declare(strict_types = 1);

namespace App\Lib\Middleware;


class Router {
	/** @var array<array|string> */
	private $routes = array();

	/**
	 * Register route by HTTP method.
	 *
	 * @param string $method
	 * @param array $route<array|string>
	 * @return void
	 */
	private function register(string $method, array $route): void {
		$this->routes[$method] = empty($this->routes[$method]) ? array() : $this->routes[$method];
		array_push($this->routes[$method], $route);
	}

	/**
	 * Register GET route.
	 *
	 * @param array $route<array<string>|string>
	 * @return void
	 */
	public function get(array $route): void {
		$this->register("GET", $route);
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

			if(preg_match($route['pattern'], $uri, $matches)) {
				$params = array();
				foreach($route["action"]["params"] as $param) {
					array_push($params, is_numeric($matches[$param]) ? (int)$matches[$param] : $matches[$param]);
				}

				return array("action" => $route["action"]["method"], "params" => $params);
			}
		}
		throw new \Exception("Route nout found!");
	}
}