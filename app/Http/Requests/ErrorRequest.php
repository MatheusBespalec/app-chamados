<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ErrorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'uuid' => ['bail', 'required', 'uuid', 'exists:customer_project,uuid'],
            'url' => ['required', 'string'],
            'request_data' => ['required', 'array'],
            'error_data' => ['required', 'array']

            // 'aditional_data' => ['json'],
            // 'raw_body' => ['json'],
            // 'server' => ['json'],
            // 'request' => ['json'],
            // 'session' => ['json'],
            // 'cookie' => ['json'],
            // 'headers' => ['json'],

            // 'message' => ['string'],
            // 'line' => ['integer'],
            // 'code' => ['integer'],
            // 'file' => ['string'],
            // 'trace' => ['json'],
        ];
    }
}
