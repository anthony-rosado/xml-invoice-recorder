<?php

namespace App\Http\Responses;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ErrorResponse extends BaseResponse
{
    public function __construct(
        private readonly string $message = '',
        private readonly ?string $description = null,
        private readonly string $statusCode = Response::HTTP_BAD_REQUEST
    ) {
    }

    public static function fromException(Exception $exception): ErrorResponse
    {
        return new self(
            $exception->getMessage(),
            $exception->getPrevious()?->getMessage(),
            $exception->getCode()
        );
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
