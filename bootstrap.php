<?php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Controller\App;
use App\Lib\Http\RequestFactory;

/**
 * Doctrine ORM config
 */
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Model/Entity"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
$dbParams = parse_ini_file(__DIR__ . "/config/common.ini", true, INI_SCANNER_RAW);

/**
 * Create new instance of App.
 */
$app = new App(RequestFactory::fromGlobals(), EntityManager::create($dbParams['db'], $config));