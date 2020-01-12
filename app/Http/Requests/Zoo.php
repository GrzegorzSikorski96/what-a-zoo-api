<?php

declare(strict_types=1);

namespace App\Http\Requests;

/**
 * Class Zoo
 * @package App\Http\Requests
 */
class Zoo extends ApiRequest
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
            'name' => 'required',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ];
    }
}
