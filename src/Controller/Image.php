<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Base;
use App\Lib\Middleware\RouteFactory;
use App\Model\Entity\Gallery;
use App\Lib\FileSystem\FileSystem;
use Exception;

final class Image extends Base
{
    /** @var array<array<int>> */
    public const THUMBNAIL_DIMENSIONS = [[2560, 1440], [1920, 1080], [1366, 768], [1024, 768], [640, 480], [320, 240], [160, 160]];

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
            $this->view->render(array('id' => $result->getId(), 'gallery' => $result->getGallery()->getId(), 'title' => $result->getTitle(), 'source' => $result->getSource(), 'ordering' => $result->getOrdering(), 'state' => $result->getState()));
            return $result;
        } else {
            throw new Exception("Image by ID: " . $id . " can not be founded!");
        }
    }

    /**
     * Creates new image
     *
     * @return void
     */
    public function upload(): void
    {
        $body = $this->request->getBody();
        $title = $body->getBodyData('title', '');
        $galleryId = $body->getBodyData('gallery', 0);
        $state = (bool)$body->getBodyData('state', true);
        $output = [];

        $gallery = $this->entityManager->getRepository('App\Model\Entity\Gallery')->findOneBy(array('id' => $galleryId));
        if (!($gallery instanceof Gallery)) {
            throw new Exception('Gallery with ID ' . $galleryId . ' was not found!');
        }

        $images = $gallery->getImages()->getValues();
        $ordering = $images ? array_pop($images)->getOrdering() : -1;

        foreach ($body->getFiles() as $file) {
            FileSystem::upload($file, FileSystem::IMAGES_DIRECTORY);
            $image = $file->toImage();
            $source[$image->getMimeType()] = $image->generateThumbnails(self::THUMBNAIL_DIMENSIONS);
            $image->delete();
            $ordering++;

            $insert = new \App\Model\Entity\Image($gallery, $title, $source, (int)$ordering, $state);
            $this->entityManager->persist($insert);
            array_push($output, ["title" => $insert->getTitle(), "gallery" => $insert->getGallery()->getId(), "ordering" => $insert->getOrdering(), "source" => $insert->getSource()]);
        }
        $this->entityManager->flush();
        $this->view->render($output);
    }

    /**
     * Edits image by ID
     *
     * @param  int    $id
     * @return \App\Model\Entity\Image
     */
    public function edit(int $id = 0): \App\Model\Entity\Image
    {
        $body = $this->request->getBody();
        $title = $body->getBodyData('title', null);
        $ordering = (int)$body->getBodyData('ordering', null);
        $state = (bool)$body->getBodyData('state', null);
        $image = $this->entityManager->getRepository('App\Model\Entity\Image')->findOneBy(array('id' => $id));

        if ($image instanceof \App\Model\Entity\Image) {
            if (is_string($title)) {
                $image->setTitle($title);
            }

            if (is_integer($ordering)) {
                $image->setOrdering($ordering);
            }

            if (is_bool($state)) {
                $image->setState($state);
            }

            $this->entityManager->flush();
            $this->view->render(array("id" => $image->getId(), "title" => $image->getTitle(), "ordering" => $image->getOrdering(), "state" => $image->getState()));
            return $image;
        } else {
            throw new Exception("Image with ID: " . $id . " does not exists!");
        }
    }

    /**
     * Deletes image by ID
     *
     * @param  int $id
     * @return void
     */
    public function delete(int $id = 0): void
    {
        $image = $this->entityManager->getRepository('App\Model\Entity\Image')->findOneBy(array('id' => $id));

        if ($image instanceof \App\Model\Entity\Image) {
            foreach ($image->getSource() as $type) {
                foreach ($type as $path) {
                    FileSystem::open($path)->delete();
                }
            }
            $this->entityManager->remove($image);
            $this->entityManager->flush();
        } else {
            throw new Exception("Image with ID: " . $id . " does not exists!");
        }
    }
}
