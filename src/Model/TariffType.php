<?php

declare(strict_types=1);

namespace Model;

final class TariffType
{
    private int $id;
    private string $code;

    public function __construct(array $data)
    {
        $this->id = (int)($data['id'] ?? 0);
        $this->code = $data['code'] ?? '';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}