<?php

declare(strict_types=1);

namespace Application\Controller;

use Infrastructure\Http\JsonResponse;

abstract class AbstractController
{
    protected function json(array $data = [], int $status = 200): JsonResponse
    {
        return new JsonResponse($data, $status);
    }
}