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

	/** @var \App\Lib\Http\Uri */
	private $uri;

	/** @var \App\Lib\Http\Body */
	private $body;

	/** @var string */
	private $remoteAddress;

	/** @var string */
	private $accept;

	public function __construct(bool $isSecured, string $method, \App\Lib\Http\Uri $uri, \App\Lib\Http\Body $body, string $remoteAddress, string $accept) {
		$this->isSecured = $isSecured;
		$this->method = $method;
		$this->uri = $uri;
		$this->body = $body;
		$this->remoteAddress = $remoteAddress;
		$this->setAccept($accept);
	}

	/**
	 * Returns requests URI.
	 *
	 * @return \App\Lib\Http\Uri
	 */
	public function getUri(): \App\Lib\Http\Uri {
		return $this->uri;
	}

	/**
	 * Returns requests body.
	 *
	 * @return \App\Lib\Http\Body
	 */
	public function getBody(): \App\Lib\Http\Body {
		return $this->body;
	}

	/**
	 * Returns request method.
	 *
	 * @return string
	 */
	public function getMethod(): string {
		return $this->method;
	}

	/**
	 * Sets accept format.
	 *
	 * @param string $accept
	 * @return void
	 */
	private function setAccept($accept) {
		switch($accept) {
			case "application/json":
				$this->accept = "json";
				break;
			case "application/xml":
				$this->accept = "xml";
				break;
			case "text/html":
				$this->accept = "html";
				break;
			default:
				$this->accept = "json";
		}
	}

	public function getAccept(): string {
		return $this->accept;
	}

	/**
	 * Check if request method is GET.
	 *
	 * @return boolean
	 */
	public function isGet(): bool {
		return $this->getMethod() === "GET";
	}

	/**
	 * Check if request method is POST.
	 *
	 * @return boolean
	 */
	public function isPost(): bool {
		return $this->getMethod() === "POST";
	}

	/**
	 * Check if request method is PUT.
	 *
	 * @return boolean
	 */
	public function isPut(): bool {
		return $this->getMethod() === "PUT";
	}

	/**
	 * Check if request method is DELETE.
	 *
	 * @return boolean
	 */
	public function isDelete(): bool {
		return $this->getMethod() === "DELETE";
	}
}