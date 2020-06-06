<?php
declare(strict_types = 1);
namespace App\Lib;

class Uri {
	static public function fromString($request) {
		$path = trim(parse_url($request, PHP_URL_PATH), "/");
		$query = parse_url($request, PHP_URL_QUERY);
        return array(explode("/", $path, 3), $query);
	}
}