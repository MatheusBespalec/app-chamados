<?php

namespace App\Models;

use App\Interfaces\Messageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attack extends Model implements Messageable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'controller', 'action', 'url'];

    /**
     * Get all of the attacks logs.
     */
    public function logs()
    {
        return $this->morphMany(Log::class, 'logable');
    }

    /**
     * Get all of the attacks messages.
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
}
