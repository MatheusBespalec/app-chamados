<?php

namespace App\Models;

use App\Models\Interfaces\Messageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model implements Messageable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'uuid',
        'description',
        'status',
        'from',
        'category',
        'customer_id',
        'project_id',
        'user_id'
    ];

    /**
     * Get the project that owns the call.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the customer that owns the call.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get all of the call messages.
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
}
