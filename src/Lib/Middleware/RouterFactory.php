<?php
declare(strict_types = 1);
namespace App\Lib\Middleware;

class RouterFactory {
	public static function fromRequest(\App\Lib\Http\Request $request) {
		return new Router($request);
	}
}