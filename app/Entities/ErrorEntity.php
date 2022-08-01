<?php

namespace App\Entities;

use Illuminate\Support\Facades\Validator;

class ErrorEntity extends Entity
{
    public function __construct(array $errorData)
    {
        Validator::make($errorData, [
            'message' => ['nullable', 'string'],
            'line' => ['required', 'integer'],
            'code' => ['nullable', 'integer'],
            'file' => ['required', 'string'],
        ])->validate();

        $this->data = $errorData;
    }
}
