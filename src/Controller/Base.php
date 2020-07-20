<?php
declare(strict_types = 1);
namespace App\Controller;

use App\View\Json;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Exception;

class Base
{

    /**
     * @var EntityManager
     */
    protected $entityManager;
    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;
    /**
     * @var Json
     */
    protected $view;
    /**
     * @var \App\Lib\Http\Request
     */
    protected $request;
    /**
     * @var \App\Lib\Middleware\Router
     */
    protected $router;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->queryBuilder = $entityManager->createQueryBuilder();
    }

	 /**
     * Register routes to router.
     *
     * @param  \App\Lib\Middleware\Router $router
     * @return void
     */
	public function registerRoutes(\App\Lib\Middleware\Router $router): void
    {
	}

    /**
    * Dispatch request to predefined routes.
    * @param  \App\Lib\Middleware\Router $router
    * @param \App\Lib\Http\Request $request
     */
    public function requestDispatch(\App\Lib\Middleware\Router $router, \App\Lib\Http\Request $request): void
    {
        $this->registerRoutes($router);
        $result = $router->dispatch($request);
        if (is_array($result) && array_key_exists("action", $result) && array_key_exists("params", $result)) {
            $callback = [$this, $result["action"]];
            if (is_callable($callback)) {
                call_user_func_array($callback, (array)$result["params"]);
            }
        } else {
            throw new Exception("Router problem!");
        }
    }

    /**
     * Sets view.
     *
     * @param  string $view
     * @return void
     */
    public function setView(string $view)
    {
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
     * @param  \App\Lib\Http\Request $request
     * @return void
     */
    public function setRequest(\App\Lib\Http\Request $request)
    {
        $this->request = $request;
    }
}
