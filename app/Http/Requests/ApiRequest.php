<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

/**
 * Class ApiRequest
 * @package App\Http\Requests
 */
abstract class ApiRequest extends FormRequest
{
    /**
     * @var ApiResponse
     */
    protected $apiResponse;

    /**
     * ApiRequest constructor.
     * @param ApiResponse $apiResponse
     */
    public function __construct(ApiResponse $apiResponse)
    {
        parent::__construct();
        $this->apiResponse = $apiResponse;
    }

    /**
     * @param Validator $validator
     * @return JsonResponse
     */
    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException($this->apiResponse
            ->setData([$validator->errors()])
            ->setFailureStatus(400)
            ->getResponse());
    }
}
