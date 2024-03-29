<?php declare(strict_types=1);

namespace System\Http;

final class Request
{
    private array $queryParams;
    private array $request;

    public function __construct()
    {
        $this->queryParams = $_GET;

        $inputContent = [];
        $inputData = file_get_contents('php://input');
        parse_str($inputData, $inputContent);

        $this->request = [...$_POST, ...$inputContent];
    }

    public function get(string $key)
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