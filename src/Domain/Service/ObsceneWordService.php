<?php

declare(strict_types=1);

namespace Domain\Service;

use Domain\Repository\ObsceneWordRepository;
use App\Container\DependencyContainer;
use Infrastructure\Util\Interface\DescriptionHandlerInterface;

class ObsceneWordService
{
    private const int OBSCENE_WORDS_LIMIT = 50;

    private ObsceneWordRepository $obsceneWordRepository;

    public function __construct(readonly DependencyContainer $container)
    {
        $this->obsceneWordRepository = $container->get(ObsceneWordRepository::class);
    }

    public function filterObsceneWords(DescriptionHandlerInterface $descriptionHandler, string $text): string
    {
        $lastId = 0;

        while ($words = $this->obsceneWordRepository->findBy($lastId, self::OBSCENE_WORDS_LIMIT)) {
            $text= $descriptionHandler->processObsceneWords(
                array_map(static fn($item) => $item->getName(), $words),
                $text
            );
            $lastId = end($words)->getId();
        }

        return $text;
    }
}
