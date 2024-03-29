<?php declare(strict_types=1);

namespace Repository;

class LogRepository extends AbstractRepository
{
    public function create(array $data): int
    {
        $stmt = $this->query()->prepare('INSERT INTO log (data) VALUES (:data)');
        $stmt->bindValue(':data', json_encode($data));
        $stmt->execute();

        return (int)$this->query()->lastInsertId() ?: 0;
    }
}