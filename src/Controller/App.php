<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Lib\Http\Uri;
use App\Controller\ArticleController;
use App\View\Error;
use Doctrine\ORM\EntityManager;
use Exception;


final class App {
	/** @var string */
	private $version;
	/** @var ArticleController */
	private $controller;
	/** @var string */
	private $action;
	/** @var \App\Lib\Http\Query */
	private $params;

	function __construct(\App\Lib\Http\Request $request, EntityManager $entityManager) {
	try {
		$uri = $request->getUri();
		@list($version, $controller, $action) = $uri->getPath();
		@list($action, $format) = explode(".", $action);
		$params = $uri->getQuery();

		$this->version = isset($version) ? $version : 1;

		if(isset($controller)) {
			$this->setController($controller);
		}

		if(isset($action)) {
			$this->setAction($action);
		}

		if(isset($params)) {
			$this->params = $params;
		}

		$this->controller->setEntityManager($entityManager);
		$this->controller->setView($format);
		$this->controller->setRequest($request);

		$action = $this->action;
		$this->controller->$action();
		} catch(Exception $e){
			error_log($e->getMessage());
			Error::render($e->getMessage(), 400);
		}
	}

	private function setController(string $controller) {
        $controller = __NAMESPACE__ . "\\" . ucfirst(strtolower($controller)) . "Controller";
        if (!class_exists($controller)) {
            throw new Exception(
                "The controller '$controller' has not been defined.");
        }

        $this->controller = new $controller;
    }


	private function setAction(string $action) {
        $action = str_replace("_", "", ucwords(strtolower($action), "_"));
        if (!method_exists($this->controller, $action)) {
            throw new Exception(
                "The action '$action' has not been defined.");
        }

        $this->action = $action;
    }
}