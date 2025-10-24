<?php

declare(strict_types=1);

namespace System\Routing;

#[\Attribute(\Attribute::TARGET_METHOD)]
final readonly class Route
{
    public function __construct(private string $path, private string $method = 'GET') {}

    public function matches(string $requestPath, string $requestMethod): bool
    {
        return rtrim($requestPath, '/') === rtrim($this->path, '/') && $requestMethod === $this->method;
    }

    public function execute(\ReflectionMethod $method, object $instance): mixed
    {
        return $method->invoke($instance);
    }
}
