<?php
declare(strict_types=1);
namespace App\Lib\Http;

define("QUERY_PARAM_NAME","name");
define("QUERY_PARAM_VALUE","value");

class Query{
	private $query = array();

	public function __construct(string $query='') {
		$this->setQuery($query);
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
	 * Returns query.
	 *
	 * @return array
	 */
	public function getQueryParam(string $param): array {
		$key = array_search($param, array_column($this->query, QUERY_PARAM_NAME));
		return $this->query[$key];
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
			if (!empty($name) && !empty($value))
				array_push($params, array(QUERY_PARAM_NAME => $name, QUERY_PARAM_VALUE => $value));
		}
		return $params;
	}
}