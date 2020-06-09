<?php
declare(strict_types = 1);
namespace App\Lib;

use Exception;

class Uri {
	/** @var string */
	private $path;
	/** @var array */
	private $query;

	public function __construct(string $url = NULL) {
		$url = @parse_url($url);
		$this->setPath($url['path'] ?? '');
		$this->setQuery($url['query'] ?? []);
	}
	/**
	 * Creates URI from string.
	 *
	 * @param string $url
	 * @return array<int, array<int, string>|string|false|null>
	 */
	static public function fromString(string $url = "/") {
		$url = trim($url, "/");
		if(!empty($url)){
			$path = ltrim(parse_url($url, PHP_URL_PATH), "/");
			$query = parse_url($url, PHP_URL_QUERY);
			return array(explode("/", $path, 3), $query);
		} else {
			throw new Exception('Invalid URL!');
		}
	}

	/**
	 * Sets path.
	 *
	 * @param string $path
	 * @return void
	 */
	private function setPath(string $path) {
		$path = trim($path, "/");
		$this->path = $path;
	}

	/**
	 * Returns path.
	 *
	 * @return array
	 */
	public function getPath(): array {
		return $this->path;
	}

	/**
	 * Sets query
	 *
	 * @param string|array $query
	 * @return void
	 */
	private function setQuery($query) {
		$this->query = is_string($query) ? $this->parseQuery($query) : $query;
	}

	/**
	 * Returns query.
	 *
	 * @return array
	 */
	public function getQuery(): array {
		return $this->query;
	}

	/**
	 * Parse query to params
	 *
	 * @param string $query
	 * @return array
	 */
	private function parseQuery(string $query): array{
		$params = array();
		foreach(explode("&",$query) as $param) {
			@list($name, $value) = explode("=", $param);
			array_push($params, array('name' => $name, 'value' => $value));
		}
		return $params;
	}
}