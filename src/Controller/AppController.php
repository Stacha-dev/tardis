<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Lib\Uri;
use App\Controller\ArticleController;
use App\View\Error;
use Doctrine\ORM\EntityManager;
use Exception;


final class AppController {
	/** @var string */
	private $version;
	private $controller;
	/** @var string */
	private $action;
	/** @var array */
	private $params = array();

	function __construct(EntityManager $entityManager){
	try {
		$uri = new Uri($_SERVER["REQUEST_URI"]);
		@list($uri, $params) = Uri::fromString($_SERVER["REQUEST_URI"]);
		@list($version, $controller, $action) = $uri;
		@list($action, $format) = explode(".", $action);

		if(isset($version)) {
			$this->version = $version;
		}

		if(isset($controller)) {
			$this->setController($controller);
		}

		if(isset($action)) {
			$this->setAction($action);
		}

		if(isset($params)) {
			foreach(explode("&",$params) as $param) {
				@list($name, $value) = explode("=", $param);
				array_push($this->params, array('name' => $name, 'value' => $value));
			}
		}

		$this->controller->setEntityManager($entityManager);
		$this->controller->setView($format);

		$action = $this->action;
		$this->controller->$action($this->params);
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