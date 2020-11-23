<?php
declare(strict_types = 1);
namespace App\Lib\Configuration;

use App\Lib\Configuration\Configuration;
use Exception;

final class ConfigurationFactory
{

    /** @var string */
    private const DIRECTORY = __DIR__ . "/../../../config/";

    /**
     * Creates configuration from filename
     *
     * @param string $fileName
     * @return Configuration
     */
    public static function fromFileName(string $fileName):Configuration
    {
        if (empty($fileName) || !($path = realpath(self::DIRECTORY . $fileName . '.ini'))) {
            throw new Exception('Config file ' . $fileName . ' not exists!');
        }

        return new Configuration($path);
    }
}
