<?php

namespace App\Http\Responses;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ApiErrorResponse implements Responsable
{
    public function __construct(
        private ?Exception $exception,
        private string $message,
        private int $statusCode = Response::HTTP_BAD_REQUEST,
        private array $headers = [],
        private int $options = 0
    ) {
    }

    public function toResponse($request)
    {
        $response = ['message' => $this->message];

        if (!empty($this->exception) && config('app.debug')) {
            $response['debug'] = [
                'message' => $this->exception->getMessage(),
                'file' => $this->exception->getFile(),
                'line' => $this->exception->getLine(),
                'trace' => $this->exception->getTrace()
            ];
        }

        return response()->json(
            $response,
            $this->statusCode,
            $this->headers,
            $this->options
        );
    }
}