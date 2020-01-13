<?php

declare(strict_types=1);

namespace App\Http\Requests;

/**
 * Class Review
 * @package App\Http\Requests
 */
class Review extends ApiRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'review' => 'string',
            'rating' => 'required|numeric|between:1,5',
            'zoo_id' => 'required|numeric',
        ];
    }
}
