<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
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
        $fileData = base64_decode($this->file);
        if ($fileData) {
            $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
            file_put_contents($tmpFilePath, $fileData);

            $tmpFile = new File($tmpFilePath);

            $file = new UploadedFile(
                $tmpFile->getPathname(),
                $tmpFile->getFilename(),
                $tmpFile->getMimeType(),
                0,
                true
            );

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
