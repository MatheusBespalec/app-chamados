<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'http_method',
        'raw_body',
        'var_server',
        'var_get',
        'var_post',
        'var_request',
        'var_files',
        'var_session',
        'var_cookie',
        'var_headers',
        'var_env',
        'data'
    ];

    /**
     * Get the parent commentable model (App\Models\Attack or App\Models\Error).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function logable()
    {
        return $this->morphTo();
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($log) {
            $log->logable->update(['updated_at' => now()]);
        });
    }
}
