<?php declare(strict_types=1);

spl_autoload_register(function ($className) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $className) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

require_once __DIR__ . '/vendor/autoload.php';