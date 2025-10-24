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
use App\Container\DependencyContainer;
use Infrastructure\Database\Connection;

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
