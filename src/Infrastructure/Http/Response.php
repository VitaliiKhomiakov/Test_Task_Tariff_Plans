<?php

declare(strict_types=1);

namespace Infrastructure\Http;

class Response
{
    public const int CODE_SUCCESS = 200;
    public const int CODE_CREATED = 201;
    public const int CODE_NOT_FOUND = 404;
    public const int CODE_ERROR = 400;
    public const int CODE_SERVER_ERROR = 500;

    public function __construct(protected array $data, protected int $status = 200) {}
}