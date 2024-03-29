<?php declare(strict_types=1);

namespace Controller;

use Service\TariffService;
use System\Container\DependencyContainer;
use System\Http\JsonResponse;
use System\Http\Request;
use System\Http\Response;
use System\Routing\Route;

final class TariffController extends AbstractController
{
    private TariffService $tariffService;
    private Request $request;

    public function __construct(private DependencyContainer $container)
    {
        $this->tariffService = $container->get(TariffService::class);
        $this->request = $container->get(Request::class);
    }

    #[Route('/tariff', method: 'GET')]
    public function find(): JsonResponse
    {
        if (!($id = (int)$this->request->get('id') ?? 0)) {
            $this->json(['Incorrect Id'], Response::CODE_ERROR);
        }

        $items = $this->tariffService->find($id);


        return $this->json([
            'items' => $items
        ]);
    }

    #[Route('/tariff', method: 'POST')]
    public function create()
    {

    }

    #[Route('/tariff', method: 'PUT')]
    public function update()
    {

    }

    #[Route('/tariff', method: 'DELETE')]
    public function delete()
    {

    }
}