<?php

namespace System\Container;

class DependencyContainer
{
    private array $container = [];
    private array $instances = [];

    public function bind($key, $params): self
    {
        $this->container[$key] = $params;
        return $this;
    }

    public function get($key)
    {
        if (isset($this->container[$key])) {
            return $this->instance($key);
        }

        throw new \Exception('Unregistered repository');
    }

    private function instance($key)
    {
        $this->instances[$key] ??= new $key($this->container[$key]);
        return $this->instances[$key];
    }
}