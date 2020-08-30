<?php
declare(strict_types=1);
namespace App\Lib\Http;

class Query
{
	private const QUERY_PARAM_NAME = "name";

	private const QUERY_PARAM_VALUE = "value";

    /**
     * @var array<array<string>>
     */
    private $query = array();

    public function __construct(string $query = '')
    {
        $this->setQuery($query);
    }

    /**
     * Sets query
     *
     * @param  string $query
     * @return void
     */
    private function setQuery(string $query)
    {
        $this->query = $this->parseQuery($query);
    }

    /**
     * Returns query.
     *
     * @return array<int, array<string, string>>
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * Returns query.
     *
     * @return string|null
     */
    public function getQueryParamValue(string $param): ?string
    {
        $key = array_search($param, array_column($this->query, self::QUERY_PARAM_NAME));
        return $this->query[$key][self::QUERY_PARAM_VALUE];
    }

    /**
     * Parse query to params
     *
     * @param  string $query
     * @return array<int, array<string, string>>
     */
    private function parseQuery(string $query): array
    {
        $params = array();
        foreach (explode("&", $query) as $param) {
            @list($name, $value) = explode("=", $param);
            if (!empty($name) && !empty($value)) {
                array_push($params, array(self::QUERY_PARAM_NAME => $name, self::QUERY_PARAM_VALUE => $value));
            }
        }
        return $params;
    }
}
