<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Lib\Http\Uri;
use App\Controller\ArticleController;
use App\View\Error;
use Doctrine\ORM\EntityManager;
use Exception;


class App {
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
		$params = $uri->getQuery();

		$this->version = $version;
		$this->setController($controller);
		$this->setAction($action);
		$this->params = $params;

		$this->controller->setEntityManager($entityManager);
		$this->controller->setView($request->getAccept());
		$this->controller->setRequest($request);

		$action = $this->action;
		$this->controller->$action();
		} catch(Exception $e){
			error_log($e->getMessage());
			Error::render($e->getMessage(), 400);
		}
	}

	/**
	 * Sets controller.
	 *
	 * @param string $controller
	 * @return void
	 */
	private function setController(string $controller) {
        $controller = __NAMESPACE__ . "\\" . ucfirst(strtolower($controller)) . "Controller";
        if (!class_exists($controller)) {
            throw new Exception(
                "The controller '$controller' has not been defined.");
        }

        $this->controller = new $controller;
    }

	/**
	 * Sets action of controller.
	 *
	 * @param string $action
	 * @return void
	 */
	private function setAction(string $action) {
        $action = str_replace("-", "", ucwords(strtolower($action), "-"));
        if (!method_exists($this->controller, $action)) {
            throw new Exception(
                "The action '$action' has not been defined.");
        }

        $this->action = $action;
    }
}