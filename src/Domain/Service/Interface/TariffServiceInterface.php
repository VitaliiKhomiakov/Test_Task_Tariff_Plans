<?php

declare(strict_types=1);

namespace Domain\Service\Interface;

use Application\DTO\TariffDTO;
use Domain\Model\Tariff;

interface TariffServiceInterface
{
    public function find(int $id): ?Tariff;
    public function findAll(): array;
    public function create(TariffDTO $data): int;
    public function update(int $id, TariffDTO $data): bool;
    public function delete(int $id): bool;
}
