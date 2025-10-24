<?php

declare(strict_types=1);

namespace Application\Controller;

use Infrastructure\Http\JsonResponse;
use App\Routing\Route;

final class HomeController extends AbstractController
{
    #[Route('/', method: 'GET')]
    public function index(): JsonResponse
    {
        return $this->successResponse(['status' => 'It works']);
    }
}
