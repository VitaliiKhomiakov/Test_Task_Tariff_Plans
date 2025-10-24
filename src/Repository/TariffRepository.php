<?php

declare(strict_types=1);

namespace Repository;

use DTO\TariffDTO;
use Model\Tariff;
use PDO;

class TariffRepository extends AbstractRepository
{
    public function find(int $id): ?Tariff
    {
        $stmt = $this->query()
            ->prepare('SELECT * FROM `tariff` WHERE `id` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Tariff($data) : null;
    }

    public function findAll(): array
    {
        $stmt = $this->query()->prepare('SELECT * FROM `tariff`');
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(static fn($item) => new Tariff($item), $data);
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

    public function update(int $id, TariffDTO $tariffDTO): bool
    {
        $stmt = $this->query()->prepare(
            'UPDATE tariff SET type_id = :typeId, name = :name, price = :price, description = :description, is_active = :isActive WHERE id = :id'
        );

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':typeId', $tariffDTO->typeId, PDO::PARAM_INT);
        $stmt->bindValue(':name', $tariffDTO->name);
        $stmt->bindValue(':price', $tariffDTO->price);
        $stmt->bindValue(':description', $tariffDTO->description);
        $stmt->bindValue(':isActive', $tariffDTO->isActive, PDO::PARAM_BOOL);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->query()
            ->prepare('DELETE FROM `tariff` WHERE `id` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
}
