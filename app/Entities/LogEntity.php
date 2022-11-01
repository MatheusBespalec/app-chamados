<?php

namespace App\Entities;

use Illuminate\Support\Facades\Validator;

class LogEntity extends Entity
{
    public function __construct(array $logData)
    {
        Validator::make($logData, [
            'additional_data' => ['nullable','json'],
            'raw_body' => ['nullable', 'json'],
            'server' => ['required', 'json'],
            'request' => ['nullable', 'json'],
            'headers' => ['nullable', 'json'],
            'session' => ['nullable', 'json'],
        ])->validate();

        $this->data = [
            'additional_data' => $logData['additional_data'],
            'raw_body' => $logData['raw_body'],
            'server' => $logData['server'],
            'request' => $logData['request'],
            'headers' => $logData['headers'],
            'session' => $logData['session'],
        ];
    }
}
