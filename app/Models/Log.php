<?php

namespace App\Models;

use Barryvdh\Debugbar\Facades\Debugbar;
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
        'raw_body',
        'server',
        'request',
        'headers',
        'trace',
        'additional_data',
        'project_id',
        'customer_id',
        'logable_id',
        'logable_type',
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
     * Get the customer that owns the log.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($log) {
            $log->logable_type::query()->whereId($log->logable_id)->update(['updated_at' => now()]);
        });
    }

    /**
     * Get all of the log messages.
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
}
