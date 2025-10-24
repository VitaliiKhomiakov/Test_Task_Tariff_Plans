<?php

declare(strict_types=1);

namespace App;

use System\App\AppInitializer;

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