<?php

declare(strict_types=1);

namespace Domain\Service;

use Application\DTO\TariffDTO;
use Infrastructure\Util\Interface\DescriptionHandlerInterface;

final readonly class TariffDescriptionService
{
    public function __construct(
        private ObsceneWordService $obsceneWordService,
        private DescriptionHandlerInterface $descriptionHandler
    ) {}

    public function processTariff(TariffDTO $data): TariffDTO
    {
        $description = $this->obsceneWordService->filterObsceneWords($this->descriptionHandler, $data->description);
        $description = $this->descriptionHandler->processImages($description);
        $data->description = $this->descriptionHandler->processLinks($description);

        return $data;
    }
}
