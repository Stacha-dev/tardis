<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Base;
use App\Lib\Util\Input;
use App\Lib\Middleware\RouteFactory;
use App\Model\Entity\Gallery;
use App\Lib\FileSystem\FileSystem;
use Exception;

final class Image extends Base
{
    /**
     * Register routes to router
     *
     * @param  \App\Lib\Middleware\Router $router
     * @return void
     */
    public function registerRoutes(\App\Lib\Middleware\Router $router): void
    {
        $router
            ->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9]+)/image/(?<id>[0-9]+)$@", "getOneById", array("id")))
            ->register(RouteFactory::fromConstants(1, "POST", "@^(?<version>[0-9]+)/image$@", "upload", array(), true))
            ->register(RouteFactory::fromConstants(1, "PUT", "@^(?<version>[0-9]+)/image/(?<id>[0-9]+)$@", "edit", array("id"), true))
            ->register(RouteFactory::fromConstants(1, "DELETE", "@^(?<version>[0-9]+)/image/(?<id>[0-9]+)$@", "delete", array("id"), true));
    }

    /**
     * Gets one image by ID
     *
     * @param  int $id
     * @return \App\Model\Entity\Image
     */
    public function getOneById(int $id = 0): \App\Model\Entity\Image
    {
        $result = $this->entityManager->getRepository('App\Model\Entity\Image')->findOneBy(array('id' => $id));

        if ($result instanceof \App\Model\Entity\Image) {
            $this->view->render(array('id' => $result->getId(), 'gallery' => $result->getGallery()->getId(), 'title' => $result->getTitle(), 'source' => $result->getSource(), 'state' => $result->getState()));
            return $result;
        } else {
            throw new Exception("Image by ID can not be founded!");
        }
    }

    /**
     * Creates new image
     *
     * @param  string $title
     * @param int $galleryId
     * @return void
     */
    public function upload(string $title = '', int $galleryId = 0, int $ordering = 0, bool $state = true): void
    {
        $body = $this->request->getBody();
        $title = $body->getBodyData('title') ?? $title;
        $galleryId = $body->getBodyData('gallery') ?? $galleryId;
        $ordering = (int)$body->getBodyData('ordering') ?? $ordering;
        $state = (bool)$body->getBodyData('state') ?? $state;
        $output = [];
        foreach ($body->getFiles() as $file) {
            FileSystem::upload($file, FileSystem::IMAGES_DIRECTORY);
            $images = [];
            array_push($images, $file->toImage(), $file->clone()->toImage()->setFormat(\App\Lib\FileSystem\Image::FORMAT['WebP']));

            foreach ($images as $image) {
                $source[$image->getMimeType()] = $image->generateThumbnails();
                $image->delete();
            }

            $gallery = $this->entityManager->getRepository('App\Model\Entity\Gallery')->findOneBy(array('id' => $galleryId));

            if (!($gallery instanceof Gallery)) {
                throw new Exception('Gallery with ID ' . $galleryId . ' was not found!');
            }
            $insert = new \App\Model\Entity\Image($gallery, $title, $source, $ordering, $state);
            $this->entityManager->persist($insert);
            array_push($output, ["title" => $insert->getTitle(), "gallery" => $insert->getGallery()->getId(), "source" => $insert->getSource()]);
        }
        $this->entityManager->flush();
        $this->view->render($output);
    }

    /**
     * Edit image by ID
     *
     * @param  int    $id
     * @param  string $title
     * @return \App\Model\Entity\Image
     */
    public function edit(int $id = 0, string $title = '', int $ordering = 0, bool $state = false): \App\Model\Entity\Image
    {
        $body = $this->request->getBody();
        $title = $body->getBodyData('title') ?? $title;
        $ordering = (int)$body->getBodyData('ordering') ?? $ordering;
        $state = (bool)$body->getBodyData('state') ?? $state;
        $image = $this->entityManager->getRepository('App\Model\Entity\Image')->findOneBy(array('id' => $id));

        if ($image instanceof \App\Model\Entity\Image) {
            if (!empty($title)) {
                $image->setTitle($title);
            }

            if (!empty($ordering)) {
                $image->setOrdering($ordering);
            }

            if (!empty($state)) {
                $image->setState($state);
            }

            $this->entityManager->flush();
            $this->view->render(array("id" => $image->getId(), "title" => $image->getTitle(), "ordering" => $image->getOrdering(), "state" => $image->getState()));
            return $image;
        } else {
            throw new Exception("Image with ID: " . $id . " not exists!");
        }
    }

    /**
     * Delete image by ID
     *
     * @param  int $id
     * @return void
     */
    public function delete(int $id = 0): void
    {
        $entity = $this->entityManager->getRepository('App\Model\Entity\Image')->findOneBy(array('id' => $id));

        if ($entity instanceof \App\Model\Entity\Image) {
            var_dump($entity->getSource());
            foreach ($entity->getSource() as $type) {
                foreach ($type as $path) {
                    $file = FileSystem::open($path);
                    $image = $file->toImage();
                    $image->delete();
                }
            }
            $this->entityManager->remove($entity);
            $this->entityManager->flush();
        } else {
            throw new Exception("Image with ID: " . $id . " not exists!");
        }
    }
}
