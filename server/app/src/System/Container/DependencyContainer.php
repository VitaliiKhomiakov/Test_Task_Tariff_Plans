<?php

namespace System\Container;

class DependencyContainer
{
    private array $container = [];

    public function bind($key, $params): void
    {
        $this->container[$key] = $params;
    }

    public function get($key)
    {
        if (isset($this->container[$key])) {
            return new $this->container[$key]($this->container[$key]);
        }

        throw new \Exception('Unregistered repository');
    }
}