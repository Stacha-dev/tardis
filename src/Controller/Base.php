<?php
declare(strict_types = 1);
namespace App\Controller;

use App\View\Json;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Exception;
use App\Lib\Middleware\RouteFactory;
use App\Lib\Authorization\AuthorizationFactory;

class Base implements IBase
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
     * Register default routes
     *
     * @param \App\Lib\Middleware\Router $router
     * @return void
     */
    public function registerDefaultRoutes(\App\Lib\Middleware\Router $router): void
    {
        $router->register(RouteFactory::fromConstants(1, "OPTIONS", "@^(.*)$@", "getStatus"));
    }

    /**
    * Dispatch request to predefined routes.
    * @param  \App\Lib\Middleware\Router $router
    * @param \App\Lib\Http\Request $request
     */
    public function requestDispatch(\App\Lib\Middleware\Router $router, \App\Lib\Http\Request $request): void
    {
        $this->registerDefaultRoutes($router);
        $this->registerRoutes($router);
        $route = $router->dispatch($request);
        $this->checkPerms($route);
        $callback = [$this, $route->getAction()];
        if (is_callable($callback)) {
            call_user_func_array($callback, $route->getParams());
        }
    }

    /**
     * Returns API status
     *
     * @todo Make it usefull
     * @return array<string>
     */
    public function getStatus():array
    {
        $status = array('status' => 'ok');
        $this->view->render($status);
        return $status;
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

    /**
     * Checks user permitions on route action.
     *
     * @param \App\Lib\Middleware\Route $route
     * @return void
     */
    private function checkPerms(\App\Lib\Middleware\Route $route):void
    {
        if ($route->isSecure()) {
            $jwt = AuthorizationFactory::fromType('JWT');
            $token = $this->request->getAuthorization();
            if (is_null($token) || empty($token)) {
                throw new Exception('Authorization token is not provided!');
            }
            $jwt->authorize($token);
        }
    }
}
