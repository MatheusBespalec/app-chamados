<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
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
     * Get the modules for the project.
     */
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    /**
     * The customers that belong to the project.
     */
    public function customers()
    {
        return $this->belongsToMany(Customer::class)->withPivot(['uuid']);
    }
}
