<?php

declare(strict_types=1);

namespace App\Container;

use Infrastructure\Database\Connection;
use Infrastructure\Database\DTO\ConnectionDTO;
use Infrastructure\Http\Request;

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
