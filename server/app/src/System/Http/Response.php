<?php declare(strict_types=1);

namespace System\Http;

class Response
{
    const int CODE_SUCCESS = 200;
    const int CODE_CREATED = 201;
    const int CODE_NOT_FOUND = 404;
    const int CODE_ERROR = 400;

    public function __construct(protected array $data, protected int $status = 200) {}
}