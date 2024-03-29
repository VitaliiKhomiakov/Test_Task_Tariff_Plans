<?php declare(strict_types=1);

namespace System\Routing;

use System\Container\DependencyContainer;
use System\Http\JsonResponse;

class Router
{
    private array $routes = [];
    private DependencyContainer $container;

    public function setContainer(DependencyContainer $container): self
    {
        $this->container = $container;
        return $this;
    }

    public function addRoute(string $path, string $controller): self
    {
        $this->routes[$path] = $controller;
        return $this;
    }

    public function handleRequest(string $path): JsonResponse
    {
        $path = parse_url($_SERVER['REQUEST_URI'])['path'];
        if (!isset($this->routes[$path])) {
            return $this->notFound('Route not found');
        }

        $controller = $this->routes[$path];

        try {
            $reflection = new \ReflectionClass($controller);
            return $this->executeController($reflection, $path) ?? new JsonResponse([]);
        } catch (\ReflectionException $e) {
            http_response_code(400);
            throw new \Exception($e->getMessage());
        }
    }

    private function executeController(\ReflectionClass $reflection, string $path): ?JsonResponse
    {
        $methods = $reflection->getMethods();

        foreach ($methods as $method) {
            $attributes = $method->getAttributes(Route::class);

            if (!empty($attributes)) {
                foreach ($attributes as $attribute) {
                    $routeAttribute = $attribute->newInstance();
                    if ($routeAttribute->matches($path, $_SERVER['REQUEST_METHOD'])) {
                        if ($reflection->hasMethod('__construct')) {
                            $instance = $reflection->newInstance($this->container);
                            $instance->__construct($this->container);
                        }

                        return $routeAttribute->execute($method, $instance ?? null);
                    }
                }
            }
        }

        return null;
    }

    private function notFound(string $message = ''): JsonResponse
    {
        http_response_code(404);
        return new JsonResponse(['error' => $message]);
    }
}
