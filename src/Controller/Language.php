<?php

declare(strict_types=1);

namespace App\Controller;

use App\Lib\Middleware\RouteFactory;

final class Language extends \App\Controller\Base
{
    /**
     * Register routes to router
     *
     * @param  \App\Lib\Middleware\Router $router
     * @return void
     */
    public function registerRoutes(\App\Lib\Middleware\Router $router): void
    {
        $router->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9])/language$@", "getAll"));
    }

    /**
     * Gets all languages
     *
     * @return array<array>
     */
    public function getAll(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('l')
            ->from('App\Model\Entity\Language', 'l');

        $languages = $queryBuilder->getQuery()->getArrayResult();
        $this->view->render($languages);

        return $languages;
    }
}
