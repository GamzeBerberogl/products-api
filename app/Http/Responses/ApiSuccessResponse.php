<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ApiSuccessResponse implements Responsable
{
    public function __construct(
        private mixed $data,
        private array $metaData,
        private int $statusCode = Response::HTTP_CREATED,
        private array $headers = [],
        private int $options = 0
    ) {
    }

    public function toResponse($request)
    {
        return response()->json(
            [
                'data' => $this->data,
                'metaData' => $this->metaData
            ],
            $this->statusCode,
            $this->headers,
            $this->options
        );
    }
}