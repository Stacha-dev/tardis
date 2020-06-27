<?php
declare(strict_types = 1);
namespace App\Lib\Http;

use Exception;
use App\Lib\Http\Query;

define("URL_PATH", "path");
define("URL_QUERY", "query");

class Uri
{
    /**
     * @var array<string>
     */
    private $path;

    /**
     * @var \App\Lib\Http\Query
     */
    private $query;

    public function __construct(string $url = "")
    {
        $url = parse_url($url);
        if (is_array($url)) {
            $path = array_key_exists(URL_PATH, $url) ? $url[URL_PATH] : "";
            $query = array_key_exists(URL_QUERY, $url) ? $url[URL_QUERY] : "";
        } else {
            throw new \Exception("Parsed URL not corespondig with required standard!");
        }
        $this->setPath($path);
        $this->setQuery($query);
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
     * @return array<string>
     */
    public function getPath(): array
    {
        return $this->path;
    }

    /**
     * Sets query
     *
     * @param  string $query
     * @return void
     */
    private function setQuery(string $query)
    {
        $this->query = new Query($query);
    }

    /**
     * Returns query.
     *
     * @return Query
     */
    public function getQuery(): Query
    {
        return $this->query;
    }

    /**
     * Parse query to params
     *
     * @param  string $query
     * @return array<array<string>>
     */
    private function parseQuery(string $query): array
    {
        $params = array();
        foreach (explode("&", $query) as $param) {
            @list($name, $value) = explode("=", $param);
            array_push($params, array('name' => $name, 'value' => $value));
        }
        return $params;
    }
}
