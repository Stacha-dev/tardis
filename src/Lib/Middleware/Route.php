<?php

declare(strict_types=1);

namespace App\Lib\Middleware;

class Route
{
    /**
     * @var int
     */
    private $version;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var string
     */
    private $action;

    /**
     * @var array<int|string>
     */
    private $params;

    /**
     * @var bool
     */
    private $secure;

    /**
     * Creates instance of Route class
     *
     * @param integer $version
     * @param string $method
     * @param string $pattern
     * @param string $action
     * @param array<int|string> $params
     * @param bool $secure
     */
    public function __construct(int $version, string $method, string $pattern, string $action, array $params = [], bool $secure = false)
    {
        $this->version = $version;
        $this->method = $method;
        $this->pattern = $pattern;
        $this->action = $action;
        $this->setParams($params);
        $this->secure = $secure;
    }

    /**
     * Returns route version
     *
     * @return integer
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * Returns route HTTP method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Returns regulat expression pattern
     *
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * Returns route action
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Sets route params
     *
     * @param array<int|string> $params
     * @return void
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Returns action params
     *
     * @return array<int|string>
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Returns secure route state
     *
     * @return bool
     */
    public function isSecure(): bool
    {
        return $this->secure;
    }
}
