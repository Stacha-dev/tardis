<?php
declare(strict_types = 1);
namespace App\Lib;

use App\Lib\Uri;

final class UriFactory {
	/**
	 * Creates URI object.
	 *
	 * @param string $url
	 * @return Uri
	 */
	public static function createUriFromString(string $url) {
		return new Uri($url);
	}
}