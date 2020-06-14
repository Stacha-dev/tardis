<?php
declare(strict_types=1);

namespace App\Lib\Http;

class Body {
	/** @var string */
	private $body = array();

	public function __construct() {
		$json = file_get_contents('php://input');
		$this->setBody($json);
	}

	/**
	 * Sets body by string.
	 *
	 * @param string $json
	 * @return void
	 */
	private function setBody(string $json) {
		$this->body = json_decode($json, true);
	}

	/**
	 * Returns requests body.
	 *
	 * @return array
	 */
	public function getBody(): array {
		return $this->body;
	}

	/**
	 * Returns body data by key.
	 *
	 * @param string $key
	 * @return string
	 */
	public function getBodyData(string $key): string {
		return $this->body[$key];
	}
}