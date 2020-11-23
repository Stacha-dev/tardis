<?php
declare(strict_types = 1);

namespace App;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Controller\App;
use App\Lib\Configuration\ConfigurationFactory;

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
        $configuration = ConfigurationFactory::fromFileName('common');

        return EntityManager::create($configuration->getSegment('db'), $config);
    }
}
