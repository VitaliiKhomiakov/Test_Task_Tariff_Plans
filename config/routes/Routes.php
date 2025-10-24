<?php

declare(strict_types=1);

namespace Routes;

use Application\Controller\HomeController;
use Application\Controller\TariffController;
use App\Routing\Router;

final class Routes
{
    public static function register(Router $router): void
    {
        $router->addRoute('/', HomeController::class)
               ->addRoute('/tariff', TariffController::class);
    }
}
