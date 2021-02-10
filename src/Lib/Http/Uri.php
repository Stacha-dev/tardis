<?php

declare(strict_types=1);

namespace App\Lib\Http;

class Uri
{
    /**
     * @var array<string>
     */
    private $path;

    public function __construct(string $url = "")
    {
        $path = parse_url($url, PHP_URL_PATH);
        $this->setPath(is_string($path) ? $path : '');
    }

    /**
     * Sets path
     *
     * @param  string $path
     * @return void
     */
    private function setPath(string $path)
    {
        $path = trim($path, "/");
        $this->path = explode("/", $path);
    }

    /**
     * Returns path
     *
     * @param boolean $original
     * @return array<string>
     */
    public function getPath($original = false): array
    {
        return $original ? $this->path : array_slice($this->path, 1);
    }
}
