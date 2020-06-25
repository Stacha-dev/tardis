<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Lib\Http\Uri;
use App\Lib\Middleware\Router;
use App\Controller\ArticleController;
use App\View\Error;
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

	function __construct(\App\Lib\Http\Request $request, \Doctrine\ORM\EntityManager $entityManager) {
	$this->entityManager = $entityManager;
	$this->request = $request;
	try {
		$uri = $request->getUri();
		@list($version, $controller) = $uri->getPath();

		$this->setController($controller);

		$this->controller->requestDispatch($this->request);

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
        $controller = __NAMESPACE__ . "\\" . ucfirst(strtolower($controller));
        if (!class_exists($controller)) {
            throw new Exception(
                "The controller '$controller' has not been defined.");
        }
        $this->controller = new $controller($this->entityManager);

		$this->controller->setView($this->request->getAccept());
		$this->controller->setRequest($this->request);
    }
}