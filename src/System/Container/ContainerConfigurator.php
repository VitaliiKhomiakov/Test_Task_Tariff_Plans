<?php

declare(strict_types=1);

namespace System\Container;

use System\Database\Connection;
use System\Database\DTO\ConnectionDTO;
use System\Http\Request;

final class ContainerConfigurator
{
    public function configure(DependencyContainer $container): DependencyContainer
    {
        $container->bind(Connection::class, new ConnectionDTO(\Config::DB()))
                  ->bind(Request::class, []);

        \Config\Dependencies\Dependencies::configure($container);

        return $container;
    }
}
