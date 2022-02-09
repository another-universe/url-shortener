<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShortenUrlRequest extends FormRequest
{
    /**
     * Get data to be validated from the request.
     */
    public function validationData(): array
    {
        return $this->only(['url']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'url' => [
                'bail', 'required', 'string', 'max:2048', 'url', 'regex:~^http(?:s)?\\:~u',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'required' => 'Enter url.',
            'string' => 'The url must be a string.',
            'max' => 'The url must not be greater than :max characters.',
            'url' => 'The value is not a valid url.',
            'regex' => 'Only http or https schemes are allowed.',
        ];
    }
}
