<?php

declare(strict_types=1);

namespace Routes;

use Controller\HomeController;
use Controller\TariffController;
use System\Routing\Router;

final class Routes
{
    public static function register(Router $router): void
    {
        $router->addRoute('/', HomeController::class)
               ->addRoute('/tariff', TariffController::class);
    }
}
