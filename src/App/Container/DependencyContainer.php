<?php

declare(strict_types=1);

namespace App\Container;

class DependencyContainer
{
    private array $container = [];
    private array $instances = [];

    public function bind(string $key, mixed $params): self
    {
        $this->container[$key] = $params;
        return $this;
    }

    public function get(string $key): mixed
    {
        if (isset($this->container[$key])) {
            return $this->instance($key);
        }

        throw new \Exception('Unregistered instance');
    }

    private function instance(string $key): mixed
    {
        if (isset($this->instances[$key])) {
            return $this->instances[$key];
        }

        $params = $this->container[$key];
        
        if (is_array($params)) {
            $this->instances[$key] = new $key(...$params);
        } else {
            $this->instances[$key] = new $key($params);
        }
        
        return $this->instances[$key];
    }
}