<?php

declare(strict_types=1);

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
     * Boot instace of App
     *
     * @return \App\Controller\App
     */
    public static function boot(): \App\Controller\App
    {
        if (php_sapi_name() === 'cli') {
            $_SERVER['HOME'] = realpath(__DIR__ . "/../../");
        }
        return new App(\App\Lib\Http\RequestFactory::fromGlobals(), self::getEntityManager());
    }

    /**
     * Returns instance of EntityManager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public static function getEntityManager(): \Doctrine\ORM\EntityManager
    {
        $memcached = new Memcached();
        $memcached->addServer('127.0.0.1', 11211);

        $memchachedDriver = new MemcachedCache();
        $memchachedDriver->setMemcached($memcached);

        $phpFileCacheDriver = new \Doctrine\Common\Cache\PhpFileCache(
            __DIR__ . '/../tmp'
        );

        /** @todo seek for better aproach */
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/Model/Entity"), false, null, null, false);
        $config->setProxyDir(__DIR__ . '/../tmp/Proxies');
        $config->setProxyNamespace('App\Proxies');
        $config->setQueryCacheImpl($memchachedDriver);
        $config->setResultCacheImpl($memchachedDriver);
        $config->setMetadataCacheImpl($phpFileCacheDriver);

        $common = ConfigurationFactory::fromFileName('common');

        return EntityManager::create($common->getSegment('db'), $config);
    }
}
