<?php
declare(strict_types = 1);
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use App\Lib\Uri;
use App\Controller\ArticleController;

final class FrontController {
	private $version;
	private $controller;
	private $action;
	private $params = array();

	function __construct(EntityManager $entityManager){
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
	}

	private function setController($controller) {
        $controller = __NAMESPACE__ . "\\" . ucfirst(strtolower($controller)) . "Controller";
        if (!class_exists($controller)) {
            throw new InvalidArgumentException(
                "The controller '$controller' has not been defined.");
        }

        $this->controller = new $controller;
    }


	private function setAction($action) {
        $action = strtolower($_SERVER['REQUEST_METHOD']) . ucfirst(strtolower($action));
        if (!method_exists($this->controller, $action)) {
            throw new InvalidArgumentException(
                "The action '$action' has not been defined.");
        }

        $this->action = $action;
    }
}