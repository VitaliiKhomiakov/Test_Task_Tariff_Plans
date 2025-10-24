<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\DTO\TariffDTO;
use Infrastructure\Notification\Message;
use Domain\Service\TariffService;
use App\Container\DependencyContainer;
use Infrastructure\Http\JsonResponse;
use Infrastructure\Http\Request;
use Infrastructure\Http\Response;
use App\Routing\Route;
use Application\Validator\Request\TariffIdValidator;
use Application\Validator\Request\TariffValidator;

final class TariffController extends AbstractController
{
    private TariffService $tariffService;
    private Request $request;
    private TariffIdValidator $tariffIdValidator;
    private TariffValidator $tariffValidator;

    public function __construct(private readonly DependencyContainer $container)
    {
        $this->tariffService = $this->container->get(TariffService::class);
        $this->request = $this->container->get(Request::class);
        $this->tariffIdValidator = new TariffIdValidator();
        $this->tariffValidator = new TariffValidator();
    }

    #[Route('/tariff', method: 'GET')]
    public function find(): JsonResponse
    {
        $id = $this->getRequestId();

        if ($id === null) {
            return $this->getAllTariffs();
        }

        return $this->getTariffById($id);
    }

    #[Route('/tariff', method: 'POST')]
    public function create(): JsonResponse
    {
        $tariffData = $this->request->all();

        if ($errors = $this->tariffValidator->validate($tariffData)) {
            return $this->errorResponse($errors);
        }

        try {
            $tariffId = $this->tariffService->create(new TariffDTO($tariffData));
            return $this->successResponse(['id' => $tariffId], Response::CODE_CREATED);
        } catch (\Exception $exception) {
            return $this->errorResponse([$exception->getMessage()]);
        }
    }

    #[Route('/tariff', method: 'PUT')]
    public function update(): JsonResponse
    {
        $id = $this->getRequestId();
        if ($id === null) {
            return $this->errorResponse(['ID is required']);
        }

        $tariffData = $this->request->all();

        if ($errors = $this->tariffValidator->validate($tariffData)) {
            return $this->errorResponse($errors);
        }

        try {
            $this->tariffService->update($id, new TariffDTO($tariffData));
            return $this->successResponse(['message' => Message::TARIFF_UPDATED]);
        } catch (\Exception $exception) {
            return $this->errorResponse([$exception->getMessage()]);
        }
    }

    #[Route('/tariff', method: 'DELETE')]
    public function delete(): JsonResponse
    {
        $id = $this->getRequestId();
        if ($id === null) {
            return $this->errorResponse(['ID is required']);
        }

        try {
            $this->tariffService->delete($id);
            return $this->successResponse(['message' => Message::TARIFF_DELETED]);
        } catch (\Exception $exception) {
            return $this->errorResponse([$exception->getMessage()]);
        }
    }

    private function getRequestId(): ?int
    {
        $id = $this->request->get('id');
        return $id ? (int)$id : null;
    }

    private function getAllTariffs(): JsonResponse
    {
        $items = $this->tariffService->findAll();
        return $this->successResponse([
            'items' => array_map(fn($item) => $item->toArray(), $items)
        ]);
    }

    private function getTariffById(int $id): JsonResponse
    {
        if ($errors = $this->tariffIdValidator->validate($id)) {
            return $this->errorResponse($errors);
        }

        $item = $this->tariffService->find($id);
        if (!$item) {
            return $this->errorResponse([Message::NOT_FOUND], Response::CODE_NOT_FOUND);
        }

        return $this->successResponse(['item' => $item->toArray()]);
    }

}
