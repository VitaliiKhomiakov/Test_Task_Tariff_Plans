<?php declare(strict_types=1);

namespace Util;

class TariffDescriptionHandler
{
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