<?php
declare(strict_types = 1);

namespace App\Lib\Rest;


class Router {
	private $routes = array();

	public function register(string $method="", string $uri="", array $action=[]){
		array_push($this->routes, array("method" => $method, "uri" => $uri, "action" => $action));
	}
}