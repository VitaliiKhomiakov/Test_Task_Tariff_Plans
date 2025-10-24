<?php

declare(strict_types=1);

namespace Config\Dependencies;

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

final class Dependencies
{
    public static function configure(DependencyContainer $container): DependencyContainer
    {
        return $container
            ->bind(TariffRepository::class, $container->get(Connection::class))
            ->bind(TariffTypeRepository::class, $container->get(Connection::class))
            ->bind(ObsceneWordRepository::class, $container->get(Connection::class))
            ->bind(LogRepository::class, $container->get(Connection::class))
            ->bind(TariffService::class, $container)
            ->bind(MailService::class, $container)
            ->bind(LogService::class, $container)
            ->bind(ObsceneWordService::class, $container)
            ->bind(Message::class, []);
    }
}
