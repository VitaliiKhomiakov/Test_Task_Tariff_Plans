<?php

declare(strict_types=1);

namespace Util\Interface;

interface DescriptionHandlerInterface
{
    public function processObsceneWords(array $obsceneWords, string $text): string;
}