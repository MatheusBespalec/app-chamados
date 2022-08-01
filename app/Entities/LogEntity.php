<?php

namespace App\Entities;

use Illuminate\Support\Facades\Validator;

class LogEntity extends Entity
{
    public function __construct(array $logData)
    {
        Validator::make($logData, [
            'aditional_data' => ['nullable','json'],
            'raw_body' => ['nullable', 'json'],
            'server' => ['required', 'json'],
            'request' => ['nullable', 'json'],
            'headers' => ['nullable', 'json'],
            'trace' => ['nullable', 'json'],
        ])->validate();

        $this->data = $logData;
    }
}
