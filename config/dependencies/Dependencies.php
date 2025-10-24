<?php

declare(strict_types=1);

namespace Config\Dependencies;

use Infrastructure\Notification\Message;
use Domain\Repository\LogRepository;
use Domain\Repository\ObsceneWordRepository;
use Domain\Repository\TariffRepository;
use Domain\Repository\TariffTypeRepository;
use Domain\Service\LogService;
use Domain\Service\MailService;
use Domain\Service\ObsceneWordService;
use Domain\Service\TariffService;
use Domain\Service\TariffDescriptionService;
use Domain\Service\Interface\LogServiceInterface;
use Domain\Service\Interface\MailServiceInterface;
use Domain\Service\Interface\ObsceneWordServiceInterface;
use Domain\Service\Interface\TariffServiceInterface;
use App\Container\DependencyContainer;
use Infrastructure\Database\Connection;
use Infrastructure\Http\Request;
use Infrastructure\Util\TariffDescriptionHandler;

final class Dependencies
{
    public static function configure(DependencyContainer $container): DependencyContainer
    {
        return $container
            // Repositories
            ->bind(TariffRepository::class, $container->get(Connection::class))
            ->bind(TariffTypeRepository::class, $container->get(Connection::class))
            ->bind(ObsceneWordRepository::class, $container->get(Connection::class))
            ->bind(LogRepository::class, $container->get(Connection::class))
            
            // Services
            ->bind(LogService::class, $container)
            ->bind(MailService::class, $container)
            ->bind(ObsceneWordService::class, $container)
            
            // Service Interfaces
            ->bind(LogServiceInterface::class, LogService::class)
            ->bind(MailServiceInterface::class, MailService::class)
            ->bind(ObsceneWordServiceInterface::class, ObsceneWordService::class)
            
            // TariffDescriptionService (depends on interfaces)
            ->bind(TariffDescriptionService::class, [
                $container->get(ObsceneWordService::class),
                new TariffDescriptionHandler()
            ])
            
            // TariffService (depends on everything)
            ->bind(TariffService::class, $container)
            ->bind(TariffServiceInterface::class, TariffService::class)
            
            // Utilities
            ->bind(TariffDescriptionHandler::class, [])
            ->bind(Message::class, [])
            ->bind(Request::class, []);
    }
}
