<?php

declare(strict_types=1);

namespace Service;

use Repository\LogRepository;
use System\Container\DependencyContainer;

class LogService
{
    private LogRepository $logRepository;

    public function __construct(private readonly DependencyContainer $container)
    {
        $this->logRepository = $this->container->get(LogRepository::class);
    }

    public function create(array $data): void
    {
        $this->logRepository->create($data);
    }
}