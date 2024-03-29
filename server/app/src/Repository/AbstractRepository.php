<?php declare(strict_types=1);

namespace Repository;

use PDO;
use System\Container\DependencyContainer;
use System\Database\Connection;

abstract class AbstractRepository implements RepositoryInterface
{
    private PDO $connection;

    public function __construct(private readonly DependencyContainer $container) {}

    public function queryBuilder(): PDO
    {
        return $this->connection ??= $this->container->get(Connection::class)->getConnection();
    }
}