<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Lib\Util\Input;
use App\Lib\Middleware\RouteFactory;
use App\Lib\FileSystem\FileSystem;
use Exception;

final class File extends \App\Controller\Base
{
    /**
     * Register routes to router.
     *
     * @param  \App\Lib\Middleware\Router $router
     * @return void
     */
    public function registerRoutes(\App\Lib\Middleware\Router $router): void
    {
        $router->register(RouteFactory::fromConstants(1, "GET", "@^(?<version>[0-9])/file$@", "getAll"))
                ->register(RouteFactory::fromConstants(1, "POST", "@^(?<version>[0-9]+)/file$@", "upload", [], true));
    }

    /**
     * Gets all files
     *
     * @return array<array>
     */
    public function getAll(): array
    {
        $query = $this->entityManager->createQuery('SELECT a FROM App\Model\Entity\File a');
        $result = $query->getArrayResult();
        $this->view->render($result);
        return $result;
    }

    /**
     * Gets one file by ID
     *
     * @param  int $id
     * @return \App\Model\Entity\File
     */
    public function getOneById(int $id=0): \App\Model\Entity\File
    {
        $result = $this->entityManager->find('App\Model\Entity\File', $id);
        if ($result instanceof \App\Model\Entity\File) {
            $this->view->render(array('id' => $result->getId(), 'title' => $result->getTitle(), 'path' => $result->getPath(), 'state' => $result->getState()));
            return $result;
        } else {
            throw new Exception("File by ID can not be founded!");
        }
    }

    /**
     * Uploads file to storage
     *
     * @return void
     */
    public function upload(string $title = ""): void
    {
        $body = $this->request->getBody();
        $title = $body->getBodyData('title') ?? $title;
        foreach ($body->getFiles() as $file) {
            FileSystem::upload($file);
            $this->view->render(["path"=>FileSystem::getUri($file)]);
            $fileEntity = new \App\Model\Entity\File($title, FileSystem::getUri($file));
        }
        $this->entityManager->flush();
    }
}
