<?php declare(strict_types=1);

namespace Service;

use Repository\TariffRepository;
use Repository\TariffTypeRepository;
use Service\DTO\TariffDTO;
use System\Container\DependencyContainer;
use Util\TariffDescriptionHandler;

class TariffService
{
    private TariffRepository $tariffRepository;
    private TariffTypeRepository $tariffTypeRepository;
    private MailService $mailService;
    private LogService $logService;

    public function __construct(private readonly DependencyContainer $container)
    {
        $this->tariffRepository = $this->container->get(TariffRepository::class);
        $this->tariffTypeRepository = $this->container->get(TariffTypeRepository::class);
        $this->mailService = $this->container->get(MailService::class);
        $this->logService = $this->container->get(LogService::class);
    }

    public function find(int $id): array
    {
        return $this->tariffRepository->find($id);
    }

    public function create(TariffDTO $data): int
    {
        if (!$this->tariffTypeRepository->find($data->typeId)) {
            throw new \Exception('Tariff type is not exist');
        }

        $data = $this->processTariff($data);
        $tariffId = $this->tariffRepository->create($data);

        $this->logService->create(['message' => 'Tariff name ' . $data->name . ' with Id ' . $tariffId . ' has been created']);
        $this->mailService->tariffNotification();

        return $tariffId;
    }

    public function processTariff(TariffDTO $data): TariffDTO
    {
        $descriptionHandler = new TariffDescriptionHandler();
        $description = $descriptionHandler->processObsceneWords([], $data->description);
        $description = $descriptionHandler->processImages($description);
        $data->description = $descriptionHandler->processLinks($description);
        return $data;
    }
}