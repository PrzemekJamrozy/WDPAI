<?php

namespace Responses;

class SuccessResponse extends ApiResponse
{


    public function __construct(array $data, int $statusCode = 200)
    {
        parent::__construct($data, $statusCode);
    }

    protected function responseSchema(): array
    {
        return [
            'success' => true,
            'statusCode' => $this->statusCode,
            'data' => $this->data,
        ];
    }
}