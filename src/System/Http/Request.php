<?php

declare(strict_types=1);

namespace System\Http;

final class Request
{
    private array $queryParams;
    private array $request;

    public function __construct()
    {
        $this->queryParams = $_GET;
        $input = file_get_contents('php://input');
        $inputData = $input ? (json_decode($input, true, 512, JSON_THROW_ON_ERROR) ?? []) : [];
        $this->request = [...$_POST, ...$inputData];
    }

    public function get(string $key): mixed
    {
        if (isset($this->queryParams[$key])) {
            return $this->queryParams[$key];
        }

        if (isset($this->request[$key])) {
            return $this->request[$key];
        }

        return null;
    }

    public function all(): array
    {
        return [...$this->queryParams, ...$this->request];
    }
}
