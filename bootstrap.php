<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Controller\App;
use App\Lib\Http\RequestFactory;

require_once "vendor/autoload.php";

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Model/Entity"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

$dbParams = parse_ini_file(__DIR__ . "/config/common.ini", true, INI_SCANNER_RAW);

$entityManager = EntityManager::create($dbParams['db'], $config);

$app = new App(RequestFactory::fromGlobals(), $entityManager);