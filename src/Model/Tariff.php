<?php

declare(strict_types=1);

namespace Model;

final class Tariff
{
    private int $id;
    private int $typeId;
    private string $name;
    private float $price;
    private string $description;
    private bool $isActive;

    public function __construct(array $data)
    {
        $this->id = (int)($data['id'] ?? 0);
        $this->typeId = (int)($data['type_id'] ?? 0);
        $this->name = $data['name'] ?? '';
        $this->price = (float)($data['price'] ?? 0);
        $this->description = $data['description'] ?? '';
        $this->isActive = (bool)($data['is_active'] ?? false);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTypeId(): int
    {
        return $this->typeId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'typeId' => $this->typeId,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'isActive' => $this->isActive,
        ];
    }
}
