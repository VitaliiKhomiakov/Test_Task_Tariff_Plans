<?php

declare(strict_types=1);

namespace App\Core;

use App\Container\ContainerConfigurator;
use App\Container\DependencyContainer;
use App\Error\ErrorHandler;
use App\Routing\Router;

final class AppInitializer
{
    private ContainerConfigurator $containerConfigurator;
    private ErrorHandler $errorHandler;

    public function __construct()
    {
        $this->containerConfigurator = new ContainerConfigurator();
        $this->errorHandler = new ErrorHandler();
    }

    public function initialize(): void
    {
        $this->setupErrorReporting();
        
        $container = $this->createContainer();
        $router = $this->createRouter($container);
        
        $this->handleRequest($router);
    }

    private function setupErrorReporting(): void
    {
        if (\Config::DEBUG) {
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);
        }
    }

    private function createContainer(): DependencyContainer
    {
        $container = new DependencyContainer();
        return $this->containerConfigurator->configure($container);
    }

    private function createRouter(DependencyContainer $container): Router
    {
        $router = new \App\Routing\Router($container);
        $this->registerRoutes($router);
        return $router;
    }

    private function registerRoutes(Router $router): void
    {
        \Routes\Routes::register($router);
    }

    private function handleRequest(Router $router): void
    {
        try {
            $requestPath = $_SERVER['REQUEST_URI'] ?? '/';
            echo $router->handleRequest($requestPath)->json();
        } catch (\Throwable $exception) {
            $this->errorHandler->handle($exception);
        }
    }
}
