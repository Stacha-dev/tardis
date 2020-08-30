<?php
declare(strict_types = 1);

namespace App;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Controller\App;

class Bootstrap
{
    /** @var string */
    private const DB_CONFIG = "db";
    /**
     * Boot instace of App.
     *
     * @return \App\Controller\App
     */
    public static function boot(): \App\Controller\App
    {
        self::setResponseHeaders();
        return new App(\App\Lib\Http\RequestFactory::fromGlobals(), self::getEntityManager());
    }

    /**
     * Sets response headers by ini file.
     *
     * @return void
     */
    private static function setResponseHeaders(): void
    {
        $config = parse_ini_file(__DIR__ . "/../config/api.ini", true);
        if (is_array($config)) {
            foreach ($config as $section => $ruleSet) {
                foreach ($ruleSet as $rule => $value) {
                    if (is_array($value)) {
                        $header = $section . "-" . $rule . ": ";
                        foreach ($value as $i => $subValue) {
                            $header .= $i !== array_key_last($value) ? $subValue."," : $subValue;
                        }
                        header($header);
                    } else {
                        header($section . "-" . $rule . ": " . $value);
                    }
                }
            }
        } else {
            throw new \Exception('Bad config file!');
        }
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
        if (!(is_array($dbParams) && array_key_exists(self::DB_CONFIG, $dbParams))) {
            throw new \Exception("Bad configuration file! Check DB credentials.");
        }
        return EntityManager::create($dbParams[self::DB_CONFIG], $config);
    }
}
