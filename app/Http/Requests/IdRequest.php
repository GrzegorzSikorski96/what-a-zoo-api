<?php

declare(strict_types=1);

namespace App\Http\Requests;

/**
 * Class IdRequest
 * @package App\Http\Requests
 */
class IdRequest extends ApiRequest
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
            'id' => 'required|int',
        ];
    }
}
