<?php

namespace App\Repositories;

use App\Models\Whitelist;
use DateTimeInterface;


class WhitelistRepository
{
    public function create(string $ip, ?DateTimeInterface $expiration, ?string $description)
    {
        Whitelist::create([
            'ip' => $ip,
            'expiration' => is_null($expiration) ? null : $expiration->format('Y-m-d'),
            'description' => $description
        ]);
    }
}
