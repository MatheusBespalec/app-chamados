<?php

namespace App\Models;

use App\Models\Interfaces\Logable;
use App\Models\Interfaces\Messageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attack extends Model implements Messageable, Logable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'route'];

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
