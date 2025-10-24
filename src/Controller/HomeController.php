<?php declare(strict_types=1);

namespace Controller;
use System\Http\JsonResponse;
use System\Routing\Route;

final class HomeController extends AbstractController
{
    #[Route('/', method: 'GET')]
    public function index(): JsonResponse
    {
        return $this->json(['status' => 'It works']);
    }
}