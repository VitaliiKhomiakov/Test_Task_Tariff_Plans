<?php

namespace Repository;

use PDO;

interface RepositoryInterface
{
    public function getConnection(): PDO;
}