<?php

namespace App\Repositories;

use App\Models\Attack;
use App\Models\Customer;
use App\Models\Log;

class AttackRepository
{
    public function create(string $description, string $controller,  string $action, string $url, array $requestData, Customer $customer): Attack
    {
        $attack = Attack::query()
            ->whereDescription($description)
            ->whereController($controller)
            ->whereAction($action)
            ->whereUrl($url)
            ->first();

        if (is_null($attack)) {
            // Notify new error?
            $attack = Attack::create([
                'description' => $description,
                'controller' => $controller,
                'action' => $action,
                'url' => $url,
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
            'var_env' => $requestData['method'] ?? null,
            'customer_id' => $customer->id,
            'logable_id' => $attack->id,
            'logable_type' => $attack::class,
        ]);

        return $attack;
    }
}
