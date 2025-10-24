<?php

declare(strict_types=1);

namespace System\Http;

use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class JsonResponse extends Response
{
    public function json(): string
    {
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code($this->status);
        }

        $serializer = new Serializer([new ObjectNormalizer()]);
        return new JsonEncode()->encode($serializer->normalize($this->data), JsonEncoder::FORMAT);
    }
}
