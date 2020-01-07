<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

/**
 * Class ApiResponse
 * @package App\Helpers
 */
class ApiResponse
{
    /**
     * @var bool
     */
    private $success = false;
    /**
     * @var int
     */
    private $statusCode;
    /**
     * @var string
     */
    private $message = "";
    /**
     * @var array
     */
    private $data = [];

    /**
     * @return JsonResponse
     */
    public function getResponse(): JsonResponse
    {
        return response()->json([
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
        ], $this->statusCode);
    }

    /**
     * @param int $statusCode
     * @return ApiResponse
     */
    public function setFailureStatus(int $statusCode): ApiResponse
    {
        $this->success = false;
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return ApiResponse
     */
    public function setSuccessStatus(): ApiResponse
    {
        $this->success = true;
        $this->statusCode = 200;
        return $this;
    }

    /**
     * @param string $message
     * @return ApiResponse
     */
    public function setMessage(string $message): ApiResponse
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param array $data
     * @return ApiResponse
     */
    public function setData(array $data): ApiResponse
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
