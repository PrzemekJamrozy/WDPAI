<?php

namespace Responses;

class ErrorResponse extends ApiResponse
{
    public function __construct(array $data, int $statusCode = 400)
    {
        parent::__construct($data, $statusCode);
    }

    protected function responseSchema(): array
    {
       return [
           'success' => false,
           'statusCode' => $this->statusCode,
           'data' => $this->data
       ];
    }

}