<?php declare(strict_types=1);

namespace Service;

use Repository\TariffRepository;
use System\Container\DependencyContainer;

class TariffService
{
    private TariffRepository $tariffRepository;

    public function __construct(private readonly DependencyContainer $container)
    {
        $this->tariffRepository = $this->container->get(TariffRepository::class);
    }

    public function find(int $id): array
    {
        return $this->tariffRepository->find($id);
    }
}