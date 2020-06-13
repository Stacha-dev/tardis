<?php
declare(strict_types=1);
namespace App\Lib\Http;

/**
 * Request
 * @package http
 */
class Request {
	/** @var bool */
	private $isSecured;

	/** @var string */
	private $method;

	/** @var App\Lib\Http\Uri */
	private $uri;

	/** @var string */
	private $remoteAddress;

	public function __construct(bool $isSecured, string $method, \App\Lib\Http\Uri $uri, string $remoteAddress) {
		$this->isSecured = $isSecured;
		$this->method = $method;
		$this->uri = $uri;
		$this->remoteAddress = $remoteAddress;
	}

	/**
	 * Gets instance of Uri.
	 *
	 * @return \App\Lib\Http\Uri
	 */
	public function getUri(): \App\Lib\Http\Uri {
		return $this->uri;
	}

}