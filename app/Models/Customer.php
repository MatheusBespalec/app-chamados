<?php

namespace App\Models;

use App\Models\Interfaces\Messageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model implements Messageable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get all of the customer messages.
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    /**
     * The projects that belong to the customer.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot(['uuid']);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    /**
     * The customers that belong to the project.
     */
    public function bancoDigital()
    {
        return $this->hasOne(BancoDigital::class);
    }
}
