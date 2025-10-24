<?php

declare(strict_types=1);

namespace Repository;

use Model\TariffType;
use PDO;

class TariffTypeRepository extends AbstractRepository
{
    public function find(int $id): ?TariffType
    {
        $stmt = $this->query()
            ->prepare('SELECT * FROM tariff_type WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new TariffType($result) : null;
    }
}