<?php
declare(strict_types = 1);
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
     * @var array<string>
     */
    private $access;

    /**
     * Creates instance of Route class.
     *
     * @param integer $version
     * @param string $method
     * @param string $pattern
     * @param string $action
     * @param array<int|string> $params
     * @param array<string> $access
     */
    public function __construct(int $version, string $method, string $pattern, string $action, array $params = [], array $access = [])
    {
        $this->version = $version;
        $this->setMethod($method);
        $this->pattern = $pattern;
        $this->action = $action;
        $this->setParams($params);
        $this->access = $access;
    }

    /**
     * Returns route version.
     *
     * @return integer
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * Sets route HTTP method.
     *
     * @param string $method
     * @return void
     */
    private function setMethod(string $method)
    {
        if (in_array($method, ["GET", "POST", "PUT", "DELETE"])) {
            $this->method = $method;
        } else {
            throw new \Exception("Bad request method!");
        }
    }

    /**
     * Returns route HTTP method.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Returns regulat expression pattern.
     *
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * Returns route action.
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Sets route params.
     *
     * @param array<int|string> $params
     * @return void
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Returns action params.
     *
     * @return array<int|string>
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Returns deined access to route.
     *
     * @return array<string>
     */
    public function getAccess(): array
    {
        return $this->access;
    }
}
