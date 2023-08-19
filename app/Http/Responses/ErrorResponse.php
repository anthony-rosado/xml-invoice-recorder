<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ErrorResponse extends BaseResponse
{
    public function __construct(
        private readonly string $message = '',
        private readonly string $description = '',
        private readonly string $statusCode = Response::HTTP_BAD_REQUEST
    ) {
    }

    public function toResponse($request): JsonResponse|Response
    {
        return response()->json(
            [
                'message' => $this->message,
                'description' => $this->description,
            ],
            $this->statusCode
        );
    }
}
