<?php
declare(strict_types = 1);
namespace App\Controller;

use App\View\Json;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Exception;

class Base {

	/** @var EntityManager */
	protected $entityManager;
	/** @var QueryBuilder */
	protected $queryBuilder;
	/** @var Json */
	protected $view;
	/** @var \App\Lib\Http\Request */
	protected $request;

	/**
	 * Sets entity manager.
	 *
	 * @param EntityManager $entityManager
	 * @return void
	 */
	public function setEntityManager(EntityManager $entityManager) {
		$this->entityManager = $entityManager;
		$this->queryBuilder = $entityManager->createQueryBuilder();
	}

	/**
	 * Sets view.
	 *
	 * @param string $view
	 * @return void
	 */
	public function setView(string $view) {
		$view = "App\View\\" . ucfirst(strtolower($view));
		if (class_exists($view)) {
			$this->view = new $view;
		} else {
			throw new Exception("The view '$view' has not been defined.");
		}
	}

	/**
	 * Sets request.
	 *
	 * @param \App\Lib\Http\Request $request
	 * @return void
	 */
	public function setRequest(\App\Lib\Http\Request $request) {
		$this->request = $request;
	}
}