<?php declare(strict_types=1);

use Controller\HomeController;
use Repository\TariffRepository;
use Repository\TariffTypeRepository;
use Service\MailService;
use Service\TariffService;
use System\Container\DependencyContainer;
use System\Database\Connection;
use System\Database\ConnectionDTO;
use System\Http\Request;
use System\Routing\Router;

class App
{
    public function initialize(): void
    {
        if (Config::DEBUG) {
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);
        }

        $container = new DependencyContainer();
        $container->bind(Connection::class, new ConnectionDTO(Config::DB()))
            ->bind(TariffRepository::class, $container->get(Connection::class))
            ->bind(TariffTypeRepository::class, $container->get(Connection::class))
            ->bind(TariffService::class, $container)
            ->bind(MailService::class, $container)
            ->bind(Request::class, []);

        $router = new Router();
        $router->setContainer($container)
            ->addRoute('/', HomeController::class);

        $requestPath = $_SERVER['REQUEST_URI'];
        echo $router->handleRequest($requestPath)->json();
    }
}