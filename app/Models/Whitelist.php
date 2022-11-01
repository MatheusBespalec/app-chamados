<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Whitelist extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip',
        'expiration',
        'description',
    ];

    public function scopeNotExpired($query)
    {
        $query->where(function($query) {
            $query->whereNull('expiration')
                ->orWhere('expiration', '>=', date('Y-m-d'));
        });
    }

    public static function checkIp($ip): bool
    {
        return self::query()->notExpired()->whereIp($ip)->count() > 0;
    }
}
