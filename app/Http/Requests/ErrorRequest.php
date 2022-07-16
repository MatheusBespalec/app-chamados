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
            'customer_uuid' => ['bail', 'required', 'uuid', 'exists:customers,uuid'],
            'request_data' => ['required', 'json'],
            'message' => ['required', 'string'],
            'line' => ['required', 'integer'],
            'code' => ['required', 'integer'],
            'file' => ['required', 'string'],
            'url' => ['required', 'string'],
            'trace' => ['required', 'json'],
        ];
    }
}
