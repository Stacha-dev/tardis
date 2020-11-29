<?php
declare(strict_types = 1);

namespace App;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Cache\MemcachedCache;
use App\Controller\App;
use App\Lib\Configuration\ConfigurationFactory;
use Memcached;

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
        $memcached = new Memcached();
        $memcached->addServer('127.0.0.1', 11211);

        $cacheDriver = new MemcachedCache();
        $cacheDriver->setMemcached($memcached);

        /** @todo seek for better aproach */
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/Model/Entity"), false, null, null, false);
        $config->setProxyDir(__DIR__ . '/../tmp/Proxies');
        $config->setProxyNamespace('App\Proxies');
        $config->setQueryCacheImpl($cacheDriver);
        $config->setResultCacheImpl($cacheDriver);
        $config->setMetadataCacheImpl($cacheDriver);

        $common = ConfigurationFactory::fromFileName('common');

        return EntityManager::create($common->getSegment('db'), $config);
    }
}
