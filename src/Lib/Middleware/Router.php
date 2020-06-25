<?php
declare(strict_types = 1);

namespace App\Lib\Middleware;

define("PATTERN", "pattern");

class Router {
	private $routes = array();

	private function register(string $method, array $route) {
		$this->routes[$method] = empty($this->routes[$method]) ? array() : $this->routes[$method];
		array_push($this->routes[$method], $route);
	}

	public function get(array $route = array()) {
		$this->register("GET", $route);
	}

	public function dispatch(\App\Lib\Http\Request $request) {
		foreach($this->routes[$request->getMethod()] as $route) {
			$uri = implode("/", $request->getUri()->getPath());

			if(preg_match($route['pattern'], $uri, $matches)) {
				$params = array();
				foreach($route["action"]["params"] as $param) {
					array_push($params, is_numeric($matches[$param]) ? (int)$matches[$param] : $matches[$param]);
				}

				return array("action" => $route["action"]["method"], "params" => $params);
			}
		}
	}
}