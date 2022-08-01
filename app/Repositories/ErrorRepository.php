<?php

namespace App\Repositories;

use App\Entities\ErrorEntity;
use App\Entities\LogEntity;
use App\Models\Error;
use App\Models\Customer;
use App\Models\Project;

class ErrorRepository
{
    public function insertOrUpdate(ErrorEntity $errorEntity, LogEntity $logEntity, string $url, Customer $customer, Project $project): Error
    {
        $error = Error::query()
            ->whereMessage($errorEntity->get('message'))
            ->whereLine($errorEntity->get('line'))
            ->whereUrl($url)
            ->first();

        if (is_null($error)) {
            $error = Error::create([
                'message' => $errorEntity->get('message'),
                'file' => $errorEntity->get('file'),
                'code' => $errorEntity->get('code'),
                'line' => $errorEntity->get('line'),
                'url' => $url,
            ]);
        }

        (new LogRepository)->create(
            $logEntity->get('raw_body'),
            $logEntity->get('request'),
            $logEntity->get('server'),
            $logEntity->get('headers'),
            $logEntity->get('trace'),
            $error,
            $customer,
            $project,
        );

        return $error;
    }
}
