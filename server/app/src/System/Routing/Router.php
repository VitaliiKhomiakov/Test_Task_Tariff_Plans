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

    public function addRoute(string $path, string $controller, string $method = 'GET'): self
    {
        $this->routes[$path][$method] = $controller;
        return $this;
    }

    public function handleRequest(string $path): JsonResponse
    {
        if (!isset($this->routes[$path][$_SERVER['REQUEST_METHOD']])) {
            return $this->notFound('Route not found');
        }

        $controller = $this->routes[$path][$_SERVER['REQUEST_METHOD']];

        try {
            $reflection = new \ReflectionClass($controller);
            if ($response = $this->methods($reflection, $path)) {
                return $response;
            }

            return $this->notFound('Method not found');
        } catch (\ReflectionException $e) {
            http_response_code(400);
            throw new \Exception($e->getMessage());
        }
    }

    private function methods(\ReflectionClass $reflection, string $path): ?JsonResponse
    {
        $methods = $reflection->getMethods();

        foreach ($methods as $method) {
            $attributes = $method->getAttributes(Route::class);
            if ($response = $this->execute($attributes, $method, $reflection, $path)) {
                return $response;
            }
        }

        return null;
    }

    private function execute(array $attributes, \ReflectionMethod $method, \ReflectionClass $reflection, string $path): ?JsonResponse
    {
        foreach ($attributes as $attribute) {
            $routeAttribute = $attribute->newInstance();

            if ($routeAttribute->matches($path, $_SERVER['REQUEST_METHOD'])) {
                if ($reflection->hasMethod('__construct')) {
                    $instance = $reflection->newInstance($this->container);
                    $parameters = $method->getParameters();
                    foreach ($parameters as $parameter) {
                        if ($parameter->getType() && $parameter->getType()->getName() === DependencyContainer::class) {
                            $instance->__construct($this->container);
                        }
                    }
                }

                return $routeAttribute->execute($method, $instance);
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
