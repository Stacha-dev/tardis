<?php

declare(strict_types=1);

namespace App\Controller;

interface IBase
{
    public function registerRoutes(\App\Lib\Middleware\Router $router): void;
}
