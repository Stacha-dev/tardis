<?php
declare(strict_types = 1);
namespace App\Lib\Authorization;

use App\Lib\Authorization\Base;

class Jwt extends Base
{
    private const SERVER_NAME = 'servername';

    /** @var string */
    private $key = '';

    public function __construct()
    {
        parent::__construct();
        $this->key = $this->configuration->get('jwt_key');
    }

    /**
     * Returns JWT
     *
     * @param array<string|int> $data
     * @return string
     */
    public function getToken(array $data):string
    {
        $issuedAt   = time();
        $notBefore  = $issuedAt + 10;

        $payload = array(
            "iss" => self::SERVER_NAME,
            "iat" => $issuedAt,
            "nbf" => $notBefore,
            'data' => $data
        );

        return \Firebase\JWT\JWT::encode($payload, $this->key);
    }

    /**
     * Authorize providet JWT
     *
     * @param string $token
     * @return void
     */
    public function authorize(string $token):void
    {
        \Firebase\JWT\JWT::decode($token, $this->key, array('HS256'));
    }
}
