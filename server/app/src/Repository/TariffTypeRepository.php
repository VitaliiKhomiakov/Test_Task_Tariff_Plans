<?php declare(strict_types=1);

namespace Repository;

use Model\TariffType;
use PDO;

class TariffTypeRepository extends AbstractRepository
{
    public function find(int $id): array
    {
        $stmt = $this->query()
            ->prepare('SELECT * FROM tariff_type WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return array_map(fn($item) => new TariffType($item), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}