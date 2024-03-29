<?php

use Controller\AbstractController;
use Service\TariffService;
use System\Container\DependencyContainer;

final class TariffController extends AbstractController
{
    private TariffService $tariffService;

    public function __construct(private DependencyContainer $container)
    {
        $this->tariffService = $container->get(TariffService::class);
    }
}