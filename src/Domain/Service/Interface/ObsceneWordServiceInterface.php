<?php

declare(strict_types=1);

namespace Domain\Service\Interface;

use Infrastructure\Util\Interface\DescriptionHandlerInterface;

interface ObsceneWordServiceInterface
{
    public function filterObsceneWords(DescriptionHandlerInterface $descriptionHandler, string $text): string;
}
