<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Controller\Base;
use App\Lib\Util\Input;
use App\Lib\Middleware\RouteFactory;
use App\Lib\FileSystem\FileSystem;
use Exception;

final class Gallery extends Base
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
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('g')
                ->from('App\Model\Entity\Gallery', 'g');
        $result = $queryBuilder->getQuery()->getArrayResult();

        foreach ($result as &$item) {
            $thumbnail = $this->entityManager->getRepository('App\Model\Entity\Image')->findOneBy(array("gallery" => $item['id']));
            if ($thumbnail instanceof \App\Model\Entity\Image) {
                $item['thumbnail'] = $thumbnail->getPaths();
            }
        }

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
        $result = $this->entityManager->getRepository('App\Model\Entity\Gallery')->findOneBy(array('id'=>$id));
        $images = $this->entityManager->getRepository('App\Model\Entity\Image')->findBy(array("gallery" => $id));

        if ($result instanceof \App\Model\Entity\Gallery) {
            $imageResult = array();
            foreach ($images as $image) {
                array_push($imageResult, array("id" => $image->getId(), "title" => $image->getTitle(), "paths" => $image->getPaths(), "ordering" => $image->getOrdering(), "state" => $image->getState()));
            }
            $this->view->render(array('id' => $result->getId(), 'title' => $result->getTitle(), 'alias' => $result->getAlias(), 'state' => $result->getState(), "images" => $imageResult));
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
        $body = $this->request->getBody();
        $title = $body->getBodyData('title') ?? $title;
        $alias = $body->getBodyData('alias') ?? $alias;
        $gallery = $this->entityManager->getRepository('App\Model\Entity\Gallery')->findOneBy(array('id'=>$id));

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
        $galleryEntity = $this->entityManager->getRepository('App\Model\Entity\Gallery')->findOneBy(array('id'=>$id));

        if ($galleryEntity instanceof \App\Model\Entity\Gallery) {
            $images = $this->entityManager->getRepository('App\Model\Entity\Image')->findBy(array("gallery" => $galleryEntity->getId()));
            foreach ($images as $imageEntity) {
                foreach ($imageEntity->getPaths() as $path) {
                    $file = FileSystem::open($path);
                    $image = $file->toImage();
                    $image->delete();
                    $this->entityManager->remove($imageEntity);
                }
            }
            $this->entityManager->remove($galleryEntity);
            $this->entityManager->flush();
        } else {
            throw new Exception("Gallery with ID: " . $id . " not exists!");
        }
    }
}
