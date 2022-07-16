<?php

namespace App\Repositories;

use App\Models\Error;
use App\Models\Customer;
use App\Models\Log;

class ErrorRepository
{
    public function create(int $code, string $message, string $file, int $line, string $url, mixed $trace, array $requestData, Customer $customer): Error
    {
        $error = Error::query()
            ->whereMessage($message)
            ->whereTrace($trace)
            ->whereUrl($url)
            ->first();

        if (is_null($error)) {
            // Notify new error?
            $error = Error::create([
                'code' => $code,
                'message' => $message,
                'file' => $file,
                'line' => $line,
                'url' => $url,
                'trace' => $trace,
            ]);
        }

        Log::create([
            'raw_body' => $requestData['raw_body'] ?? null,
            'var_server' => $requestData['server'] ?? null,
            'var_get' => $requestData['get'] ?? null,
            'var_post' => $requestData['post'] ?? null,
            'var_request' => $requestData['request'] ?? null,
            'var_files' => $requestData['files'] ?? null,
            'var_session' => $requestData['session'] ?? null,
            'var_cookie' => $requestData['cookie'] ?? null,
            'var_headers' => $requestData['headers'] ?? null,
            'var_env' => $requestData['env'] ?? null,
            'http_method' => $requestData['method'] ?? null,
            'customer_id' => $customer->id,
            'logable_id' => $error->id,
            'logable_type' => $error::class,
        ]);

        return $error;
    }
}
