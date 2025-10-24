<?php

declare(strict_types=1);

namespace Controller;

use DTO\TariffDTO;
use Notification\Message;
use Service\TariffService;
use System\Container\DependencyContainer;
use System\Http\JsonResponse;
use System\Http\Request;
use System\Http\Response;
use System\Routing\Route;
use Validator\Request\TariffIdValidator;
use Validator\Request\TariffValidator;

final class TariffController extends AbstractController
{
    private TariffService $tariffService;
    private Request $request;

    public function __construct(private readonly DependencyContainer $container)
    {
        $this->tariffService = $this->container->get(TariffService::class);
        $this->request = $this->container->get(Request::class);
    }

    #[Route('/tariff', method: 'GET')]
    public function find(): JsonResponse
    {
        $id = $this->request->get('id');

        if ($id === null) {
            $items = $this->tariffService->findAll();
            return $this->json([
                'items' => array_map(fn($item) => $item->toArray(), $items)
            ]);
        }

        $id = (int)$id;
        if ($errors = new TariffIdValidator()->validate($id)) {
            return $this->json(['errors' => $errors], Response::CODE_ERROR);
        }

        if (!($item = $this->tariffService->find($id))) {
            return $this->json(['errors' => Message::NOT_FOUND], Response::CODE_NOT_FOUND);
        }

        return $this->json([
            'item' => $item->toArray()
        ]);
    }

    #[Route('/tariff', method: 'POST')]
    public function create(): JsonResponse
    {
        $tariffData = $this->request->all();

        if ($errors = new TariffValidator()->validate($tariffData)) {
            return $this->json(['errors' => $errors], Response::CODE_ERROR);
        }

        try {
            $tariffId = $this->tariffService->create(new TariffDTO($tariffData));
        } catch (\Exception $exception) {
            return $this->json(['errors' => $exception->getMessage()], Response::CODE_ERROR);
        }

        return $this->json([
            'id' => $tariffId
        ], Response::CODE_CREATED);
    }

    #[Route('/tariff', method: 'PUT')]
    public function update(): JsonResponse
    {
        $id = (int)$this->request->get('id');
        if ($errors = new TariffIdValidator()->validate($id)) {
            return $this->json(['errors' => $errors], Response::CODE_ERROR);
        }

        $tariffData = $this->request->all();

        if ($errors = new TariffValidator()->validate($tariffData)) {
            return $this->json(['errors' => $errors], Response::CODE_ERROR);
        }

        try {
            $this->tariffService->update($id, new TariffDTO($tariffData));
        } catch (\Exception $exception) {
            return $this->json(['errors' => $exception->getMessage()], Response::CODE_ERROR);
        }

        return $this->json([
            'message' => Message::TARIFF_UPDATED
        ]);
    }

    #[Route('/tariff', method: 'DELETE')]
    public function delete(): JsonResponse
    {
        $id = (int)$this->request->get('id');

        if ($errors = new TariffIdValidator()->validate($id)) {
            return $this->json(['errors' => $errors], Response::CODE_ERROR);
        }

        try {
            $this->tariffService->delete($id);
        } catch (\Exception $exception) {
            return $this->json(['errors' => $exception->getMessage()], Response::CODE_ERROR);
        }

        return $this->json([
            'message' => Message::TARIFF_DELETED
        ]);
    }
}
