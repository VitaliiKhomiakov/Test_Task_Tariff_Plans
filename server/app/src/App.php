<?php declare(strict_types=1);

use Controller\HomeController;
use System\Container\DependencyContainer;
use System\Database\Connection;
use System\Database\ConnectionDTO;
use System\Routing\Router;

class App
{
    public function initialize(): void
    {
        $container = new DependencyContainer();
        $container->bind(Connection::class, new ConnectionDTO(Config::DB()));

        $router = new Router();
        $router->setContainer($container)
            ->addRoute('/catalog', HomeController::class);

        $requestPath = $_SERVER['REQUEST_URI'];
        echo $router->handleRequest($requestPath)->json();
    }
}