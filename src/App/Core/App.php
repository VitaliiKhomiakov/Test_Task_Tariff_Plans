<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\AppInitializer;

final class App
{
    private AppInitializer $initializer;

    public function __construct()
    {
        $this->initializer = new AppInitializer();
    }

    public function initialize(): void
    {
        $this->initializer->initialize();
    }
}