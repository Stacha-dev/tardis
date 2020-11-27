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
        $router->register(RouteFactory::fromConstants(1, "POST", "@^(?<version>[0-9]+)/file$@", "upload", [], true));
    }

    /**
     * Uploads file to storage
     *
     * @return void
     */
    public function upload(): void
    {
        foreach ($_FILES as $file) {
            $newFile = FileSystem::open($file["tmp_name"]);
            FileSystem::upload($newFile);
            $this->view->render(["path"=>FileSystem::getUrl($newFile)]);
        }
    }
}
