<?php declare(strict_types=1);

namespace Controller;
use System\Http\JsonResponse;
use System\Routing\Route;

final class HomeController extends AbstractController
{
    #[Route('/catalog', method: 'POST')]
    public function index(): JsonResponse
    {
        return $this->json(['id' => 'POST', 'data' => []]);
    }

    #[Route('/catalog', method: 'GET')]
    public function index2(): JsonResponse
    {
        return $this->json(['id' => 'GET', 'data' => []]);
    }
}