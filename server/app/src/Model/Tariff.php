<?php

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
        $this->id = (int)($data['id'] ?? 0);;
        $this->typeId = (int)($data['type_id'] ?? 0);
        $this->name = $data['name'] ?? '';
        $this->price = (float)($data['price'] ?? 0);
        $this->description = $data['description'] ?? '';
        $this->isActive = !!($data['is_active'] ?? false);
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
}
