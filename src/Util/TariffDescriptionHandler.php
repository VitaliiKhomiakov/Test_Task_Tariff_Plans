<?php declare(strict_types=1);

namespace Util;

use Util\Interface\DescriptionHandlerInterface;

class TariffDescriptionHandler implements DescriptionHandlerInterface
{
    public function processObsceneWords(array $obsceneWords, string $text): string
    {
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
        return preg_replace('/(http[s]?:\/\/\S+)/', '<a href=\"$1\">$1</a>', $text);
    }
}