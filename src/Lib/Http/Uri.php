<?php
declare(strict_types = 1);
namespace App\Lib\Http;

use Exception;

class Uri
{
    private const URL_PATH = "path";

    /**
     * @var array<string>
     */
    private $path;

    public function __construct(string $url = "")
    {
        $url = parse_url($url);
        if (is_array($url)) {
            $path = array_key_exists(self::URL_PATH, $url) ? $url[self::URL_PATH] : "";
        } else {
            throw new \Exception("Parsed URL not corespondig with required standard!");
        }
        $this->setPath($path);
    }

    /**
     * Sets path.
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
     * Returns path.
     *
     * @param boolean $original
     * @return array<string>
     */
    public function getPath($original = false): array
    {
        return $original ? $this->path : array_slice($this->path, 1);
    }
}
