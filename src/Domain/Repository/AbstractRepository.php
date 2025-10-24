<?php

declare(strict_types=1);

namespace Domain\Repository;

use PDO;
use Infrastructure\Database\Connection;

abstract class AbstractRepository
{
    private PDO $connection;

    public function __construct(private readonly Connection $container) {}

    protected function query(): PDO
    {
        return $this->connection ??= $this->container->getConnection();
    }
}