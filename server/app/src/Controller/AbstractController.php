<?php declare(strict_types=1);

namespace Controller;

use System\Http\JsonResponse;

abstract class AbstractController
{
    protected function json(array $data = [], int $status = 200): JsonResponse
    {
        return new JsonResponse($data, $status);
    }
}