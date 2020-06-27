<?php
declare(strict_types = 1);

namespace App;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Controller\App;

define("DB_CONFIG", "db");

class Bootstrap
{
    /**
     * Boot instace of App.
     *
     * @return \App\Controller\App
     */
    public static function boot(): \App\Controller\App
    {
        return new App(\App\Lib\Http\RequestFactory::fromGlobals(), self::getEntityManager());
    }

    /**
     * Returns instance of EntityManager.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public static function getEntityManager(): \Doctrine\ORM\EntityManager
    {
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/Model/Entity"), true, null, null, false);
        $dbParams = parse_ini_file(__DIR__ . "/../config/common.ini", true, INI_SCANNER_RAW) ?? [];
        if (!(is_array($dbParams) && array_key_exists(DB_CONFIG, $dbParams))) {
            throw new \Exception("Bad configuration file! Check DB credentials.");
        }
        return EntityManager::create($dbParams[DB_CONFIG], $config);
    }
}
