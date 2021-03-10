<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Base;
use App\Lib\Middleware\RouteFactory;
use Exception;

final class Menu extends Base
{
    /**
     * Register routes to router
     *
     * @param  \App\Lib\Middleware\Router $router
     * @return void
     */
    public function registerRoutes(\App\Lib\Middleware\Router $router): void
    {
        $router->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9]+)/menu/(?<id>[0-9]+)$@", "getOneById", array("id")));
    }

    /**
     * Gets one menu by ID
     *
     * @param  int $id
     * @return \App\Model\Entity\Menu
     */
    public function getOneById(int $id): \App\Model\Entity\Menu
    {
        $menu = $this->entityManager->getRepository('App\Model\Entity\Menu')->findOneBy(array('id' => $id));

        if ($menu instanceof \App\Model\Entity\Menu) {
            $items = [];
            foreach ($menu->getItems() as $item) {
                array_push($items, array('title' => $item->getTitle(), 'target' => $item->getTarget()));
            }

            $this->view->render(["title" => $menu->getTitle(), "updated" => $menu->getUpdated(), 'created' => $menu->getCreated(), "items" => $items, "state" => $menu->getState()]);

            return $menu;
        } else {
            throw new Exception("Menu with ID:" . $id . " can not be founded!", 404);
        }
    }
}
