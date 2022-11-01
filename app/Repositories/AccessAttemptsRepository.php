<?php

namespace App\Repositories;

use App\Models\AccessAttempts;
use DateTime;
use Illuminate\Support\Str;

class AccessAttemptsRepository
{
    public function create(string $ip): AccessAttempts
    {
        $date = new DateTime();
        $date->modify('+5 minutes');
        return AccessAttempts::create([
            'ip' => $ip,
            'token' => Str::uuid(),
            'expiration' => $date->format('Y-m-d H:i:s'),
        ]);
    }
}
