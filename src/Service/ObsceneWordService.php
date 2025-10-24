<?php declare(strict_types=1);

namespace Service;

use Repository\ObsceneWordRepository;
use System\Container\DependencyContainer;
use Util\Interface\DescriptionHandlerInterface;

class ObsceneWordService
{
    const int OBSCENE_WORDS_LIMIT = 50;

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
                array_map(fn($item) => $item->getName(), $words),
                $text
            );
            $lastId = end($words)->getId();
        }

        return $text;
    }
}