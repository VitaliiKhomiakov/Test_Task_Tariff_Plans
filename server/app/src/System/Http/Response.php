<?php declare(strict_types=1);

namespace System\Http;

class Response
{
    public function __construct(protected array $data) {}
}