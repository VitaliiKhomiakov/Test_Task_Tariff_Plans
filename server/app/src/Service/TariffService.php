<?php declare(strict_types=1);

namespace Service;

use Repository\TariffRepository;
use Repository\TariffTypeRepository;
use Service\DTO\TariffDTO;
use System\Container\DependencyContainer;

class TariffService
{
    private TariffRepository $tariffRepository;
    private TariffTypeRepository $tariffTypeRepository;
    private MailService $mailService;

    public function __construct(private readonly DependencyContainer $container)
    {
        $this->tariffRepository = $this->container->get(TariffRepository::class);
        $this->tariffTypeRepository = $this->container->get(TariffTypeRepository::class);
        $this->mailService = $this->container->get(MailService::class);
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

        $this->mailService->tariffNotification();

        return $tariffId;
    }

    public function processTariff(TariffDTO $data): TariffDTO
    {
        $description = $this->processObsceneWords([], $data->description);
        $description = $this->processImages($description);
        $data->description = $this->processLinks($description);
        return $data;
    }

    public function processObsceneWords(array $obsceneWords, string $text): string
    {
        $obsceneWords = array("badword1", "badword2", "badword3");

        $text = "Это текст с матерными словами: badword1, а также с <img src='image.jpg'> тэгом img и URL: https://example.com.";

        foreach ($obsceneWords as $word) {
            $text = preg_replace("/\b" . $word . "\b/iu", "...", $text);
        }

        return $text;
    }

    public function processImages(string $text): string
    {
        return preg_replace('/<img[^>]+\>/i', '', $text);
    }

    public function processLinks(string $text): string
    {
        return $description = preg_replace('/(http[s]?:\/\/\S+)/', '<a href=\"$1\">$1</a>', $text);
    }

}