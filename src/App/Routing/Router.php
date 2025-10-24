<?php

declare(strict_types=1);

namespace App\Routing;

use App\Container\DependencyContainer;
use Infrastructure\Http\JsonResponse;
use Infrastructure\Http\Response;

class Router
{
    private array $routes = [];

    public function __construct(private readonly DependencyContainer $container) {}

    public function addRoute(string $path, string $controller): self
    {
        $this->routes[$path] = $controller;
        return $this;
    }

    public function handleRequest(string $requestUri): JsonResponse
    {
        $path = $this->extractPathFromUri($requestUri);

        if (!$this->isRouteRegistered($path)) {
            return $this->notFound('Route not found');
        }

        try {
            $controller = $this->routes[$path];
            $reflection = new \ReflectionClass($controller);
            $response = $this->executeController($reflection, $path);

            return $response ?? new JsonResponse([]);
        } catch (\ReflectionException $e) {
            return $this->handleReflectionException($e);
        }
    }

    private function extractPathFromUri(string $requestUri): string
    {
        return parse_url($requestUri, PHP_URL_PATH) ?? '';
    }

    private function isRouteRegistered(string $path): bool
    {
        return isset($this->routes[$path]);
    }

    private function handleReflectionException(\ReflectionException $e): JsonResponse
    {
        http_response_code(400);
        return new JsonResponse(['error' => $e->getMessage()], Response::CODE_ERROR);
    }

    private function executeController(\ReflectionClass $reflection, string $path): ?JsonResponse
    {
        $methods = $reflection->getMethods();

        foreach ($methods as $method) {
            $routeAttribute = $this->findMatchingRouteAttribute($method, $path);

            if ($routeAttribute !== null) {
                $instance = $this->createControllerInstance($reflection);
                return $routeAttribute->execute($method, $instance);
            }
        }

        return null;
    }

    private function findMatchingRouteAttribute(\ReflectionMethod $method, string $path): ?Route
    {
        $attributes = $method->getAttributes(Route::class);

        foreach ($attributes as $attribute) {
            $routeAttribute = $attribute->newInstance();
            if ($routeAttribute instanceof Route && $routeAttribute->matches($path, $_SERVER['REQUEST_METHOD'] ?? 'GET')) {
                return $routeAttribute;
            }
        }

        return null;
    }

    private function createControllerInstance(\ReflectionClass $reflection): object
    {
        if ($reflection->hasMethod('__construct')) {
            return $reflection->newInstance($this->container);
        }

        return $reflection->newInstance();
    }

    private function notFound(string $message = ''): JsonResponse
    {
        return new JsonResponse(['error' => $message], Response::CODE_NOT_FOUND);
    }
}
