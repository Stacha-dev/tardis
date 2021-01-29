<?php

declare(strict_types=1);

namespace App\Lib\Configuration;

use App\Lib\Configuration\Configuration;
use Exception;

final class ConfigurationFactory
{

    /** @var string */
    private const CONFIG_DIRECTORY = __DIR__ . "/../../../config/";

    /**
     * Creates configuration from filename
     *
     * @param string $fileName
     * @return Configuration
     */
    public static function fromFileName(string $fileName): Configuration
    {
        $configs = glob(self::CONFIG_DIRECTORY . $fileName . '*' . 'ini');
        if ($configs && is_array($configs)) {
            $config = array_pop($configs);
            return new Configuration($config);
        } else {
            throw new Exception('Config file "' . $fileName . '" not exists!', 400);
        }
    }
}
