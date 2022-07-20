<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['file_path', 'text', 'from', 'external', 'user_id', 'messageable_type', 'messageable_id'];

    /**
     * Get the parent noteable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function messageable()
    {
        return $this->morphTo();
    }

    /**
     * Get the customer that owns the note.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
