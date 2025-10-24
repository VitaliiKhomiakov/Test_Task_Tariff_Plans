<?php

declare(strict_types=1);

namespace Domain\Service\Interface;

interface LogServiceInterface
{
    public function create(array $data): void;
}
