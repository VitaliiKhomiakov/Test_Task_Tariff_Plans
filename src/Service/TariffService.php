<?php

declare(strict_types=1);

namespace Service;

use DTO\TariffDTO;
use Model\Tariff;
use Notification\Message;
use Repository\TariffRepository;
use Repository\TariffTypeRepository;
use System\Container\DependencyContainer;
use Util\TariffDescriptionHandler;

class TariffService
{
    private TariffRepository $tariffRepository;
    private TariffTypeRepository $tariffTypeRepository;
    private MailService $mailService;
    private ObsceneWordService $obsceneWordService;
    private LogService $logService;
    private Message $notification;

    public function __construct(private readonly DependencyContainer $container)
    {
        $this->tariffRepository = $this->container->get(TariffRepository::class);
        $this->tariffTypeRepository = $this->container->get(TariffTypeRepository::class);
        $this->obsceneWordService = $this->container->get(ObsceneWordService::class);
        $this->mailService = $this->container->get(MailService::class);
        $this->logService = $this->container->get(LogService::class);
        $this->notification = $this->container->get(Message::class);
    }

    public function find(int $id): ?Tariff
    {
        try {
            return $this->tariffRepository->find($id);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function findAll(): array
    {
        return $this->tariffRepository->findAll();
    }

    public function create(TariffDTO $data): int
    {
        $this->checkTariffType($data->typeId);

        $data = $this->processTariff($data);
        $tariffId = $this->tariffRepository->create($data);

        $this->logService->create(['message' => $this->notification->createTariffMessage($data->name, $tariffId)]);
        $this->mailService->tariffNotification();

        return $tariffId;
    }

    public function update(int $id, TariffDTO $data): bool
    {
        $this->checkTariffType($data->typeId);

        $data = $this->processTariff($data);
        $result = $this->tariffRepository->update($id, $data);

        if (!$result) {
            throw new \Exception('Tariff not found');
        }

        $this->logService->create(['message' => $this->notification->updateTariffMessage($data->name, $id)]);

        return $result;
    }

    public function delete(int $id): bool
    {
        $result = $this->tariffRepository->delete($id);
        
        if (!$result) {
            throw new \Exception('Tariff not found');
        }
        
        return $result;
    }

    public function processTariff(TariffDTO $data): TariffDTO
    {
        $descriptionHandler = new TariffDescriptionHandler();
        $description= $this->obsceneWordService->filterObsceneWords($descriptionHandler, $data->description);
        $description = $descriptionHandler->processImages($description);
        $data->description = $descriptionHandler->processLinks($description);
        return $data;
    }

    private function checkTariffType(int $typeId): void
    {
        if (!$this->tariffTypeRepository->find($typeId)) {
            throw new \Exception(Message::TARIFF_NOT_EXIST);
        }
    }
}
