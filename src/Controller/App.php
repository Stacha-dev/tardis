<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Lib\Http\Uri;
use App\Lib\Middleware\Router;
use App\View\Error;
use Exception;

class App
{
    public function __construct(\App\Lib\Http\Request $request, \Doctrine\ORM\EntityManager $entityManager)
    {
        try {
            $this->controllerFactory($request, $entityManager)->requestDispatch(new \App\Lib\Middleware\Router, $request);
        } catch (Exception $e) {
            error_log($e->getMessage());
            Error::render($e->getMessage(), 400);
        }
    }

    private function controllerFactory(\App\Lib\Http\Request $request, \Doctrine\ORM\EntityManager $entityManager): \App\Controller\Base
    {
        $path = $request->getUri()->getPath();
        $controller = count($path) >= 2 ? $path[1] : "base";

        $controller = __NAMESPACE__ . "\\" . ucfirst(strtolower($controller));
        if (!class_exists($controller)) {
            throw new Exception(
                "The controller '$controller' has not been defined."
            );
        }
        $controller = new $controller($entityManager);

        $controller->setView($request->getAccept());
        $controller->setRequest($request);
        return $controller;
    }
}
