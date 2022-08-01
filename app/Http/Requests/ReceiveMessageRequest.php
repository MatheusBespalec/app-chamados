<?php

namespace App\Http\Requests;

use App\Helpers\HttpStatusHelper\FileHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ReceiveMessageRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (!isset($this->file)) {
            return;
        }

        $fileData = base64_decode($this->file);
        if ($fileData) {
            $file = FileHelper::transformBase64ToFileToUploadedFile($fileData);
            $this->merge([
                'file' => $file,
            ]);
        }

        throw ValidationException::withMessages([
            'file' => trans('validation.base64'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'text' => ['string'],
            'file' => ['file'],
            'from' => ['required', 'string'],
            'uuid' => ['required', 'uuid', 'exists:customer_project,uuid'],
            'call_uuid' => ['required', 'uuid', 'exists:calls,uuid']
        ];
    }
}
