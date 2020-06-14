<?php
declare(strict_types=1);

namespace App\Lib\Http;

class Body {
	/** @var array<string> */
	private $body = array();

	public function __construct() {
		$body = file_get_contents('php://input');
		if (is_string($body))
			$this->body = $this->decodeBody($body) ?? array();
	}

	/**
	 * Sets body by string.
	 *
	 * Type: 1-JSON
	 * @param string $body
	 * @param int $type
	 * @return array<string>
	 */
	private function decodeBody(string $body, int $type = 1): ?array {
		switch($type) {
			case 1:
				$body = json_decode($body, true);
			break;
		}

		return $body;
	}

	/**
	 * Returns requests body.
	 *
	 * @return array<string>
	 */
	public function getBody(): array {
		return $this->body;
	}

	/**
	 * Returns body data by key.
	 *
	 * @param string $key
	 * @return string|null
	 */
	public function getBodyData(string $key): ?string {
		return array_key_exists($key, $this->body) ? $this->body[$key] : NULL;
	}
}