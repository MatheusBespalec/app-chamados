<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Log;
use App\Models\Project;

class LogRepository
{
    public function create(string $rawBody, string $request, string $server, string $headers, string $trace, $logable, Customer $customer, Project $project): Log
    {
        return Log::create([
            'raw_body' => $rawBody,
            'server' => $server,
            'request' => $request,
            'headers' => $headers,
            'trace' => $trace,
            'customer_id' => $customer->id,
            'project_id' => $project->id,
            'logable_id' => $logable->id,
            'logable_type' => $logable::class,
        ]);
    }
}
