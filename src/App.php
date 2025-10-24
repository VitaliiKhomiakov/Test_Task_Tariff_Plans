<?php declare(strict_types=1);

use Controller\HomeController;
use Controller\TariffController;
use Notification\Message;
use Repository\LogRepository;
use Repository\ObsceneWordRepository;
use Repository\TariffRepository;
use Repository\TariffTypeRepository;
use Service\LogService;
use Service\MailService;
use Service\ObsceneWordService;
use Service\TariffService;
use System\Container\DependencyContainer;
use System\Database\Connection;
use System\Database\DTO\ConnectionDTO;
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
            ->bind(ObsceneWordRepository::class, $container->get(Connection::class))
            ->bind(LogRepository::class, $container->get(Connection::class))
            ->bind(TariffService::class, $container)
            ->bind(MailService::class, $container)
            ->bind(LogService::class, $container)
            ->bind(ObsceneWordService::class, $container)
            ->bind(Request::class, [])
            ->bind(Message::class, []);

        try {
            $router = new Router($container);
            $router->addRoute('/', HomeController::class)
                ->addRoute('/tariff', TariffController::class);

            $requestPath = $_SERVER['REQUEST_URI'];
            echo $router->handleRequest($requestPath)->json();
        } catch (\Exception $exception) {
            http_response_code(\System\Http\Response::CODE_SERVER_ERROR);
            echo $exception->getMessage();
        }
    }
}