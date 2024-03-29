<?php declare(strict_types=1);

namespace System\Http;

use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

final class JsonResponse extends Response
{
    public function json(): string
    {
        header('Content-Type: application/json; charset=utf-8');
        return (new JsonEncode())->encode($this->data, JsonEncoder::FORMAT);
    }
}