<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Base;
use App\Lib\Util\Input;
use App\Lib\Middleware\RouteFactory;
use App\Lib\FileSystem\FileSystem;
use Exception;
use \stdClass;

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
            ->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9]+)/gallery/find/(?<key>[a-z1-9-]+)/(?<value>[a-z1-9-]+)$@", "find", array("key", "value")))
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
            ->from('App\Model\Entity\Gallery', 'g')
            ->orderBy('g.updated', 'DESC');
        $gallery = $queryBuilder->getQuery()->getArrayResult();

        foreach ($gallery as &$item) {
            $thumbnail = $this->entityManager->getRepository('App\Model\Entity\Image')->findOneBy(array("gallery" => $item['id']));
            if ($thumbnail instanceof \App\Model\Entity\Image) {
                $item['thumbnail'] = $thumbnail->getSource();
            }
        }

        $this->view->render($gallery);
        return $gallery;
    }

    /**
     * Gets one gallery by ID
     *
     * @param  int $id
     * @return \App\Model\Entity\Gallery
     */
    public function getOneById(int $id): \App\Model\Entity\Gallery
    {
        $gallery = $this->entityManager->getRepository('App\Model\Entity\Gallery')->findOneBy(array('id' => $id));

        if ($gallery instanceof \App\Model\Entity\Gallery) {
            $images = [];
            foreach ($gallery->getImages() as $image) {
                array_push($images, array('id' => $image->getId(), 'title' => $image->getTitle(), 'source' => $image->getSource(), 'ordering' => $image->getOrdering(), 'state' => $image->getState()));
            }

            $this->view->render(array('id' => $gallery->getId(), 'title' => $gallery->getTitle(), 'description' => $gallery->getDescription(), 'alias' => $gallery->getAlias(), 'state' => $gallery->getState(), "images" => $images));
            return $gallery;
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
        $gallery = $this->entityManager->getRepository('App\Model\Entity\Gallery')->findOneBy(array('alias' => $alias));

        if ($gallery instanceof \App\Model\Entity\Gallery) {
            $images = [];
            foreach ($gallery->getImages() as $image) {
                array_push($images, array('id' => $image->getId(), 'title' => $image->getTitle(), 'source' => $image->getSource(), 'ordering' => $image->getOrdering(), 'state' => $image->getState()));
            }

            $this->view->render(array('id' => $gallery->getId(), 'title' => $gallery->getTitle(), 'description' => $gallery->getDescription(), 'alias' => $gallery->getAlias(), 'state' => $gallery->getState(), "images" => $images));
            return $gallery;
        } else {
            throw new Exception("Gallery by ID can not be founded!");
        }
    }


    /**
     * Find galleries by key and value
     *
     * @param  string $key
     * @param string $value
     * @return array<\App\Model\Entity\Gallery>
     */
    public function find(string $key, string $value): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('g')
            ->from('App\Model\Entity\Gallery', 'g')
            ->where('g.' . $key . ' = ' . $value)
            ->orderBy('g.updated', 'DESC');
        $galleries = $queryBuilder->getQuery()->getResult();

        $response = array();
        foreach ($galleries as $gallery) {
            $image = $gallery->getThumbnail();
            $thumbnail = new stdClass;
            if ($image) {
                $thumbnail->id = $image->getId();
                $thumbnail->title = $image->getTitle();
                $thumbnail->source = $image->getSource();
            }

            array_push($response, array('id' => $gallery->getId(), 'title' => $gallery->getTitle(), 'description' => $gallery->getDescription(), 'alias' => $gallery->getAlias(), 'thumbnail' => $thumbnail, 'updated' => $gallery->getUpdated(), 'state' => $gallery->getState()));
        }

        $this->view->render($response);

        return $galleries;
    }


    /**
     * Creates new gallery
     *
     * @param  string $title
     * @param string $description
     * @param string $alias
     * @param int $tagId
     * @return \App\Model\Entity\Gallery
     */
    public function create(string $title = '', string $description = '', string $alias = null, int $tagId = 0): \App\Model\Entity\Gallery
    {
        $body = $this->request->getBody();
        $title = $body->getBodyData('title') ?? $title;
        $description = $body->getBodyData('description') ?? $description;
        $alias = $body->getBodyData('alias') ?? $alias ?? Input::toAlias($title);
        $tagId = $body->getBodyData('tag') ?? $tagId;
        $gallery = new \App\Model\Entity\Gallery($title, $description, $alias);
        $tag = $this->entityManager->getRepository('App\Model\Entity\Tag')->findOneBy(array("id" => $tagId));

        if ($tag instanceof \App\Model\Entity\Tag) {
            $gallery->setTag($tag);
        }

        $this->entityManager->persist($gallery);
        $this->entityManager->flush();
        $this->view->render(array("id" => $gallery->getId(), "title" => $gallery->getTitle(), "description" => $gallery->getDescription(), "alias" => $gallery->getAlias()));

        return $gallery;
    }

    /**
     * Edit gallery by ID
     *
     * @param  int    $id
     * @param  string $title
     * @param string $description
     * @param string $alias
     * @param int $tagId
     * @return \App\Model\Entity\Gallery
     */
    public function edit(int $id = 0, string $title = '', string $description = '', string $alias = '', int $tagId = 0): \App\Model\Entity\Gallery
    {
        $body = $this->request->getBody();
        $title = $body->getBodyData('title') ?? $title;
        $description = $body->getBodyData('description') ?? $description;
        $alias = $body->getBodyData('alias') ?? $alias;
        $tagId = $body->getBodyData('tag') ?? $tagId;
        $gallery = $this->entityManager->getRepository('App\Model\Entity\Gallery')->findOneBy(array('id' => $id));
        $tag = $this->entityManager->getRepository('App\Model\Entity\Tag')->findOneBy(array("id" => $tagId));

        if ($gallery instanceof \App\Model\Entity\Gallery) {
            if (!empty($title)) {
                $gallery->setTitle($title);
            }

            $gallery->setDescription($description);

            if (!empty($alias)) {
                $gallery->setAlias($alias);
            }

            if ($tag instanceof \App\Model\Entity\Tag) {
                $gallery->setTag($tag);
            }

            $this->entityManager->flush();
            $this->view->render(array("id" => $gallery->getId(), "title" => $gallery->getTitle(), "description" => $gallery->getDescription(), "alias" => $gallery->getAlias()));
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
        $galleryEntity = $this->entityManager->getRepository('App\Model\Entity\Gallery')->findOneBy(array('id' => $id));

        if ($galleryEntity instanceof \App\Model\Entity\Gallery) {
            $images = $this->entityManager->getRepository('App\Model\Entity\Image')->findBy(array("gallery" => $galleryEntity->getId()));
            foreach ($images as $imageEntity) {
                foreach ($imageEntity->getSource() as $type) {
                    foreach ($type as $path) {
                        $file = FileSystem::open($path);
                        $image = $file->toImage();
                        $image->delete();
                    }
                }
                $this->entityManager->remove($imageEntity);
            }
            $this->entityManager->remove($galleryEntity);
            $this->entityManager->flush();
        } else {
            throw new Exception("Gallery with ID: " . $id . " not exists!");
        }
    }
}
