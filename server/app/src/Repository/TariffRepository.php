<?php declare(strict_types=1);

namespace Repository;

use Model\Tariff;
use PDO;

class TariffRepository extends AbstractRepository
{
    public function find(int $id): array
    {
        $query = $this->query()
            ->prepare('SELECT * FROM `tariff` WHERE `id` = :id');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return array_map(fn($item) => new Tariff($item), $query->fetchAll(PDO::FETCH_ASSOC));
    }
}