<?php

namespace Responses;

abstract class ApiResponse
{

    /**
     * @param array<string,mixed> $data
     */
    public function __construct(protected array $data, protected int $statusCode)
    {
    }

    public function toJson(): string|false
    {
        header('Content-type: application/json');
        return json_encode($this->responseSchema());
    }

    protected abstract function responseSchema(): array;
}