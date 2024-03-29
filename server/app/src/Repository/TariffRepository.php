<?php declare(strict_types=1);

namespace Repository;

use Model\Tariff;
use PDO;
use Service\DTO\TariffDTO;

class TariffRepository extends AbstractRepository
{
    public function find(int $id): array
    {
        $stmt = $this->query()
            ->prepare('SELECT * FROM `tariff` WHERE `id` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return array_map(fn($item) => new Tariff($item), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function create(TariffDTO $tariffDTO): int
    {
        $stmt = $this->query()->prepare(
            'INSERT INTO tariff (type_id, name, price, description, is_active) VALUES (:typeId, :name, :price, :description, :isActive)'
        );
        $stmt->bindValue(':typeId', $tariffDTO->typeId, PDO::PARAM_INT);
        $stmt->bindValue(':name', $tariffDTO->name);
        $stmt->bindValue(':price', $tariffDTO->price);
        $stmt->bindValue(':description', $tariffDTO->description);
        $stmt->bindValue(':isActive', $tariffDTO->isActive, PDO::PARAM_BOOL);

        $stmt->execute();
        return (int)$this->query()->lastInsertId() ?: 0;
    }
}