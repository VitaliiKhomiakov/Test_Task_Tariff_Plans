<?php

declare(strict_types=1);

namespace DTO;

class TariffDTO
{
    public int $typeId;
    public string $name;
    public float $price;
    public string $description;
    public bool $isActive;

    public function __construct(array $data)
    {
        $this->typeId = (int)$data['typeId'];
        $this->name = $data['name'];
        $this->price = (float)$data['price'];
        $this->description = $data['description'];
        $this->isActive = $data['is_active'];
    }
}
