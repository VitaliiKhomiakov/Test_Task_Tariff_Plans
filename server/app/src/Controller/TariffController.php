<?php declare(strict_types=1);

namespace Controller;

use Service\DTO\TariffDTO;
use Service\TariffService;
use System\Container\DependencyContainer;
use System\Http\JsonResponse;
use System\Http\Request;
use System\Http\Response;
use System\Routing\Route;
use Validator\Request\TariffValidator;

final class TariffController extends AbstractController
{
    private TariffService $tariffService;
    private Request $request;

    public function __construct(private DependencyContainer $container)
    {
        $this->tariffService = $this->container->get(TariffService::class);
        $this->request = $this->container->get(Request::class);
    }

    #[Route('/tariff', method: 'GET')]
    public function find(): JsonResponse
    {
        if (!($id = (int)$this->request->get('id') ?? 0)) {
            return $this->json(['errors' => ['Incorrect Id']], Response::CODE_ERROR);
        }

        if (!($items = $this->tariffService->find($id))) {
            return $this->json(['errors' => ['Not Found']], Response::CODE_NOT_FOUND);
        }

        return $this->json([
            'items' => $items
        ]);
    }

    #[Route('/tariff', method: 'POST')]
    public function create(): JsonResponse
    {
        $tariffData = $this->request->all();

        if ($errors = (new TariffValidator())->validate($this->request->all())) {
            return $this->json(['errors' => $errors], Response::CODE_ERROR);
        }

        try {
            $tariff = $this->tariffService->create(new TariffDTO($tariffData));
        } catch (\Exception $exception) {
            return $this->json(['errors' => $exception->getMessage()], Response::CODE_ERROR);
        }

        return $this->json([
            'id' => $tariff
        ], Response::CODE_CREATED);
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