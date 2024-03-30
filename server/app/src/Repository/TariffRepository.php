<?php declare(strict_types=1);

namespace Repository;

use Model\Tariff;
use PDO;
use Service\DTO\TariffDTO;

class TariffRepository extends AbstractRepository
{
    public function find(int $id): Tariff
    {
        $stmt = $this->query()
            ->prepare('SELECT * FROM `tariff` WHERE `id` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return new Tariff($stmt->fetch(PDO::FETCH_ASSOC) ?: []);
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
            'UPDATE tariff SET type_id = :typeId, name = :name, price = :price, description = :description, is_active = :isActive 
        WHERE id = :id');

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':typeId', $tariffDTO->typeId, PDO::PARAM_INT);
        $stmt->bindValue(':name', $tariffDTO->name);
        $stmt->bindValue(':price', $tariffDTO->price);
        $stmt->bindValue(':description', $tariffDTO->description);
        $stmt->bindValue(':isActive', $tariffDTO->isActive, PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->query()
            ->prepare('DELETE FROM `tariff` WHERE `id` = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}