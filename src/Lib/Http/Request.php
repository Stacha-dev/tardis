<?php
declare(strict_types=1);
namespace App\Lib\Http;

/**
 * Request
 *
 * @package http
 */
class Request
{
    /**
     * @var bool
     */
    private $isSecured;

    /**
     * @var string
     */
    private $method;

    /**
     * @var \App\Lib\Http\Uri
     */
    private $uri;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var \App\Lib\Http\Body
     */
    private $body;

    /**
     * @var string
     */
    private $remoteAddress;

    /**
     * @var string
     */
    private $accept;

    /**
     * Creates instance of Request class.
     *
     * @param boolean $isSecured
     * @param string $method
     * @param \App\Lib\Http\Uri $uri
     * @param string $apiKey
     * @param \App\Lib\Http\Body $body
     * @param string $remoteAddress
     * @param string $accept
     */
    public function __construct(bool $isSecured, string $method, \App\Lib\Http\Uri $uri, string $apiKey, \App\Lib\Http\Body $body, string $remoteAddress, string $accept)
    {
        $this->isSecured = $isSecured;
        $this->setMethod($method);
        $this->method = $method;
        $this->uri = $uri;
        $this->apiKey = $apiKey;
        $this->body = $body;
        $this->remoteAddress = $remoteAddress;
        $this->setAccept($accept);
    }

    private function setMethod(string $method):void
    {
        if (in_array($method, array('GET', 'POST', 'PUT', 'DELETE'))) {
            $this->method = $method;
        } else {
            throw new \Exception('Bad request method!');
        }
    }

    /**
     * Returns requests URI.
     *
     * @return \App\Lib\Http\Uri
     */
    public function getUri(): \App\Lib\Http\Uri
    {
        return $this->uri;
    }

    /**
     * Returns api key from request header.
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Returns requests body.
     *
     * @return \App\Lib\Http\Body
     */
    public function getBody(): \App\Lib\Http\Body
    {
        return $this->body;
    }

    /**
     * Returns request method.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Sets accept format.
     *
     * @param  string $accept
     * @return void
     */
    private function setAccept($accept)
    {
        switch ($accept) {
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

    public function getAccept(): string
    {
        return $this->accept;
    }

    public function getResource(): string
    {
        $path = $this->getUri()->getPath();
        return count($path) >= 2 ? $path[1] : "base";
    }
}
