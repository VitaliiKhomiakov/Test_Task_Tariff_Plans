<?php

declare(strict_types=1);

namespace Application\Controller;

use Infrastructure\Http\JsonResponse;
use Infrastructure\Http\Response;

abstract class AbstractController
{
    protected function json(array $data = [], int $status = 200): JsonResponse
    {
        return new JsonResponse($data, $status);
    }

    protected function successResponse(array $data, int $status = Response::CODE_SUCCESS): JsonResponse
    {
        return $this->json($data, $status);
    }

    protected function errorResponse(array $errors, int $status = Response::CODE_ERROR): JsonResponse
    {
        return $this->json(['errors' => $errors], $status);
    }
}