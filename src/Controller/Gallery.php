<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Lib\Util\Input;
use App\Lib\Middleware\RouteFactory;
use Exception;

final class Gallery extends \App\Controller\Base
{
    /**
     * Register routes to router
     *
     * @param  \App\Lib\Middleware\Router $router
     * @return void
     */
    public function registerRoutes(\App\Lib\Middleware\Router $router): void
    {
        $router->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9])/gallery$@", "getAll"))
               ->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9]+)/gallery/(?<id>[0-9]+)$@", "getOneById", array("id")))
               ->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9]+)/gallery/(?<alias>[a-z1-9-]+)$@", "getOneByAlias", array("alias")))
               ->register(RouteFactory::fromConstants(1, "POST", "@^(?<version>[0-9]+)/gallery$@", "create", array(), true))
               ->register(RouteFactory::fromConstants(1, "PUT", "@^(?<version>[0-9]+)/gallery/(?<id>[0-9]+)$@", "edit", array("id"), true))
               ->register(RouteFactory::fromConstants(1, "DELETE", "@^(?<version>[0-9]+)/gallery/(?<id>[0-9]+)$@", "delete", array("id"), true));
    }

    /**
     * Gets all galleries
     *
     * @return array<array>
     */
    public function getAll(): array
    {
        $query = $this->entityManager->createQuery('SELECT a FROM App\Model\Entity\Gallery a');
        $result = $query->getArrayResult();
        $this->view->render($result);
        return $result;
    }

    /**
     * Gets one gallery by ID
     *
     * @param  int $id
     * @return \App\Model\Entity\Gallery
     */
    public function getOneById(int $id): \App\Model\Entity\Gallery
    {
        $result = $this->entityManager->find('App\Model\Entity\Gallery', $id);
        if ($result instanceof \App\Model\Entity\Gallery) {
            $this->view->render(array('id' => $result->getId(), 'title' => $result->getTitle(), 'alias' => $result->getAlias(), 'status' => $result->getStatus()));
            return $result;
        } else {
            throw new Exception("Gallery by ID can not be founded!");
        }
    }

    /**
     * Gets one gallery by alias
     *
     * @param  string $alias
     * @return \App\Model\Entity\Gallery
     */
    public function getOneByAlias(string $alias): \App\Model\Entity\Gallery
    {
        $params = $this->request->getUri()->getQuery();
        $alias = $params->getQueryParamValue('alias') ?? $alias;

        $result = $this->entityManager->getRepository('App\Model\Entity\Gallery')->findOneBy(array('alias' => $alias));

        if ($result instanceof \App\Model\Entity\Gallery) {
            $this->view->render(array('id' => $result->getId(), 'title' => $result->getTitle()));
            return $result;
        } else {
            throw new Exception("Gallery by alias can not be founded!");
        }
    }

    /**
     * Creates new gallery
     *
     * @param  string $title
     * @return \App\Model\Entity\Gallery
     */
    public function create(string $title = '', string $alias = null): \App\Model\Entity\Gallery
    {
        $body = $this->request->getBody();
        $title = $body->getBodyData('title') ?? $title;
        $alias = $body->getBodyData('alias') ?? $alias ?? Input::toAlias($title);
        $gallery = new \App\Model\Entity\Gallery($title, $alias);
        $this->entityManager->persist($gallery);
        $this->entityManager->flush();
        $this->view->render(array("id" => $gallery->getId(), "title" => $gallery->getTitle(), "alias" => $gallery->getAlias()));

        return $gallery;
    }

    /**
     * Edit gallery by ID
     *
     * @param  int    $id
     * @param  string $title
     * @return \App\Model\Entity\Gallery
     */
    public function edit(int $id = 0, string $title = '', string $alias = ''): \App\Model\Entity\Gallery
    {
        $params = $this->request->getUri()->getQuery();
        $body = $this->request->getBody();
        $id = $params->getQueryParamValue('id') ?? $id;
        $title = $body->getBodyData('title') ?? $title;
        $alias = $body->getBodyData('alias') ?? $alias;

        $gallery = $this->entityManager->find('App\Model\Entity\Gallery', $id);
        if ($gallery instanceof \App\Model\Entity\Gallery) {
            if (!empty($title)) {
                $gallery->setTitle($title);
            }
            if (!empty($alias)) {
                $gallery->setAlias($alias);
            }
            $this->entityManager->flush();
            $this->view->render(array("id" => $gallery->getId(), "title" => $gallery->getTitle(), "alias" => $gallery->getAlias()));
            return $gallery;
        } else {
            throw new Exception("Gallery with ID: " . $id . " not exists!");
        }
    }

    /**
     * Delete galery by ID
     *
     * @param  int $id
     * @return void
     */
    public function delete(int $id = 0): void
    {
        $params = $this->request->getUri()->getQuery();
        $id = $params->getQueryParamValue('id') ?? $id;

        $gallery = $this->entityManager->find('App\Model\Entity\Gallery', $id);
        if (isset($gallery)) {
            $this->entityManager->remove($gallery);
            $this->entityManager->flush();
        } else {
            throw new Exception("Gallery with ID: " . $id . " not exists!");
        }
    }
}