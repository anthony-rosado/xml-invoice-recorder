<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SuccessResponse extends BaseResponse
{
    public function __construct(
        private readonly string $message = '',
        private readonly mixed $data = null,
        private readonly string $statusCode = Response::HTTP_OK
    ) {
    }

    public function toResponse($request): JsonResponse|Response
    {
        return response()->json(
            [
                'message' => $this->message,
                'data' => $this->data,
            ],
            $this->statusCode
        );
    }
}
